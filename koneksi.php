<?php
$koneksi = mysqli_connect("localhost","root","","sepedalistrik");

if (mysqli_connect_errno()){
    echo"koneksi datanase gagal : ".mysqli_connect_error();
};
?>