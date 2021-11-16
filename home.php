<div class="row">
<?php
         
    include 'config/database.php';
    if (isset($_GET['kategori'])) {
        $sql="select * from buku where status=1 and id_kategori=".$_GET['kategori']." order by id_buku desc";
    }else {
        $sql="select * from buku where status=1 order by id_buku desc";
    }

    
    $hasil=mysqli_query($kon,$sql);
    $jumlah = mysqli_num_rows($hasil);
    if ($jumlah>0){
        while ($data = mysqli_fetch_array($hasil)):
    ?>
        <div class="col-sm-3">
            <div class="thumbnail">
                <a href="index.php?halaman=buku&id=<?php echo $data['id_buku'];?>"><img src="admin/buku/gambar/<?php echo $data['gambar'];?>" width="100%" alt="Cinque Terre"></a>
                <div class="caption">
                    <h3><?php echo $data['judul'];?></h3>
                    <p>
                    <?php 
                    $ambil=$data["sinopsis"];
                    $panjang = strip_tags(html_entity_decode($ambil,ENT_QUOTES,"ISO-8859-1"));
                    echo substr($panjang, 0, 200);?>
                    </p>
                    <p><a href="index.php?halaman=buku&id=<?php echo $data['id_buku'];?>" class="btn btn-light btn-block" role="button">Selengkapnya</a></p>
                </div>
            </div>
        </div>
        <?php 
        endwhile;
    }else {
        echo "<div class='alert alert-warning'> Tidak ada buku pada kategori ini.</div>";
    };
     ?>
</div>