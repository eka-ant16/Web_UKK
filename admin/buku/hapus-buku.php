<?php
session_start();
    include '../../config/database.php';

    $id_buku=$_POST["id_buku"];
    $gambar=$_POST["gambar"];

    $sql="delete from buku where id_buku=$id_buku";
    $hapus_buku=mysqli_query($kon,$sql);

    //Menghapus gambar, gambar yang dihapus jika selain gambar default
    if ($gambar!='gambar_default.png'){
        unlink("gambar/".$gambar);
    }
 

?>