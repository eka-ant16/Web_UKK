<?php
    if (isset($_POST['form_komentar'])) {
        //Include file koneksi, untuk koneksikan ke database
        include 'config/database.php';
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id_buku=input($_POST["id_buku"]);
        $nama=input($_POST["nama"]);
        $email=input($_POST["email"]);
        $komentar=input($_POST["komentar"]);
        $status=input($_POST["status"]);


        //Query input menginput data kedalam tabel 
        $sql="insert into komentar (id_buku,nama,email,isi_komentar,status_komentar) values
        ('$id_buku','$nama','$email','$komentar','$status')";
        //Mengeksekusi/menjalankan query 
        $hasil=mysqli_query($kon,$sql);
     

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:index.php?halaman=buku&id=$id_buku&komentar=berhasil");
        }
        else {
            header("Location:index.php?halaman=buku&id=$id_buku&komentar=gagal");

        }
        
    }
?>