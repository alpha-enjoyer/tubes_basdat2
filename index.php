<?php
include_once("functions.php");
date_default_timezone_set('Asia/Jakarta');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Monitoring Absen Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="dist/sweetalert2.all.min.js"></script>
</head>
<body class="p-3 mb-2 bg-primary text-white"></body>
    <br>
    <br>
    <br>
    <br>
    <br>
    <center>
    <div class="shadow-lg p-3 mb-2 bg-white rounded text-dark" style="width: 35rem;">  
    <div class="card shadow-lg" style="width: 30rem;">
    <div class="card-body rounded">
    <h1>Sistem Monitoring Absen Karyawan</h1>
    <table>
        <tr>
            <td>
                <a href="index.php?absen=absen_masuk">
                    <button type="button" class="btn btn-primary">
                        Absen Masuk
                    </button>
                </a>
            </td>
            <td>
                <a href="index.php?absen=absen_keluar">
                    <button type="button" class="btn btn-primary">
                        Absen Keluar
                    </button>
                </a>
            </td>
            <td>
                <a href="index.php?absen=riwayat_absen">
                    <button type="button" class="btn btn-primary">
                        Riwayat Absen
                    </button>
                </a>
            </td>

        </tr>
    </table>
</div>
</div>
<br> 
<a href="login_admin.php"><button class="btn btn-outline-primary">Login As Admin</button></a>
</div> 
    
    <!-- FUNGSI ABSEN MASUK -->
    <?php
        if(isset($_POST["tbl_absen_masuk"])) {
            $db = dbConnect();
            $id_karyawan = $db->escape_string($_POST["id_karyawan"]);
            $pass = $db->escape_string($_POST["password"]);
            $res = $db->query("SELECT * FROM karyawan WHERE id_karyawan='$id_karyawan' AND pass='$pass'");
            if($res->num_rows>0) {
                $tanggal = date("Y-m-d");
                $res = $db->query("SELECT * FROM absensi WHERE id_karyawan='$id_karyawan' AND tanggal='$tanggal'");
                    if($res->num_rows==0) {
                    $kd_absensi = idOtomatisAbsensi();
                    $jam_masuk = date("H:i:s");
                    $jam_keluar = null;
                    $res = $db->query("INSERT INTO absensi VALUES('$kd_absensi','$tanggal','$jam_masuk','$jam_keluar','$id_karyawan')");
                    if($db->affected_rows>0) {
                        ?>
                        <script>
                            swal.fire({
                                title:"",
                                icon:"success",
                                text:"Absen Masuk Berhasil",
                            });
                        </script>
                        <?php
                    } else {
                        echo $db->error;
                        ?>
                        <script>
                            swal.fire({
                                title:"",
                                icon:"error",
                                text:"Data Gagal ditambahkan", 
                            });
                        </script>
                        <?php
                    }
                } else {
                    ?>
                    <script>
                        swal.fire({
                            title:"",
                            icon:"warning",
                            text:"Anda telah Absen Masuk hari ini!",
                        });
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    swal.fire({
                        title:"",
                        icon:"warning",
                        text:"Id atau Password yang Anda masukan salah!",
                        //EDIT CONFIRM BUTTON
                    });
                </script>
                <?php
            }
        }

        // FUNGSI ABSEN KELUAR
        if(isset($_POST["tbl_absen_keluar"])) {
            $db = dbConnect();
            $id_karyawan = $db->escape_string($_POST["id_karyawan"]);
            $pass = $db->escape_string($_POST["password"]);
            $res = $db->query("SELECT * FROM karyawan WHERE id_karyawan='$id_karyawan' AND pass='$pass'");
            if($res->num_rows>0) {
                $tanggal = date("Y-m-d");
                $res = $db->query("SELECT * FROM absensi WHERE id_karyawan='$id_karyawan' AND tanggal='$tanggal'");
                if($res->num_rows>0) {
                    if($res->num_rows>0) {
                        $tanggal = date("Y-m-d");
                        $res = $db->query("SELECT * FROM absensi WHERE id_karyawan='$id_karyawan' AND tanggal='$tanggal' AND jam_keluar<>'null'");
                            if($res->num_rows==0) {
                                $jam_keluar = date("H:i:s");
                                $res = $db->query("UPDATE absensi SET jam_keluar='$jam_keluar' WHERE id_karyawan='$id_karyawan' AND tanggal='$tanggal'");
                                if($db->affected_rows>0) {
                                    ?>
                                    <script>
                                        swal.fire({
                                            title:"",
                                            icon:"success",
                                            text:"Absen Keluar Berhasil",
                                        });
                                    </script>
                                    <?php
                                } else {
                                    echo $db->error;
                                    ?>
                                    <script>
                                        swal.fire({
                                            title:"",
                                            icon:"error",
                                            text:"Data Gagal ditambahkan", 
                                        });
                                    </script>
                                    <?php
                                }
                            } else {
                                ?>
                                <script>
                                    swal.fire({
                                        title:"",
                                        icon:"warning",
                                        text:"Anda telah Absen Keluar hari ini!",
                                    });
                                </script>
                                <?php
                            }
                    }
                } else {
                    ?>
                    <script>
                        swal.fire({
                            title:"",
                            icon:"warning",
                            text:"Anda Belum Absen Masuk hari ini! Silahkan Absen masuk terlebih dahulu",
                            //EDIT CONFIRM BUTTON
                        });
                    </script>
                    <?php
                }
            } else {
                ?>
                <script>
                    swal.fire({
                        title:"",
                        icon:"warning",
                        text:"Id atau Password yang Anda masukan salah!",
                        //EDIT CONFIRM BUTTON
                    });
                </script>
                <?php
            }
            
        }

        
        if(isset($_POST["tbl_riwayat_absen"])) {
            $db = dbConnect();
            $id_karyawan = $db->escape_string($_POST["id_karyawan"]);
            $pass = $db->escape_string($_POST["password"]);
            $res = $db->query("SELECT * FROM karyawan WHERE id_karyawan='$id_karyawan' AND pass='$pass'");
            if($res->num_rows>0) {
                $res = $db->query("SELECT * FROM absensi WHERE id_karyawan='$id_karyawan'");
                $data = $res->fetch_all(MYSQLI_ASSOC);

                ?>
                <!-- <script>
                    swal.fire({
                        title:"Riwayat Absen",
                        html:`<?= riwayat_absen($data)?>`,
                        confirmButtonText:"Kembali"
                    });
                </script> -->
                <div>
                <div class="card shadow-lg" style="width: 35rem;">
                <div class="card-body rounded">
                    <h3 style="color:blue">Riwayat Absen</h3>
                    <br>
                    <table border=1 cellpadding=5 style="border-color:black;color:blue">
                        <tr align="center" >
                            <th>Id Karyawan</th>
                            <th>Kode Absensi</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                        </tr>
                    <?php
                    foreach($data as $barisData) {
                    ?>
                        <tr align='center'>
                            <td><?= $barisData['id_karyawan']?></td>
                            <td><?= $barisData['kd_absensi']?></td>
                            <td><?= $barisData['tanggal']?></td>
                            <td><?= $barisData['jam_masuk']?></td>
                            <td><?= $barisData['jam_keluar']?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </table> 
                </div> 
                </div>
                </div>
                <?php
            }
        }


        if(isset($_GET["absen"])) {
            $db = dbConnect();
            $absen = $db->escape_string($_GET["absen"]);
            if($absen=="absen_masuk") {
                ?>
                <script>
                    swal.fire({
                        title:"Absen Masuk",
                        icon:"success",
                        html:"<form method='post' action='index.php'>"+
                                "<input type='text' name='id_karyawan' placeholder='Id Karyawan'>"+"<br><br>"+
                                "<input type='password' name='password' placeholder='Password'>"+"<br><br>"+
                                "<input type='submit' name='tbl_absen_masuk' value='Masuk'>"+
                            "</form>",
                        confirmButtonText:"Kembali"
                    });
                </script>
                <?php
            } else if($absen=="absen_keluar") {
                ?>
                <script>
                    swal.fire({
                        title:"Absen Keluar",
                        icon:"success",
                        html:"<form method='post' action='index.php'>"+
                                "<input type='text' name='id_karyawan' placeholder='Id Karyawan'>"+"<br><br>"+
                                "<input type='password' name='password' placeholder='Password'>"+"<br><br>"+
                                "<input type='submit' name='tbl_absen_keluar' value='Keluar'>"+
                            "</form>",
                        confirmButtonText:"Kembali"
                    });
                </script>
                <?php
            } else if($absen=="riwayat_absen") {
                ?>
                <script>
                    swal.fire({
                        title:"Riwayat Absen",
                        icon:"success",
                        html:"<form method='post' action='index.php'>"+
                                "<input type='text' name='id_karyawan' placeholder='Id Karyawan'>"+"<br><br>"+
                                "<input type='password' name='password' placeholder='Password'>"+"<br><br>"+
                                "<input type='submit' name='tbl_riwayat_absen' value='Lihat'>"+
                            "</form>",
                        confirmButtonText:"Kembali"
                    });
                </script>
                <?php
            }
        }
    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>