<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
// INISIALISASI SESSION
// ==============================================
if (isset($_GET['reset'])) {
    session_destroy();
    header('Location: analisis.php');
    exit;
}

if (!isset($_SESSION['current_flow'])) {
    $_SESSION['current_flow'] = [
        'id_kerusakan' => null,
        'current_question' => null,
        'answers' => []
    ];
}

// ==============================================
// PROSES FORM SUBMIT
// ==============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['id_kerusakan'])) {
            // Langkah 1: Pilih kerusakan
            $id_kerusakan = $_POST['id_kerusakan'];
            $_SESSION['current_flow']['id_kerusakan'] = $id_kerusakan;
            
            // Cari pertanyaan pertama untuk kerusakan ini
            $stmt = $db->prepare("SELECT id FROM pertanyaan 
                                WHERE id_kerusakan = :id_kerusakan
                                ORDER BY urutan ASC 
                                LIMIT 1");
            $stmt->execute([':id_kerusakan' => $id_kerusakan]);
            $pertanyaan_pertama = $stmt->fetch(PDO::FETCH_COLUMN);
            
            // Set current_question ke ID pertanyaan pertama
            $_SESSION['current_flow']['current_question'] = $pertanyaan_pertama ? $pertanyaan_pertama : null;
        } 
        elseif (isset($_POST['jawaban'])) {
            // Langkah 2-n: Proses jawaban
            $current_question_id = $_SESSION['current_flow']['current_question'];
            
            // Simpan jawaban
            $_SESSION['current_flow']['answers'][$current_question_id] = $_POST['jawaban'];
            
            // Cek pertanyaan berikutnya
            $stmt = $db->prepare("SELECT langkah_selanjutnya FROM solusi 
                                WHERE id_pertanyaan = :id_pertanyaan 
                                AND jawaban = :jawaban");
            $stmt->execute([
                ':id_pertanyaan' => $current_question_id,
                ':jawaban' => $_POST['jawaban']
            ]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['current_flow']['current_question'] = $result['langkah_selanjutnya'] ?? null;
        }
        elseif (isset($_POST['save_result'])) {
            // Langkah terakhir: Simpan hasil
            $stmt = $db->prepare("INSERT INTO hasil_diagnosa 
                                (nama_user, kontak, id_kerusakan, jawaban, solusi)
                                VALUES (:nama, :kontak, :id_kerusakan, :jawaban, :solusi)");
            
            // Pastikan jawaban disimpan sebagai JSON object
            $jawaban = !empty($_SESSION['current_flow']['answers']) ? 
                      json_encode($_SESSION['current_flow']['answers'], JSON_FORCE_OBJECT) : 
                      '{}';
            
            $stmt->execute([
                ':nama' => htmlspecialchars($_POST['nama']),
                ':kontak' => htmlspecialchars($_POST['kontak']),
                ':id_kerusakan' => $_SESSION['current_flow']['id_kerusakan'],
                ':jawaban' => $jawaban,
                ':solusi' => $_POST['solusi']
            ]);
            
            // Redirect ke halaman hasil
            $id = $db->lastInsertId();
            session_destroy();
            header("Location: view_hasil.php?id=" . $id);
            exit;
        }
    } catch(PDOException $e) {
        die("Error processing request: " . $e->getMessage());
    }
}

// ==============================================
// AMBIL DATA PERTANYAAN
// ==============================================
$current_data = [];
if (!empty($_SESSION['current_flow']['current_question'])) {
    try {
        $stmt = $db->prepare("SELECT * FROM pertanyaan WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['current_flow']['current_question']]);
        $current_data = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        die("Error fetching question: " . $e->getMessage());
    }
}

// ==============================================
// TAMPILAN HTML
// ==============================================
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Diagnosa Sepeda</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 20px;
            background-color: #f5f5f5;
        }

        .diagnosa-box {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .kerusakan-list {
            list-style: none;
            padding: 0;
        }

        .kerusakan-item {
            margin: 10px 0;
        }

        .kerusakan-item label {
            display: block;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .kerusakan-item input:checked + label {
            border-color: #2196F3;
            background-color: #e3f2fd;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #2196F3;
            color: white;
        }

        .solution-box {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .alert {
            background-color: #ffebee;
            border-left: 4px solid #f44336;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="diagnosa-box">
        <?php if (is_null($_SESSION['current_flow']['id_kerusakan'])): ?>
            <!-- Langkah 1: Pilih Kerusakan -->
            <h2>Pilih Jenis Kerusakan</h2>
            <?php
            $kerusakan = $db->query("
                SELECT k.*, COUNT(p.id) AS total_pertanyaan 
                FROM kerusakan k
                LEFT JOIN pertanyaan p ON k.id = p.id_kerusakan
                GROUP BY k.id
                HAVING COUNT(p.id) > 0
            ");
            
            // Handle jika tidak ada kerusakan dengan pertanyaan
            if ($kerusakan->rowCount() === 0): ?>
                <div class="alert">
                    <p>Sistem diagnosa sedang dalam pengembangan</p>
                    <a href="analisis.php?reset=1" class="btn btn-primary">Kembali</a>
                </div>
            <?php else: ?>
                <form method="POST">
                    <ul class="kerusakan-list">
                        <?php while($row = $kerusakan->fetch(PDO::FETCH_ASSOC)): ?>
                            <li class="kerusakan-item">
                                <input type="radio" 
                                       name="id_kerusakan" 
                                       id="kerusakan_<?= htmlspecialchars($row['id']) ?>" 
                                       value="<?= htmlspecialchars($row['id']) ?>"
                                       required>
                                <label for="kerusakan_<?= htmlspecialchars($row['id']) ?>">
                                    <?= htmlspecialchars($row['nama_kerusakan']) ?>
                                    <small>(<?= $row['total_pertanyaan'] ?> pertanyaan)</small>
                                </label>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                    <div style="text-align: center; margin-top: 20px;">
                        <button type="submit" class="btn btn-primary">Mulai Diagnosa →</button>
                    </div>
                </form>
            <?php endif; ?>

        <?php elseif (!empty($_SESSION['current_flow']['current_question']) && !empty($current_data)): ?>
            <!-- Langkah 2-n: Pertanyaan -->
            <div style="margin-bottom: 30px;">
                <h3>Pertanyaan <?= count($_SESSION['current_flow']['answers']) + 1 ?></h3>
                <p style="font-size: 18px;"><?= htmlspecialchars($current_data['teks_pertanyaan']) ?></p>
            </div>
            <form method="POST">
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="submit" name="jawaban" value="Ya" class="btn btn-primary">Ya</button>
                    <button type="submit" name="jawaban" value="Tidak" class="btn btn-primary">Tidak</button>
                </div>
            </form>

        <?php else: ?>
            <!-- Langkah Terakhir: Hasil -->
            <?php
            $solusi_text = 'Maaf, sistem belum memiliki data diagnosa untuk kerusakan ini. Silakan hubungi teknisi.';
            if (!empty($_SESSION['current_flow']['answers'])) {
                try {
                    foreach ($_SESSION['current_flow']['answers'] as $q_id => $jawaban) {
                        $stmt = $db->prepare("SELECT solusi FROM solusi 
                                            WHERE id_pertanyaan = :id_pertanyaan 
                                            AND jawaban = :jawaban
                                            LIMIT 1");
                        $stmt->execute([
                            ':id_pertanyaan' => $q_id,
                            ':jawaban' => $jawaban
                        ]);
                        $solusi = $stmt->fetchColumn();
                        if ($solusi) {
                            $solusi_text = $solusi;
                            break;
                        }
                    }
                } catch(PDOException $e) {
                    // Tetap gunakan solusi default jika error
                }
            }
            ?>
            
            <div class="solution-box">
                <h2>Hasil Diagnosa</h2>
                <p><?= nl2br(htmlspecialchars($solusi_text)) ?></p>
            </div>

            <form method="POST">
                <h3>Simpan Hasil Diagnosa</h3>
                <input type="hidden" name="solusi" value="<?= htmlspecialchars($solusi_text) ?>">
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px;">Nama Lengkap:</label>
                    <input type="text" name="nama" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px;">Kontak:</label>
                    <input type="text" name="kontak" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" name="save_result" class="btn btn-primary">Simpan Hasil</button>
                    <a href="analisis.php?reset=1" class="btn btn-primary">Diagnosa Baru</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>