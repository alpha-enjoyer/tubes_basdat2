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
    <title>Ubah Jabatan</title>
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
	var kd_jabatan=document.frm.kd_jabatan.value.trim();
	if(kd_jabatan.length==0){
		swal.fire({
                title: "",
                icon: "warning",
                text: "Kode Jabatan Tidak Boleh Kosong", 
                });
		document.frm.kd_jabatan.focus();
		return false;
	}
	var nama_jabatan=document.frm.nama_jabatan.value.trim();
	if(nama_jabatan.length==0){
		swal.fire({
                title: "",
                icon: "warning",
                text: "Nama Jabatan Tidak Boleh Kosong", 
                });
		document.frm.nama_jabatan.focus();
		return false;
	}
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
    <?= tbSb($_SESSION["nama"])?>
<?php
    if(isset($_GET["sukses"])){
        $suksesr=$_GET["sukses"];
        if($suksesr==1){
            echo messeji("","Data Berhasil Diubah Tanpa Ada Perubahan","success");
        }
       else echo messeji("","Data Berhasil Diubah","success");
    }
?>
<a href="jabatan.php" style="margin-left:5%;position:absolute;margin-top:20px;"><img src="icon/panah2x.png" alt=""></a>
<center>
<h1>Ubah Jabatan</h1>
<hr width="70%">
<?php
if(isset($_GET["kd_jabatan"])){
	$db=dbConnect();
	$kd_jabatan=$db->escape_string($_GET["kd_jabatan"]);
	if($datajabatan=getDataJabatan($kd_jabatan)){// cari data jabatan kalau ada simpan di $data
		?>
<form method="post" name="frm" action="edit_jabatan.php" onsubmit="return validasidata()">
    <table border="1" align="center">
    <tr><td>Id Jabatan</td>
        <td><input type="text" name="kd_jabatan" size="75" maxlength="8"
	        value="<?php echo $datajabatan["kd_jabatan"];?>" readonly></td></tr>
    <tr><td>Nama Jabatan</td>
        <td><input type="text" name="nama_jabatan" size="75" maxlength="50"
		    value="<?php echo $datajabatan["nama_jabatan"];?>"></td></tr>
    <tr><td>Jadwal Masukwa</td>
        <td><input type="time" name="jadwal_masuk" size="75" 
		    value="<?php echo $datajabatan["jadwal_masuk"];?>"></td></tr>
    <tr><td>Jadwal Keluar</td>
        <td><input type="time" name="jadwal_keluar" size="75"
		    value="<?php echo $datajabatan["jadwal_keluar"];?>"></td></tr>
    </table>
    <input type="submit" name="TblSimpan" value="Ubah" align="center" style="background-color:rgba(100,100,255,1);color:white;
                                                                    padding:3px 10px;box-shadow:2px 2px 8px rgba(100,100,255,0.5);
                                                                    border:0px;border-radius:3px">
</form>
<?php
    if(isset($_GET["sukses"])){
        $sukses=$_GET["sukses"];
        if($sukses==1){
        ?>
        Data Berhasil diubah tetapi tanpa ada perubahan data.<br>
        <?php
        }
        else if($sukses==2){
            ?>
        Data berhasil diubah.<br>
        <?php
        }

?>
		<?php
	}

?>
<?php
}
}
?>

<?php
if(isset($_POST["TblSimpan"])){
	$db=dbConnect();
	if($db->connect_errno==0){
		// Bersihkan data
		$kd_jabatan       =$db->escape_string($_POST["kd_jabatan"]);
		$nama_jabatan     =$db->escape_string($_POST["nama_jabatan"]);
		$jadwal_masuk     =$db->escape_string($_POST["jadwal_masuk"]);
        $jadwal_keluar    =$db->escape_string($_POST["jadwal_keluar"]);
		// Susun query insert
		$sql="UPDATE jabatan SET 
			  nama_jabatan='$nama_jabatan',jadwal_masuk='$jadwal_masuk',jadwal_keluar='$jadwal_keluar'			 
			  WHERE kd_jabatan='$kd_jabatan'";
		// Eksekusi query update
		$res=$db->query($sql);
		if($res){
			if($db->affected_rows>0){ // jika ada update data
				?>
                <script>
                    self.location = "jabatan.php?kd_jabatan=<?=$kd_jabatan?>&sukses=2";
                </script>
                <?php
                
			}
			else{ // Jika sql sukses tapi tidak ada data yang berubah
				?>
                <script>
                    self.location = "jabatan.php?ld_jabatan=<?=$kd_jabatan?>&sukses=1";
                </script>
                <?php
			}
		}
		else{ // gagal query
			?>
			Data gagal diupdate.
			<a href="javascript:history.back()"><button>Edit Kembali</button></a>
			<?php
		}
	}
	else
		echo "Gagal koneksi".(DEVELOPMENT?" : ".$db->connect_error:"")."<br>";
}
?>


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