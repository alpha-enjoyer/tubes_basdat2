<?php 
    session_start();
    include_once('functions.php');
    date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Karyawan</title>
    <script src="dist/sweetalert2.all.min.js"></script>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    <script src="dist/sweetalert2.all.min.js"></script>

</head>
<body>
    <?= tbSb($_SESSION["nama"])?>
    <center>
    <h1>Ubah Karyawan</h1>
    <hr width="70%">
    <?php
        if(isset($_GET["id_karyawan"])) {
            $db = dbConnect();
            $id_karyawan = $db->escape_string($_GET["id_karyawan"]);
            if($data = getDataKaryawan($id_karyawan)) {
            
    ?>
    <form action="edit_karyawan.php" method="post" name="f" onsubmit="return validasidata()">
        <table border="0">
            <tr>
                <td>Id Karyawan</td>
                <td><input type="text" name="id_karyawan" size="75" value="<?= $data['id_karyawan']?>" readonly></td>
            </tr>
            <tr>
                <td>Nama</td>   
                <td><input type="text" name="nama" size="75" value="<?= $data['nama']?>" maxlength="50" ></td>
            </tr>
            
            <tr>
                <td>Jenis Kelamin</td>
                <td>
                    <select name="jk" id="" style="width: 100%;" >
                        <option value="" >Pilih Jenis Kelamin</option>
                    <?php
                        if($data["jk"]=='Laki-laki') {
                            ?>
                            <option value="Laki-laki" selected>Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                            <?php
                        } else if($data["jk"]=='Perempuan'){
                            ?>
                            <option value="Laki-laki">Laki-Laki</option>
                            <option value="Perempuan" selected>Perempuan</option>
                            <?php
                        } else {
                            ?>
                            <option value="Laki-laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                            <?php
                        }    
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><textarea name="alamat" cols="70" rows="5"><?= $data['alamat']?></textarea></td>
            </tr>
            <tr>
                <td>No Hp</td>
                <td><input type="text" name="no_hp" size="75" value="<?= $data['no_hp']?>"></td>
            </tr>

            <tr>
                <td>Password</td>
                <td><input type="password" name="pass" size="75" value="<?= $data['pass']?>"></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td><select name="kd_jabatan" style="width:100%" id="">
                        <option value="">Pilih Jabatan</option>
                    <?php
                        $data_jabatan=getListJabatan();
                        foreach($data_jabatan as $barisData) {
                            if($barisData["kd_jabatan"]==$data["kd_jabatan"]) {
                                ?>
                                <option value="<?= $barisData['kd_jabatan']?>" selected><?= $barisData['nama_jabatan']?></option>
                                <?php
                            } else {
                                ?>
                                <option value="<?= $barisData['kd_jabatan']?>"><?= $barisData['nama_jabatan']?></option>
                                <?php
                            }
                        }      
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Pengguna</td>
                <td><select name="id_pengguna" style="width:100%" id="">
                        <option value="">Pilih Hak Akses</option>
                    <?php
                    $data_karyawan = getListPengguna();
                        foreach($data_karyawan as $barisData) {
                            if($barisData["id_pengguna"]==$data["id_pengguna"]) {
                                ?>
                                <option value="<?= $barisData['id_pengguna']?>" selected><?= $barisData['nama_pengguna']?></option>
                                <?php
                            } else {
                                ?>
                                <option value="<?= $barisData['id_pengguna']?>"><?= $barisData['nama_pengguna']?></option>
                                <?php
                            }
                        }      
                    ?>
                    </select></td>
            </tr>
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <button type="submit" name="submit" value="Ubah" style="background-color:rgba(50,50,255,1);color:white; padding:10px 50px;box-shadow:2px 2px 8px rgba(100,100,255,0.5);
                    border:0px;border-radius:3px">Ubah</button>
                </td>
            </tr>
    </table>
    </form>
    <?php
            } else {
                echo messeji("","Karyawan dengan Id : $id_karyawan Tidak Ditemukan!","error","");

            }
        } else {
            echo messeji("","Id Karyawan tidak ada, jangan mengotak atik web search bar","error","");

        }


