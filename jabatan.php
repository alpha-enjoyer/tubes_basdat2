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
    <title>Tampil Jabatan</title>
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




<?php
    if(isset($_GET["sukses"])){
        $suksesr=$_GET["sukses"];
        if($suksesr==1){
            echo messeji("","Data Berhasil Diubah Tanpa Ada Perubahan","success","");
        }
       else echo messeji("","Data Berhasil Diubah","success","");
    }
?>
<?php
    if(isset($_GET["error"])){
        $error=$_GET["error"];
        if($error==0) {
            echo messeji("","Data Berhasil Dihapus","success","");
        } else if($error==1)
        echo messeji("","Data Gagal Dihapus, mungkin karena data Jabatan berelasi dengani karyawan","warning","");
    } 
?>
    <center>
    <h1>Tampil Jabatan</h1>
    <?= searchBar('jabatan','Nama Jabatan');?>
    <a href="tambah_jabatan.php">Tambah Jabatan</a>   
        <table border="1" width="45%">
            <tr align="center">
                <th>Kode Jabatan</th>
                <th>Nama Jabatan</th>
                <th>Jadwal Masuk</th>
                <th>Jadwal Keluar</th>
                <th>Aksi</th>
            </tr>
            <?php
            if(isset($_POST["submit"])) {

                $db = dbConnect();
                if($db->connect_errno==0) {
                    $cari = $db->escape_string($_POST["search_name"]);
                    $res = $db->query("SELECT * FROM jabatan WHERE nama_jabatan LIKE '%$cari%'");

                    $data = $res->fetch_all(MYSQLI_ASSOC);
                    if($res->num_rows>0) {
                        foreach($data as $barisData) {
                        ?>
                            <tr align="center">
                                <td><?= $barisData["kd_jabatan"]?></td>
                                <td><?= $barisData["nama_jabatan"]?></td>
                                <td><?= $barisData["jadwal_masuk"]?></td>
                                <td><?= $barisData["jadwal_keluar"]?></td>
                                <td>
                                    <center>
                                        <a href="edit_jabatan.php?kd_jabatan=<?= $barisData['kd_jabatan']?>">Edit</a> ||
                                        <a href="hapus_jabatan.php?kd_jabatan=<?= $barisData['kd_jabatan']?>">Hapus</a>
                                    </center>
                                </td>
                            </tr>
                        <?php
                        } 
                    } else {
                     ?>
                        <h2>Nama Jabatan '<?=$cari?>' Tidak Ditemukan</h2>
                    <?php
                    }
                } else {
                    echo "Koneksi Error ".(DEVELOPMENT ? $db->connect_errno. " : " .$db->connect_error : "");
                }
            } else {
                $db = dbConnect();
                if($db->connect_errno==0) {
                    $res = $db->query("SELECT * FROM jabatan");

                    $data = $res->fetch_all(MYSQLI_ASSOC);
                    if($res->num_rows>0) {
                        foreach($data as $barisData) {
                        ?>
                            <tr align="center">
                                <td><?= $barisData["kd_jabatan"]?></td>
                                <td><?= $barisData["nama_jabatan"]?></td>
                                <td><?= $barisData["jadwal_masuk"]?></td>
                                <td><?= $barisData["jadwal_keluar"]?></td>
                                <td>
                                    <center>
                                        <a href="edit_jabatan.php?kd_jabatan=<?= $barisData['kd_jabatan']?>">Edit</a> ||
                                        <a href="hapus_jabatan.php?kd_jabatan=<?= $barisData['kd_jabatan']?>">Hapus</a>
                                    </center>
                                </td>
                            </tr>
                        <?php
                        } 
                    } else {
                     ?>
                        <h2>TABEL JABATAN MASIH KOSONG</h2>
                    <?php
                    }
                } else {
                    echo "Koneksi Error ".(DEVELOPMENT ? $db->connect_errno. " : " .$db->connect_error : "");
                }
            }
            ?>
        </table>
    </center>


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