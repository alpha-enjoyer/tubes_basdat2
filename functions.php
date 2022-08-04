<?php
define("DEVELOPMENT",TRUE);
function dbConnect(){
	$db=new mysqli("localhost","root","","basdat2");
	return $db;
}

function idOtomatis() {
    $db = dbConnect();
    $sql = "SELECT max(id_karyawan) AS idTerbesar FROM karyawan";
    $res = $db->query($sql);

    if($res) {
        $data = $res->fetch_array();
        $idTerbesar = $data['idTerbesar'];

        $urutan = (int) substr($idTerbesar,3);

        $urutan++;

        $huruf = "101";
        $id_karyawan = $huruf . sprintf("%05s",$urutan);
        
    }
    return $id_karyawan;
}


function idOtomatisAbsensi() {
    $db = dbConnect();
    $sql = "SELECT max(kd_absensi) AS idTerbesar FROM absensi";
    $res = $db->query($sql);

    if($res) {
        $data = $res->fetch_array();
        $idTerbesar = $data['idTerbesar'];

        $urutan = (int) substr($idTerbesar,3);

        $urutan++;

        $huruf = "ABS";
        $kd_absensi = $huruf . sprintf("%05s",$urutan);
        
    }
    return $kd_absensi;
}
// ambil data karyawan
function getDataKaryawan($id_karyawan){
	$db=dbConnect();
	if($db->connect_errno==0){
        $res=$db->query("SELECT *  
        FROM karyawan k JOIN jabatan j
        ON k.kd_jabatan = j.kd_jabatan
        JOIN pengguna p
        ON k.id_pengguna = p.id_pengguna
        WHERE k.id_karyawan='$id_karyawan'");
		if($res){
			if($res->num_rows>0){
				$data=$res->fetch_assoc();
				$res->free();
				return $data;
			}
			else
				return FALSE;
		}
		else
			return FALSE; 
	}
	else
		return FALSE;
}

function getListKaryawan(){
	$db=dbConnect();
	if($db->connect_errno==0){
        $res=$db->query("SELECT k.id_karyawan,k.nama,k.jk,k.alamat,k.no_hp,
        j.nama_jabatan,p.nama_pengguna
        FROM karyawan k JOIN jabatan j
        ON k.kd_jabatan = j.kd_jabatan
        JOIN pengguna p
        ON k.id_pengguna = p.id_pengguna ORDER BY id_karyawan ASC");
		if($res){
			if($res->num_rows>0){
				$data=$res->fetch_all(MYSQLI_ASSOC);
				$res->free();
				return $data;
			}
			else
				return FALSE;
		}
		else
			return FALSE; 
	}
	else
		return FALSE;
}
    
// get data jabatan
function getDataJabatan($kd_jabatan){
	$db=dbConnect();
	if($db->connect_errno==0){
		$res=$db->query("SELECT * FROM jabatan
        WHERE kd_jabatan='$kd_jabatan'");
		if($res){
			if($res->num_rows>0){
				$data=$res->fetch_assoc();
				$res->free();
				return $data;
			}
			else
				return FALSE;
		}
		else
			return FALSE; 
	}
	else
		return FALSE;
}
//gett list jabatan
function getListJabatan(){
	$db=dbConnect();
	if($db->connect_errno==0){
        $res=$db->query("SELECT * FROM jabatan ORDER BY kd_jabatan");
		if($res){
			if($res->num_rows>0){
				$data=$res->fetch_all(MYSQLI_ASSOC);
				$res->free();
				return $data;
			}
			else
				return FALSE;
		}
		else
			return FALSE; 
	}
	else
		return FALSE;
}
// get data absensi
function getDataAbsensi($kd_absensi){
	$db=dbConnect();
	if($db->connect_errno==0){
		$res=$db->query("SELECT * 
        FROM absensi a JOIN karyawan k
        ON a.id_karyawan = k.id_karyawan
        WHERE a.kd_absensi='$kd_absensi'");
		if($res){
			if($res->num_rows>0){
				$data=$res->fetch_assoc();
				$res->free();
				return $data;
			}
			else
				return FALSE;
		}
		else
			return FALSE; 
	}
	else
		return FALSE;
}
// get list pengguna
function getListPengguna(){
    $db=dbConnect();
    if($db->connect_errno==0){
        $res=$db->query("SELECT * FROM pengguna ORDER BY id_pengguna");
        if($res){
            $data=$res->fetch_all(MYSQLI_ASSOC);
            $res->free();
            return $data;
        }
        else 
            return FALSE;
    }
    else
        return FALSE;
}


function riwayat_absen($data) {
	?>
		<br>
		<table border=1 cellpadding=5 style="border-color:white;" >
			<tr align="center">
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
	<?php
}

function searchBar($namaFile,$namaKolom) {
	?>
	<form action="<?=$namaFile?>.php" method="post" style="margin:20px">
		<center>
			<input type="text" name="search_name" placeholder="Cari <?=$namaKolom?>"> 
			<input type="submit" name="submit" value="Cari" style="background-color:rgba(100,100,255,1);color:white;
																padding:3px 10px;box-shadow:2px 2px 8px rgba(100,100,255,0.5);
																border:0px;border-radius:3px">
		</center>
	</form>
	<?php
}





function tbSb($nama) {
	?>
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
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li>
                        <a class="profile-pic" href="#">
                                <img src="plugins/images/logo_profil.png" alt="user-img" width="36"
                                    class="img-circle"><span class="text-white font-medium"><?=$nama?></span></a>
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
                        <div class="d-md-flex">
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
    </div>
	<?php
}


function messeji($title,$pesan,$icon) {
    ?>
    <script>
        swal.fire({
            title:"",
            icon:"<?=$icon?>",
            text:"<?=$pesan?>",
        });
    </script>
    <?php
}
?>
