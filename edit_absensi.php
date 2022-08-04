<?php 
    session_start();
    include_once('functions.php');
    date_default_timezone_set('Asia/Jakarta');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Absensi</title>
	<link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
    <!-- Custom CSS -->
    <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="css/style.min.css" rel="stylesheet">
    <script src="dist/sweetalert2.all.min.js"></script>
	<script type="text/javascript" language="javascript">
function validasidata(){
	//return true;
	var jadwal_masuk = document.frm.jadwal_masuk.value.trim();
	
	if(jadwal_masuk.length==0){
		swal.fire({
                title: "",
                icon: "warning",
                text: "Harap Mengisi Jadwal Masuk", 
        });
		document.frm.jadwal_masuk.focus();
		return false;		
	}
	var jadwal_keluar = document.frm.jadwal_keluar.value.trim();
    if(jadwal_keluar.length==0) {
		swal.fire({
                title: "",
                icon: "warning",
                text: "Harap Mengisi Jadwal Keluar",
        });
		document.frm.jadwal_keluar.focus();
		return false;		
	}
	return true;
}
</script>
<script src="dist/sweetalert2.all.min.js"></script>
</head>
<body>
<?php tbSb($_SESSION["nama"])?>



<?php
    if(isset($_GET["sukses"])){
        $suksesr=$_GET["sukses"];
        if($suksesr==1){
            echo messeji("","Data Berhasil Diubah Tanpa Ada Perubahan","success");
        }
       else echo messeji("","Data Berhasil Diubah","success");
    }
?>
<a href="absensi.php" style="margin-left:5%;position:absolute;margin-top:20px;"><img src="icon/panah2x.png" alt=""></a>
<center>
<h1>Ubah Absensi</h1>
<hr width="70%">
<?php
if(isset($_GET["kd_absensi"])){
	$db=dbConnect();
	$kd_absensi=$db->escape_string($_GET["kd_absensi"]);
	if($dataabsensi=getDataAbsensi($kd_absensi)){// cari data djabatan kalau ada simpan di $data
		?>
<form method="post" name="frm" action="edit_absensi.php" onsubmit="return validasidata()">
<table border="1">
<tr><td>Kd Absensi</td>
    <td><input type="text" name="kd_absensi" size="75" maxlength="8"
	     value="<?php echo $dataabsensi["kd_absensi"];?>" readonly></td></tr>
<tr><td>Tanggal</td>
    <td><input type="text" name="tanggal" size="75" maxlength="50" readonly
		 value="<?php echo $dataabsensi["tanggal"];?>"></td></tr>
<tr><td>Jam Masuk</td>
    <td><input type="time" name="jam_masuk" size="75" maxlength="13"
		 value="<?php echo $dataabsensi["jam_masuk"];?>"></td></tr>
<tr><td>Jam Keluar</td>
    <td><input type="time" name="jam_keluar" size="75" maxlength="50"
		 value="<?php echo $dataabsensi["jam_keluar"];?>"></td></tr>
<tr><td>id karyawan</td>
    <td><input type="text" name="id_karyawan" size="75" maxlength="50" readonly
		 value="<?php echo $dataabsensi["id_karyawan"];?>"></td></tr>
</table>
<input type="submit" name="TblSimpan" value="Ubah" align="center" style="background-color:rgba(100,100,255,1);color:white;
                                                                    padding:3px 10px;box-shadow:2px 2px 8px rgba(100,100,255,0.5);
                                                                    border:0px;border-radius:3px">
</form>


<?php
            } else {
                echo messeji("","Absensi dengan Id : $kd_absensi Tidak Ditemukan!","error","");

            }
        } else {
            echo messeji("","Absensi tidak ada, jangan mengotak atik web search bar","error","");

        }



if(isset($_POST["TblSimpan"])){
	$db=dbConnect();
	if($db->connect_errno==0){
		// Bersihkan data
		$kd_absensi     =$db->escape_string($_POST["kd_absensi"]);
		$tanggal   =$db->escape_string($_POST["tanggal"]);
		$jam_masuk    =$db->escape_string($_POST["jam_masuk"]);
        $jam_keluar        =$db->escape_string($_POST["jam_keluar"]);
        $id_karyawan  =$db->escape_string($_POST["id_karyawan"]);
		// Susun query insert
		$sql="UPDATE absensi SET 
			  tanggal='$tanggal',jam_masuk='$jam_masuk',jam_keluar='$jam_keluar',id_karyawan='$id_karyawan'
			  WHERE kd_absensi='$kd_absensi'";
		// Eksekusi query update
		$res=$db->query($sql);
		if($res){
			if($db->affected_rows>0){ // jika ada update data
                ?>
                <script>
                    self.location = "absensi.php?notifedit=1";
                </script>
                <?php
                
			}
			else{ // Jika sql sukses tapi tidak ada data yang berubah

                ?>
                <script>
                    self.location = "absensi.php?notifedit=2";
                </script>
                <?php
			}
		}
		else{ // gagal query
            ?>
            <script>
                self.location = "absensi.php?notifedit=3";
            </script>
            <?php
		}
	}
	else{
        ?>
        <script>
            self.location = "absensi.php?notifedit=4";
        </script>
        <?php
		}
	}
	
?>

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