
<div class="card mb-4">
    <div class="card-header">
        <button type="button" id="btn-tambah-buku" class="btn btn-primary"><span class="text"><i class="fas fa-car fa-sm"></i> Tambah Buku</span></button>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // include database
                include '../config/database.php';
                // perintah sql untuk menampilkan daftar artikel
                $id_kategori=$_GET['kategori'];
                $sql="select * from buku inner join kategori on kategori.id_kategori=buku.id_kategori where kategori.id_kategori='$id_kategori' order by id_buku desc";
                $hasil=mysqli_query($kon,$sql);
                $no=0;
                //Menampilkan data dengan perulangan while
                while ($data = mysqli_fetch_array($hasil)):
                $no++;
            ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><img  src="buku/gambar/<?php echo $data['gambar'];?>" alt="Card image cap" width="80px"></td>
                <td><?php echo $data['judul']; ?></td>
                <td><?php echo  $data['nama_kategori'];  ?></td>
                <td><?php echo date("d-m-Y",strtotime($data['tanggal'])); ?></td>
                <td><?php echo $data['status'] == 1 ? "<span class='text-success'>Publish</span>" : "<span class='text-warning'>Konsep</span>"; ?> </td>
                <td>   
                    <button class="btn-edit-buku btn btn-warning btn-circle" id_buku="<?php echo $data['id_buku']; ?>" kode_buku="<?php echo $data['kode_buku']; ?>" data-toggle="tooltip" title="Edit buku" data-placement="top">Edit</button> 
                    <button class="btn-hapus-buku btn btn-danger btn-circle" id_buku="<?php echo $data['id_buku']; ?>"  gambar="<?php echo $data['gambar']; ?>"  data-toggle="tooltip" title="Hapus buku" data-placement="top">Hapus</button>
                </td>
            </tr>
            <!-- bagian akhir (penutup) while -->
            <?php endwhile; ?>
            </tbody>
        </table>
     
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <!-- Bagian header -->
        <div class="modal-header">
            <h4 class="modal-title" id="judul"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Bagian body -->
        <div class="modal-body">
            <div id="tampil_data">

            </div>  
        </div>
        <!-- Bagian footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>

<input type="hidden" name="kategori" id="kategori" value="<?php echo $_GET['kategori'];?>" />

<script>

    $('#btn-tambah-buku').on('click',function(){
        var kategori = $('#kategori').val();
        $.ajax({
            url: 'buku/tambah-buku.php',
            data: {kategori:kategori},
            method: 'post',
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Tambah Buku';
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });

        // fungsi edit artikel
    $('.btn-edit-buku').on('click',function(){
    
        var id_buku = $(this).attr("id_buku");
        var kode_buku = $(this).attr("kode_buku");
     
        $.ajax({
            url: 'buku/edit-buku.php',
            method: 'post',
            data: {id_buku:id_buku,kode_buku:kode_buku},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit Buku #'+kode_buku;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });


    // fungsi hapus artikel
    $('.btn-hapus-buku').on('click',function(){

        var id_buku = $(this).attr("id_buku");
        var gambar = $(this).attr("gambar");
        var kategori = $('#kategori').val();
        konfirmasi=confirm("Yakin ingin menghapus?")
        
        if (konfirmasi){
            $.ajax({
                url: 'buku/hapus-buku.php',
                method: 'post',
                data: {id_buku:id_buku,gambar:gambar},
                success:function(data){
                    window.location.href = 'index.php?halaman=buku&kategori='+kategori+'&hapus=berhasil';
                }
            });
        }

     
    });

</script>