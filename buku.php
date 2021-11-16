<?php
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    include 'config/database.php';
    $id_buku =input($_GET['id']);
    $query = mysqli_query ($kon,"select * from buku a inner join kategori k on k.id_kategori=a.id_kategori where id_buku='".$id_buku."' limit 1");
    $data = mysqli_fetch_assoc($query); 
?>
<div class="row">
    <div class="col-sm-8">
        <div class="thumbnail">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="index.php?halaman=home&kategori=<?php echo $data['id_kategori']; ?>"><?php echo $data["nama_kategori"];?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $data["judul"];?></li>
                </ol>
            </nav>
            <img src="admin/buku/gambar/<?php echo $data['gambar'];?>" width="100%" alt="Cinque Terre">
            <div class="caption">
                <?php
                echo strip_tags(html_entity_decode($data["sinopsis"],ENT_QUOTES,"ISO-8859-1"));
                 ?>
                <hr>
            </div>
            <?php
                  if (isset($_GET['komentar'])) {
                    //Mengecek nilai variabel add yang telah di enskripsi dengan method md5()
                    if ($_GET['komentar']=='berhasil'){
                        echo"<div class='alert alert-success'>Komentar telah terkirim, menunggu persetujuan dari admin</div>";
                    }else {
                        echo"<div class='alert alert-danger'>Komentar gagal</div>";
                    }   
                }
            ?>
            <div class="row">
                <?php
                    include 'config/database.php';
                    $sql="select * from komentar where id_buku=$id_buku and status_komentar=1 order by id_komentar desc";
                    $hasil=mysqli_query($kon,$sql);
                    while ($komentar = mysqli_fetch_array($hasil)):
                ?>
                <div class="col-sm-12">
                    <div class="caption">
                        <h5><?php echo $komentar['nama'];?></h5>
                        <div class="row">
                            <div class="col-sm-1">
                                <img src="gambar/user.png" width="100%" alt="Cinque Terre">
                            </div>
                            <div class="col-sm-11">
                                <?php echo $komentar['isi_komentar']; ?>
                            </div> 
                        </div>
                        <br><br>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <div class="comment">
                <form method="post" action="simpan-komentar.php">
                    <label><h2>Tinggalkan Komentar</h2></label>
                    <div class="form-group">
                        <input type="hidden" name="id_buku" value="<?php echo $data['id_buku'];?>" class="form-control">
                        <input type="hidden" name="status" value="0" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Nama:</label>
                        <input type="text" name="nama" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Komentar:</label>
                        <textarea class="form-control" name="komentar" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit"  name="form_komentar" class="btn btn-info" value="Kirim Komentar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="row">
            <?php
                include 'config/database.php';
                $sql="select * from buku where status=1 order by id_buku desc";
                $hasil=mysqli_query($kon,$sql);
                while ($data = mysqli_fetch_array($hasil)):
            ?>
            <div class="col-sm-12">
                <div class="caption">
                    <h5><a class="text-dark" href="index.php?halaman=buku&id=<?php echo $data['id_buku'];?>"><?php echo $data['judul'];?></a></h5>
                    <div class="row">
                        <div class="col-xl-3">
                            <img src="admin/buku/gambar/<?php echo $data['gambar'];?>" width="100%" alt="Cinque Terre">
                        </div>
                        <div class="col-sm-9">
                            <?php
                                $ambil=$data["sinopsis"];
                                $panjang = strip_tags(html_entity_decode($ambil,ENT_QUOTES,"ISO-8859-1"));
                            
                                echo substr($panjang, 0, 80);
                            ?>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>  
</div>