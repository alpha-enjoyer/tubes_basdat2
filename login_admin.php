<?php
include_once("functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!-- MDB icon -->
    <link rel="icon" href="MDB5-4.4.0/img/mdb-favicon.ico" type="image/x-icon" />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <!-- Google Fonts Roboto -->
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
    />
    <!-- MDB -->
    <link rel="stylesheet" href="MDB5-4.4.0/css/mdb.min.css" />
    <!-- Swal -->
    <script src="dist/sweetalert2.all.min.js"></script>


    <title>Login Admin</title>
</head>
<body>
<style>
    .bg-image-vertical {
position: relative;
overflow: hidden;
background-repeat: no-repeat;
background-position: right center;
background-size: auto 100%;
}

@media (min-width: 1025px) {
.h-custom-2 {
height: 100%;
}
}
.form-control:focus {
  color: #212529;
  background-color: #fff;

    border-color:  red;
    outline: 0;

    box-shadow: 0 0 0 0.25rem rgb(235 56 66 );
}
</style>
<section class="vh-100">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6 text-black">
        <div class="px-5 ms-xl-4 mt-5">
          <!-- <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i> -->
          <table>
            <tr>
              <td>
                <img src="plugins/images/icons8-clown-48.png" alt="">
              </td>
              <td>
                <span class="h1 fw-bold mb-0">SIK - O</span>
              </td>
            </tr>
          </table>
        </div>

        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
        
        <form action="login_admin.php" method="POST" style="width: 23rem;">

            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>

            <div class="form-outline mb-4">
              <input type="text" name="id_karyawan" id="form2Example18" class="form-control form-control-lg" />
              <label class="form-label" for="form2Example18" >Id Karyawan</label>
            </div>

            <div class="form-outline mb-4">
              <input type="password" name="password" id="form2Example28" class="form-control form-control-lg" />
              <label class="form-label" for="form2Example28" >Password</label>
            </div>

            <div class="pt-1 mb-4">
              <button class="btn btn-danger btn-lg btn-block" type="submit" name="btnLogin">Login</button>
            </div>

              <div class="pt-1 mb-4">
                <a href="index.php" class="btn btn-info btn-lg btn-block">Kembali</a>
              </div>
            
          </form>
          
          
          <?php
          if(isset($_POST["btnLogin"])) {
              $db = dbConnect();
              $id_karyawan = $db->escape_string($_POST["id_karyawan"]);
              $password = $db->escape_string($_POST["password"]);
              $res = $db->query("SELECT * FROM karyawan WHERE id_karyawan='$id_karyawan' AND pass='$password' AND id_pengguna='1'");
              if($res->num_rows>0) {
                $data = $res->fetch_assoc();
                session_start();
                $_SESSION["id"] = $data["id_karyawan"];
                $_SESSION["nama"] = $data["nama"];
                $_SESSION["hak_akses"] = $data["id_pengguna"];
                header("Location:dashboard_admin.php");
              } else {
                ?>
                  <script>
                    swal.fire({
                        title:"",
                        icon:"warning",
                        text:"Id atau Password salah, atau anda bukan merupakan admin",
                        //EDIT CONFIRM BUTTON
                    });
                  </script>
                <?php
              }
          }
          ?>
        </div>
        
      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
        <img src="plugins/images/joker.jpg"
          alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: center;">
      </div>
    </div>
  </div>
</section>


<script type="text/javascript" src="MDB5-4.4.0/js/mdb.min.js"></script>
<script type="text/javascript"></script>
</body>
</html>