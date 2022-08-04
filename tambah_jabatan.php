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
    <title>Tambah Jabatan</title>
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
</head>
<body> 
<div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

<div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
<!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="dashboard_admin.php">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="plugins/images/icons8-clown-48.png" alt="SIK - O">
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-dark mt-4">
                            <!-- dark Logo text -->
                            <span class="h1 fw-bold mb-0 text-dark">SIK - O</span>
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none"
                        href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                   
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">

                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class=" in">
                            <form role="search" class="app-search d-none d-md-block me-3">
                                <input type="text" placeholder="Search..." class="form-control mt-0">
                                <a href="" class="active">
                                    <i class="fa fa-search"></i>
                                </a>
                            </form>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li>
                        <a class="profile-pic" href="#">
                                <img src="plugins/images/icons8-clown-48.png" alt="user-img" width="36"
                                    class="img-circle"><span class="text-white font-medium"><?= $_SESSION["nama"]?></span></a>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
<aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard_admin.php"
                                aria-expanded="false">
                                <i class="far fa-clock" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="karyawan.php"
                                aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="hide-menu">Karyawan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="jabatan.php"
                                aria-expanded="false">
                                <i class="fa fa-table" aria-hidden="true"></i>
                                <span class="hide-menu">Jabatan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="absensi.php"
                                aria-expanded="false">
                                <i class="fa fa-font" aria-hidden="true"></i>
                                <span class="hide-menu">Absensi</span>
                            </a>
                        </li>
                        <li class="text-center p-20 upgrade-btn">
                            <a href="logout.php"
                                class="btn d-grid btn-danger text-white" target="_blank">
                                LOGOUT</a>
                        </li>
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
    </div>                                                                                           
<center>
<h1>Tambah Jabatan</h1>
<a href="jabatan.php"><button>View Jabatan</button></a>
<form method="post" name="frm" action="tambah_jabatan.php" onsubmit="return validasidata()">
<table border="1">
    <tr><td>Kode Jabatan</td>
        <td><input type="text" name="kd_jabatan" size="75" maxlength="10"></td></tr>
    <tr><td>Nama Jabatan</td>
        <td><input type="text" name="nama_jabatan" size="75" maxlength="50"></td></tr>
    <tr><td>Jadwal Masuk</td>
	    <td><input type="time" name="jadwal_masuk" size="75"></td></tr>
    <tr><td>Jadwal Keluar</td>
	    <td><input type="time" name="jadwal_keluar" size="75"></td></tr>
</table>
<input type="submit" name="TblSimpan" value="Tambah" align="center" style="background-color:rgba(100,100,255,1);color:white;
                                                                    padding:3px 10px;box-shadow:2px 2px 8px rgba(100,100,255,0.5);
                                                                    border:0px;border-radius:3px">
</form>

<?php
if(isset($_POST["TblSimpan"])){
	$db=dbConnect();
	if($db->connect_errno==0){
		// Bersihkan data
		$kd_jabatan        =$db->escape_string($_POST["kd_jabatan"]);
		$nama_jabatan	   =$db->escape_string($_POST["nama_jabatan"]);
        $jadwal_masuk	   =$db->escape_string($_POST["jadwal_masuk"]);
        $jadwal_keluar	   =$db->escape_string($_POST["jadwal_keluar"]);

		// Susun query insert
        $sql="SELECT * FROM jabatan WHERE kd_jabatan='$kd_jabatan'";
		$res=$db->query($sql);
		if($res->num_rows==0){
		$sql="INSERT INTO jabatan(kd_jabatan,nama_jabatan,jadwal_masuk,jadwal_keluar)
			  VALUES('$kd_jabatan','$nama_jabatan','$jadwal_masuk','$jadwal_keluar')";
		// Eksekusi query insert
		$res=$db->query($sql);
		if($res) {
			if($db->affected_rows>0){ // jika ada penambahan data
				?>
				<script>
				swal.fire({
            	title: "",
            	icon: "success",
            	text: "Data Berhasil Disimpan", 
            	});
				</script>
				<?php
                
			}
		}
    }
		else{
			?>
			<script>
			swal.fire({
            title: "",
            icon: "warning",
            text: "Data Gagal Disimpan Karena Kode Jabatan Sudah Ada", 
            });
			</script>
			<?php	    
		}
	}
	else
		echo "Gagal koneksi".(DEVELOPMENT?" : ".$db->connect_error:"")."<br>";
}
?>
<br>
<a href="jabatan.php" style="color: white;">Tampil Jabatan</a>

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
	</div>
</center>
</body>
</html>