if(isset($_POST["submit"])) {
    $db=dbConnect();
    if($db->connect_errno==0) {
        $id_karyawan = $db->escape_string($_POST["id_karyawan"]);
        $nama = $db->escape_string($_POST["nama"]);
        $jk = $db->escape_string($_POST["jk"]);
        $alamat = $db->escape_string($_POST['alamat']);
        $no_hp = $db->escape_string($_POST['no_hp']);
        $pass = $db->escape_string($_POST['pass']);
        $kd_jabatan  =$db->escape_string($_POST["kd_jabatan"]);
        $id_pengguna  =$db->escape_string($_POST["id_pengguna"]);

        $sql = "UPDATE karyawan SET 
                nama='$nama',alamat='$alamat',jk='$jk',no_hp='$no_hp', pass='$pass', kd_jabatan='$kd_jabatan', id_pengguna='$id_pengguna'
                WHERE id_karyawan='$id_karyawan'";

        $res = $db->query($sql);

        if($res) { //jikalau query berhasil
            if($db->affected_rows>0) {
                ?>
                <script>
                    self.location = "karyawan.php?notifedit=1";
                </script>
                <?php
             
            } else {
                ?>
                <script>
                    self.location = "karyawan.php?notifedit=2";
                </script>
                <?php
            }
        } else { //jikalau query gagal
            ?>
            <script>
                self.location = "karyawan.php?notifedit=3";
            </script>
            <?php

        }
    } else {
        ?>
        <script>
            self.location = "karyawan.php?notifedit=4'";
        </script>
        <?php
    }
}
?>
    </center>

    <script>
        function validasidata() {
            var nama = document.f.nama.value.trim();
            var re_nama = /^[a-zA-Z- ]+$/;
            if(nama.length==0) {
                swal.fire({
                title: "",
                icon: "warning",
                text: "Nama tidak Boleh Kosong  ", 
                });
                document.f.nama.focus();
                return false;
            }
            if(!re_nama.test(nama)) {
                swal.fire({
                title: "",
                icon: "warning",
                text: "Penulisan Nama tidak sesuai dengan format, Gunakan format huruf \"a-z\"",
                });
                document.f.nama.focus();
                return false;
            }

            if(document.f.jk.selectedIndex==0) {
                swal.fire({
                title: "",
                icon: "warning",
                text: "Harap Memilih Jenis Kelamin", 
                });
                document.f.jk.focus();
                return false;
            }

            var alamat = document.f.alamat.value.trim();
            if(alamat.length==0) {
                swal.fire({
                title: "",
                icon: "warning",
                text: "Alamat Tidak Boleh Kosong ", 
                });
                document.f.alamat.focus();
                return false;
            }

            var no_hp = document.f.no_hp.value.trim();
            var re_no_hp =/^[0-9]+$/;
	        if(no_hp.length==0){
                swal.fire({
                title: "",
                icon: "warning",
                text: "No HP Tidak Boleh Kosong", 
                });
		        document.f.no_hp.focus();
		        return false;		
	        } 
            if(!re_no_hp.test(no_hp)){
                swal.fire({
                title: "",
                icon: "warning",
                text: "No HP Tidak Boleh Berupa Huruf", 
                });
		        document.f.no_hp.focus();
                return false;
            }
            if(no_hp.length<12){
                swal.fire({
                title: "",
                icon: "warning",
                text: "No HP Terlalu Pendek", 
                });
		        document.f.no_hp.focus();
                return false;
            }

            if(document.f.kd_jabatan.selectedIndex==0) {
                document.f.kd_jabatan.focus();
                swal.fire({
                title: "",
                icon: "warning",
                text: "Harap Memilih Jabatan"});
                return false;
            }
            if(document.f.id_pengguna.selectedIndex==0) {
                document.f.id_pengguna.focus();
                swal.fire({
                title: "",
                icon: "warning",
                text: "Harap Memilih Hak Akses"});
                return false;
            }
            var password = document.f.pass.value.trim();
            if(password.length==0) {
                swal.fire({
                title: "",
                icon: "warning",
                text: "Password Tidak Boleh Kosong", 
                });
                document.f.pass.focus();
                return false;
            }
            if(password.length<4) {
                swal.fire({
                title: "",
                icon: "warning",
                text: "Password Tidak Boleh Kurang dari 4 karakter", 
                });
                document.f.pass.focus();
                return false;
            }

            return true;

        }
        
    </script>
    

    <script src="dist/sweetalert2.all.min.js"></script>
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/app-style-switcher.js"></script>
    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="plugins/bower_components/chartist/dist/chartist.min.js"></script>
    <script src="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="js/pages/dashboards/dashboard1.js"></script>
</body>

</html>