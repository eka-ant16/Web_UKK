<?php
$pesan="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    
        include "config/database.php";
    
        $username = input($_POST["username"]);
        $password = input(md5($_POST["password"]));
        
        $cek_pengguna = "select * from pengguna where username='".$username."' and password='".$password."' limit 1";
        $hasil_cek = mysqli_query ($kon,$cek_pengguna);
        $jumlah = mysqli_num_rows($hasil_cek);
        $row = mysqli_fetch_assoc($hasil_cek); 

        if ($jumlah>0){
            if ($row["status"]==1){
                $_SESSION["id_pengguna"]=$row["id_pengguna"];
                $_SESSION["kode_pengguna"]=$row["kode_pengguna"];
                $_SESSION["nama_pengguna"]=$row["nama_pengguna"];
                $_SESSION["username"]=$row["username"];
                
                //Redirect ke halaman admin
                header("Location:admin/index.php?halaman=kategori");

            }else {
                    $pesan="<div class='alert alert-warning'><strong>Gagal!</strong> Status pengguna tidak aktif.</div>";
                }

        }else {
            $pesan="<div class='alert alert-danger'><strong>Error!</strong> Username dan password salah.</div>";
        }
    }      
?>
<div class="container">
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header bg-transparent mb-0"><h5 class="text-center">Silahkan <span class="font-weight-bold text-primary">LOGIN</span></h5></div>
            <div class="card-body">
                <?php 	if ($_SERVER["REQUEST_METHOD"] == "POST") echo $pesan; ?>
                <?php 	if(isset($_GET['pesan'])){ if ($_GET["pesan"] == "login_dulu") echo "<div class='alert alert-danger'>Anda harus login dulu</div>"; }?>
              <form action="index.php?halaman=login" method="post">
                <div class="form-group">
                  <input type="text" name="username" class="form-control" autocomplete = "off" placeholder="Masukan Username">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control" autocomplete = "off" placeholder="Masukan Password">
                </div>
                <div class="form-group custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                  <label class="custom-control-label" for="customControlAutosizing">Remember me</label>
                </div>
                <div class="form-group">
                  <input type="submit" name="" value="Login" class="btn btn-primary btn-block">
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</div>