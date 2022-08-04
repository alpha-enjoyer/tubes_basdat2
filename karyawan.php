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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampil Karyawan</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    <script src="dist/sweetalert2.all.min.js"></script>
    <style>
        span {
            color:black;
        }
    </style>
</head>
<body>
        <?= tbSb($_SESSION["nama"])?>

    <?php 
    	     if(isset($_GET['sukses'])){
                $suksed=$_GET['sukses'];
                if($suksed==1){
                    echo messeji("","Data Berhasil Disimpan.","success","");
                    }
                    else if($suksed==2){
                        echo messeji("","Data Gagal Ditambahkan. Mungkin karena id Petugas telah ada sebelumnya.","success","");
                    }
                    else if($suksed==3){
                        echo messeji("","Data Gagal Ditambahkan ".(DEVELOPMENT ? "Karena Query error ".$db->errno." : ".$db->error : " "),"error","");
                    }else if($suksed==4){
                        echo messeji("","Gagal Koneksi '.(DEVELOPMENT ? $db->connect_errno .' : '. $db->connect_error : ' )","error","");
            }
        }




            if(isset($_GET["sukses_hapus"])) {
                $db = dbConnect();
                $sukses_hapus = $db->escape_string($_GET["sukses_hapus"]);
                if($sukses_hapus==1) {
                    echo messeji("","Data Berhasil Dihapus!","success");
                } else {
                    echo messeji("","Data Gagal Dihapus, mungkin karena ada data absensi di karyawan tersebut","error");
                }
            }


            if(isset($_GET['notifedit'])){
                $notifedits=$_GET['notifedit'];
                if($notifedits==1){
                    echo messeji("","Data Berhasil Diubah.","success","");
                    }
                    else if($notifedits==2){
                        echo messeji("","Data Berhasil Diubah, Tetapi Tanpa Ada Perubahan Data","success","");
                    }
                    else if($notifedits==3){
                        echo messeji("","Data Gagal Diubah ".(DEVELOPMENT ? "Karena Query error ".$db->errno." : ".$db->error : " "),"error","");
                    }else if($notifedits==4){
                        echo messeji("","Gagal Koneksi '.(DEVELOPMENT ? $db->connect_errno .' : '. $db->connect_error : ' )","error","");
            }
        }
    ?>
    <center>
    <h1>Tampil Karyawan</h1>
    <?= searchBar('karyawan','Nama Karyawan');?>
    <a href="tambah_karyawan.php">Tambah Karyawan</a>
    <table border='1' width="60%">
        <tr align="center">
            <th>Id Karyawan</th>
            <th>Nama</th>
            <th>Jenis K.</th>
            <th>Alamat</th>
            <th>No Hp</th>
            <th>Jabatan</th>
            <th>Hak Akses</th>
            <th>Aksi</th>
        </tr>




        <?php
        if(isset($_POST["submit"])) {

            $db = dbConnect();
            if($db->connect_errno==0) {
                $cari = $db->escape_string($_POST["search_name"]);
                $res = $db->query("SELECT * FROM karyawan JOIN jabatan ON karyawan.kd_jabatan=jabatan.kd_jabatan JOIN pengguna ON karyawan.id_pengguna=pengguna.id_pengguna
                                    WHERE karyawan.nama LIKE '%$cari%'");

                $data = $res->fetch_all(MYSQLI_ASSOC);
                if($res->num_rows>0) {
                    foreach($data as $barisData) {
                    ?>
                        <tr>
                            <center>
                            <td><?= $barisData["id_karyawan"]?></td>
                            <td><?= $barisData["nama"]?></td>
                            <td><?= $barisData["jk"]?></td>
                            <td><?= $barisData["alamat"]?></td>
                            <td><?= $barisData["no_hp"]?></td>
                            <td><?= $barisData["nama_jabatan"]?></td>
                            <td><?= $barisData["nama_pengguna"]?></td>
                            </center>
                            <td>
                                <center>
                                    <a href="edit_karyawan.php?id_karyawan=<?= $barisData['id_karyawan']?>">Edit</a> ||
                                    <a href="karyawan.php?id_karyawan_hapus=<?= $barisData['id_karyawan']?>">Hapus</a>
                                </center>
                            </td>
                        </tr>
                    <?php
                    } 
                } else {
                 ?>
                    <h2>Nama '<?=$cari?>' Tidak Ditemukan</h2>
                <?php
                }
            } else {
                echo "Koneksi Error ".(DEVELOPMENT ? $db->connect_errno. " : " .$db->connect_error : "");
            }

        } else {
            if($data = getListKaryawan()) {
                foreach($data as $barisData) {
                ?>
                    <tr>
                        <td><?= $barisData["id_karyawan"]?></td>
                        <td><?= $barisData["nama"]?></td>
                        <td><?= $barisData["jk"]?></td>
                        <td><?= $barisData["alamat"]?></td>
                        <td><?= $barisData["no_hp"]?></td>
                        <td><?= $barisData["nama_jabatan"]?></td>
                        <td><?= $barisData["nama_pengguna"]?></td>
                        <td>
                            <a href="edit_karyawan.php?id_karyawan=<?= $barisData["id_karyawan"]?>">Edit</a>
                            <a href="karyawan.php?id_karyawan_hapus=<?= $barisData["id_karyawan"]?>">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                echo messeji("","Tabel Karyawan Masih Kosong","info");
            }
        }



            if(isset($_GET["id_karyawan_hapus"])) {
                $db = dbConnect();
                $id_karyawan_hapus = $db->escape_string($_GET["id_karyawan_hapus"]);
                $data = getDataKaryawan($id_karyawan_hapus);
                if(!$data) {
                    echo messeji("","Id Karyawan tidak ditemukan!","error");
                } else {
                   $nama = $data["nama"];
                   $id_karyawan = $data["id_karyawan"];
                   $res = $db->query("DELETE FROM karyawan WHERE id_karyawan='$id_karyawan'");
                   if($db->affected_rows>0) {
                        ?>
                        <script>
                            self.location = "karyawan.php?sukses_hapus=1";
                        </script>
                        <?php
                   } else {
                    ?>
                    <script>
                        self.location = "karyawan.php?sukses_hapus=0";
                    </script>
                    <?php
                   }
                }
            }
        ?>
    </table>


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
