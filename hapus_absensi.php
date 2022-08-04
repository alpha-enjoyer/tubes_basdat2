<!-- <?php include_once("functions.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Jabatan</title>
<script src="dist/sweetalert2.all.min.js"></script>
</head>
<body>
<center>
<?php
if(isset($_GET["kd_absensi"])){
	$db=dbConnect();
	if($db->connect_errno==0){
		$kd_absensi  =$db->escape_string($_GET["kd_absensi"]);
		// Susun query delete
		$sql="DELETE FROM absensi WHERE kd_absensi='$kd_absensi'";
		// Eksekusi query delete
		$res=$db->query($sql);
		if($res){
			if($db->affected_rows>0){ // jika ada data terhapus
				echo "Data Berhasil Dihapus.<br>";
                header("Location:absensi.php?error=0");
            }
			else // Jika sql sukses tapi tidak ada data yang dihapus
				echo "Penghapusan gagal karena data yang dihapus tidak ada.<br>";
		}
		else{ // gagal query
			echo "Data Gagal Dihapus. <br>";
		}
		?>
		
		<?php
	}
	else
		echo "Gagal koneksi".(DEVELOPMENT?" : ".$db->connect_error:"")."<br>";
}

?>
    </center>
</body>
</html> -->