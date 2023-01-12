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
	<title>SIKLAS - Data Siswa</title>
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
				<a href="data-siswa.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3 active"><i class="fas fa-object-ungroup pe-3"></i>Data Siswa</a>
				<a href="data-jurusan.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3"><i class="fas fa-object-group pe-3"></i>Data Jurusan</a>
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
						<h1>Data Siswa</h1>
						<p class="text-mute">Data Siswa</p>
						<div class="row mt-5">
							<div class="col-lg-12 mb-3">
								<div class="card">
									<div class="card-body">
										<div class="hstack gap-2">
											<h4 class="card-title pb-3">Data Akademik Siswa</h4>
											<a href="tambah-data-siswa.php" class="btn btn-primary ms-auto"><i class="fas fa-plus me-2"></i>Tambah Data Siswa</a>
										</div>
										<div class="table-responsive mt-3">
											<table id="data-siswa" class="cell-border" width="100%">
										        <thead>
										            <tr>
										                <th>No.</th>
										                <th>Jurusan</th>
										                <th>Tahun Ajaran, Semester</th>
										                <th>Aksi</th>
										            </tr>
										        </thead>
										        <tbody>
										        	<?php 
										        	$query = mysqli_query($koneksi, "SELECT DISTINCT jurusan.jurusan AS jurusan, thajaran_smt.thajaran_smt AS thajaran_smt FROM siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa");
										        	$i = 1;
										        	while ($baris = mysqli_fetch_array($query)) {
										        	?>
										        	<tr>
										        		<td><?= $i; ?></td>
										        		<td><?= $baris['jurusan']; ?></td>
										        		<td><?= $baris['thajaran_smt']; ?></td>
										        		<td>
										        			<a class="text-primary text-decoration-none" href="lihat-data.php?jurusan=<?= $baris['jurusan']; ?>&thajaran_smt=<?= $baris['thajaran_smt']; ?>"><i class="fas fa-eye me-2"></i>Lihat</a> <br>
										        			<a class="text-danger text-decoration-none" href="hapus-data.php?jurusan=<?= $baris['jurusan']; ?>&thajaran_smt=<?= $baris['thajaran_smt']; ?>"><i class="fas fa-trash me-2"></i>Hapus</a>
										        		</td>
										        	</tr>
										        	<?php
										        		$i++;
										        	}
										        	?>
										        </tbody>
										    </table>
										</div>
									</div>
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