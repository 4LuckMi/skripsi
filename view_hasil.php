<?php
// File: view_hasil.php
session_start();

// ==============================================
// KONEKSI DATABASE
// ==============================================
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'sepedalistrik';

try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// ==============================================
// AMBIL DATA DIAGNOSA
// ==============================================
$result = [];
if(isset($_GET['id'])) {
    try {
        $stmt = $db->prepare("
            SELECT h.*, k.nama_kerusakan 
            FROM hasil_diagnosa h
            JOIN kerusakan k ON h.id_kerusakan = k.id
            WHERE h.id = :id
        ");
        $stmt->execute([':id' => $_GET['id']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        die("Error mengambil data: " . $e->getMessage());
    }
}

if(empty($result)) {
    die("Data diagnosa tidak ditemukan");
}

// Format tanggal
$tanggal = date('d F Y H:i', strtotime($result['tanggal']));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Diagnosa Anda</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 20px;
            background-color: #f8f9fa;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .result-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 2rem;
        }

        .result-item {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-label {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .result-value {
            font-size: 1.1rem;
            color: #333;
        }

        .solution-box {
            background: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 4px;
        }
        
        .answer-item {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            background: #f9f9f9;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Hasil Diagnosa Anda</h1>
        <p>Tanggal: <?= $tanggal ?></p>
    </div>

    <div class="result-container">
        <div class="result-item">
            <div class="result-label">Nama</div>
            <div class="result-value"><?= htmlspecialchars($result['nama_user']) ?></div>
        </div>

        <div class="result-item">
            <div class="result-label">Kontak</div>
            <div class="result-value"><?= htmlspecialchars($result['kontak']) ?></div>
        </div>

        <div class="result-item">
            <div class="result-label">Jenis Kerusakan</div>
            <div class="result-value"><?= htmlspecialchars($result['nama_kerusakan']) ?></div>
        </div>

        <div class="result-item">
            <div class="result-label">Jawaban Anda</div>
            <div class="result-value">
                <?php 
                $answers = json_decode($result['jawaban'], true);
                
                if (!empty($answers) && is_array($answers)) {
                    // Ambil semua pertanyaan terkait kerusakan
                    $stmt = $db->prepare("SELECT id, teks_pertanyaan FROM pertanyaan 
                                        WHERE id_kerusakan = :id_kerusakan");
                    $stmt->execute([':id_kerusakan' => $result['id_kerusakan']]);
                    $questions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
                    
                    // Tampilkan pertanyaan dan jawaban
                    foreach($answers as $q_id => $answer) {
                        $question_text = $questions[$q_id] ?? "Pertanyaan $q_id";
                        echo '<div class="answer-item">';
                        echo '<div><strong>' . htmlspecialchars($question_text) . '</strong></div>';
                        echo '<div>Jawaban: <strong>' . htmlspecialchars($answer) . '</strong></div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div>Tidak ada jawaban yang direkam</div>';
                }
                ?>
            </div>
        </div>
        
        <div class="result-item">
            <div class="result-label">Solusi</div>
            <div class="solution-box">
                <?= nl2br(htmlspecialchars($result['solusi'])) ?>
            </div>
        </div>
    </div>
</body>
</html>