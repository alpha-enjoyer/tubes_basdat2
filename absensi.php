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
    <title>Tampil Absensi</title>
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
    if(isset($_GET["sukses"])){
        $suksesr=$_GET["sukses"];
        if($suksesr==1){
            echo messeji("","Data Berhasil Diubah Tanpa Ada Perubahan","success","");
        } else if($suksesr==2) {
            echo messeji("","Data Berhasil Diubah","success","");
        } else if($suksesr==3) {
            echo messeji("","Data Berhasil Dihapus!","success");
        } else if($suksesr==0) {
            echo messeji("","Data Gagal Dihapus","error");
        }
    }
?>
<?php
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
    <h1>Tampil Absensi</h1>
    <?= searchBar('absensi','Nama Karyawan');?>
    <!-- <a href="tambah_absensi.php" style="margin-left:10%;">Tambah Karyawan</a>    -->
        <table border='1' width="45%">
            <tr align="center">
                <th>Kode Absensi</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Nama Karyawan</th>
                <th>Aksi</th>
            </tr>
            <?php
            if(isset($_POST["submit"])) {

                $db = dbConnect();
                if($db->connect_errno==0) {
                    $cari = $db->escape_string($_POST["search_name"]);
                    $res = $db->query("SELECT * FROM absensi JOIN karyawan ON karyawan.id_karyawan=absensi.id_karyawan 
                                        WHERE karyawan.nama LIKE '%$cari%'");

                    $data = $res->fetch_all(MYSQLI_ASSOC);
                    if($res->num_rows>0) {
                        foreach($data as $barisData) {
                        ?>
                            <tr>
                                <center>
                                <td><?= $barisData["kd_absensi"]?></td>
                                <td><?= $barisData["tanggal"]?></td>
                                <td><?= $barisData["jam_masuk"]?></td>
                                <td><?= $barisData["jam_keluar"]?></td>
                                <td><?= $barisData["nama"]?></td>
                                </center>
                                <td>
                                    <center>
                                        <a href="edit_absensi.php?kd_absensi=<?= $barisData['kd_absensi']?>">Edit</a> ||
                                        <a href="hapus_absensi.php?kd_absensi=<?= $barisData['kd_absensi']?>">Hapus</a>
                                    </center>
                                </td>
                            </tr>
                        <?php
                        } 
                    } else {
                     ?>
                        <h2>Kode absensi '<?=$cari?>' Tidak Ditemukan</h2>
                    <?php
                    }
                } else {
                    echo "Koneksi Error ".(DEVELOPMENT ? $db->connect_errno. " : " .$db->connect_error : "");
                }
            } else {
                $db = dbConnect();
                if($db->connect_errno==0) {
                    $res = $db->query("SELECT * FROM absensi JOIN karyawan ON karyawan.id_karyawan=absensi.id_karyawan");

                    $data = $res->fetch_all(MYSQLI_ASSOC);
                    if($res->num_rows>0) {
                        foreach($data as $barisData) {
                        ?>
                            <tr align="center">
                                <td><?= $barisData["kd_absensi"]?></td>
                                <td><?= $barisData["tanggal"]?></td>
                                <td><?= $barisData["jam_masuk"]?></td>
                                <td><?= $barisData["jam_keluar"]?></td>
                                <td><?= $barisData["nama"]?></td>
                                <td>
                                    <center>
                                        <a href="edit_absensi.php?kd_absensi=<?= $barisData['kd_absensi']?>">Edit</a> ||
                                        <a href="absensi.php?kd_absensi_hapus=<?= $barisData['kd_absensi']?>">Hapus</a>
                                    </center>
                                </td>
                            </tr>
                        <?php
                        } 
                    } else {
                     ?>
                        <h2>ABSENSI MASIH KOSONG</h2>
                    <?php
                    }
                } else {
                    echo "Koneksi Error ".(DEVELOPMENT ? $db->connect_errno. " : " .$db->connect_error : "");
                }
            }
            ?>
        </table>
        <?php 

        

if(isset($_GET["kd_absensi_hapus"])) {
    $db = dbConnect();
    $kd_absensi_hapus = $db->escape_string($_GET["kd_absensi_hapus"]);
    $data = getDataAbsensi($kd_absensi_hapus);
    if(!$data) {
        echo messeji("","Kd Absensi tidak ditemukan!","error");
    } else {
       $kd_absensi = $data["kd_absensi"];
       $res = $db->query("DELETE FROM absensi WHERE kd_absensi='$kd_absensi'");
       if($db->affected_rows>0) {
        ?>
        <script>
            self.location = "absensi.php?sukses=3";
        </script>
        <?php
       } else {
        ?>
        <script>
            self.location = "absensi.php?sukses=0";
        </script>
        <?php
       }
    }
}
?>
    </center>
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