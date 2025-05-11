<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Finance Mobile Application-UX/UI Design Screen One</title>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap'><link rel="stylesheet" href="./style.css">

</head>
<body>
  <?php
      if(isset($_GET['pesan'])){
        if($_GET['pesan'] == "gagal"){
           echo"Login gagal! Password dan username anda salah";
        }else if($_GET['pesan'] == "Logout"){
            echo"Anda telah Logout!";
        }
        else if($_GET['pesan'] == "belum_login"){
          echo"Anda harus login untuk mengakses halaman";
        }
      }
    ?>
    <form method="POST" action="cek-login.php">
    <div class="screen-1">
  <h1 align="center">LOGIN</h1>
  <br>
  <div class="email">
    <label for="email">Email Address</label>
    <div class="sec-2">
      <ion-icon name="mail-outline"></ion-icon>
      <input type="username" name="username" placeholder="username"/>
    </div>
  </div>
  <div class="password">
    <label for="password">Password</label>
    <div class="sec-2">
      <ion-icon name="lock-closed-outline"></ion-icon>
      <input class="pas" type="password" name="password" placeholder="············"/>
      <ion-icon class="show-hide" name="eye-outline"></ion-icon>
    </div>
  </div>
  <button class="login">Login </button>
</div>
    </form>
</body>
</html>
