<?php
                //start session
                session_start();

                //menghubungkan database
                include '../../koneksi.php';

                $username = $_POST['username'];
                $password = $_POST['password'];

                //menyeleksi data user
                $data = mysqli_query($koneksi,"select * from useradmin where username='$username' and password='$password'");

                //menghotung jumlah data yang ditemukan
                $cek = mysqli_num_rows($data);

                if($cek > 0){
                    $_SESSION['username'] = $username;
                    $_SESSION['status'] = "login";
                    header("location:dashboard.php");
                }else{
                    echo "<script>alert('Gagal Login Lur')</script>";
                    header("location:index.php?pesan=gagal");
                }
            ?>