<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['session-admin'])) {
	echo "
	<script>
		document.location.href = 'login.php';
	</script>
	";
	exit;
}

if (!isset($_GET['id'])) {
	echo "
	<script>
		document.location.href = '404.php';
	</script>
	";
	exit;
}
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
	<link rel="shortcut icon" href="img/logo.png">
	<title>SIKLAS - Data Jurusan</title>
</head>
<body>
	<div class="sidebar sidebar-wrapper d-flex position-fixed overflow-auto bg-dark">
		<a class="close text-white mx-3 my-2 position-absolute top-0 end-0 fs-4 invisible"><i class="fas fa-times"></i></a>
		<div class="bg-dark">
			<div class="text-white p-2 fs-5 fw-bold text-uppercase">
				<img src="img/logo.png" width="40"> SIKLAS
			</div>
			<div class="list-group list-group-flush my-4 border-none">
				<div class="list-group-item text-secondary fw-bold bg-transparent pb-4">MENU UTAMA</div>
				<a href="menu-admin.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3"><i class="fas fa-bezier-curve pe-3"></i>Beranda</a>
				<div class="list-group-item text-secondary fw-bold bg-transparent py-4">PROSES DATA</div>
				<a href="data-siswa.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3"><i class="fas fa-object-ungroup pe-3"></i>Data Siswa</a>
				<a href="data-jurusan.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3 active"><i class="fas fa-object-group pe-3"></i>Data Jurusan</a>
				<a href="pengelompokkan.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3"><i class="fas fa-drafting-compass pe-3"></i>Hasil Pengelompokan</a>
				<div class="list-group-item text-secondary fw-bold bg-transparent py-4">ADMIN DATA</div>
				<a href="logout.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3"><i class="fas fa-user-tie pe-3"></i>Logout</a>
			</div>
		</div>
	</div>
	<div class="main main-wrapper">
		<nav class="navbar navbar-expand-lg bg-dark">
			<div class="container bg-dark">
				<a class="bars px-2 text-white fs-5"><i class="fas fa-bars ps-3 pe-4"></i></a>
				<div class="nav-title text-white fw-bold text-uppercase py-2">
					SISTEM INFORMASI KLASTERING SMKN 19 SAMARINDA
				</div>
			</div>
		</nav>
		<main>
			<div class="container">
				<div class="row mt-5 px-3">
					<div class="col-lg-12">
						<h1>Edit Data Jurusan</h1>
						<p class="text-mute"><a href="data-jurusan.php" class="text-decoration-none">Data Jurusan</a>/Edit Data Jurusan</p>
						<div class="row mt-5">
							<div class="col-lg-3 mb-3"></div>
							<div class="col-lg-6 mb-3">
								<div class="card">
									<form method="post" enctype="multipart/form-data">
										<div class="card-body">
											<h4 class="card-title pb-2">Edit Data Jurusan</h4>
											<hr>
											<?php
											$query = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE kode_jurusan = '$id'");
											$baris = mysqli_fetch_array($query);
											?>
											<div class="form-floating mb-3">
												<input name="kode_jurusan" type="text" pattern="[0-9]{4}" class="form-control text-uppercase" id="floatingInput" placeholder="Kode Jurusan" value="<?= $baris['kode_jurusan']; ?>" required autocomplete="off">
												<label for="floatingInput">Kode Jurusan</label>
											</div>
											<div class="form-floating mb-3">
												<input name="jurusan" type="text" class="form-control text-uppercase" id="floatingInput" placeholder="Jurusan" value="<?= $baris['jurusan']; ?>" required autocomplete="off">
												<label for="floatingInput">Jurusan</label>
											</div>
										</div>
										<div class="card-footer text-end">
											<button name="edit" class="btn btn-primary">Edit</button>
										</div>
									</form>
									<?php
									if (isset($_POST['edit'])) {
										$kode_jurusan = strtoupper(htmlspecialchars($_POST['kode_jurusan']));
										$jurusan = strtoupper(htmlspecialchars($_POST['jurusan']));
										
										$table1 = mysqli_query($koneksi, "UPDATE jurusan SET kode_jurusan = '$kode_jurusan', jurusan = '$jurusan' WHERE kode_jurusan = '$id'");
										$table2 = mysqli_query($koneksi, "UPDATE siswa SET kode_jurusan = '$kode_jurusan'");

										if (!$table1 && !$table2) {
											echo "
											<script>
												alert('Data gagal diedit');
												document.location.href = 'data-jurusan.php';
											</script>
											";
										} else {
											echo "
											<script>
												alert('Data berhasil diedit');
												document.location.href = 'data-jurusan.php';
											</script>
											";
										}

									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
	<div class="footer">
		<hr>
		<div class="container">
			<p class="text-end">copyright&#169; Febrina Wahyu Ibtyani 2022</p>
		</div>
	</div>

<script src="js/bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
<script src="js/styles.js"></script>
<script src="js/jquery.dataTables.js"></script>
<script>
	$(document).ready(function () {
	    $('#data-siswa').DataTable();
	});
</script>
</body>
</html>