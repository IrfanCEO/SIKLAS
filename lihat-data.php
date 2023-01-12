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
if (!isset($_GET['jurusan']) && !isset($_GET['thajaran_smt'])) {
	echo "
	<script>
		document.location.href = '404.php';
	</script>
	";
	exit;
}
$jurusan = $_GET['jurusan'];
$thajaran_smt = $_GET['thajaran_smt'];
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
						<p><a href="data-siswa.php" class="text-decoration-none">Data Siswa</a>/Lihat Data Siswa</p>
						<div class="row mt-5">
							<div class="col-lg-12 mb-3">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title pb-3">Data Siswa Jurusan <?= $jurusan." ".$thajaran_smt; ?></h4>
										<div class="table-responsive">
											<table id="alternatif" class="cell-border" width="100%">
										        <thead>
										            <tr>
										                <th>No.</th>
										                <th>Kode Siswa</th>
										                <th>Nama Siswa</th>
										                <th>Nilai Pengetahuan</th>
										                <th>Nilai Sikap Spiritual</th>
										                <th>Nilai Ekstrakulikuler</th>
										                <th>Nilai Sikap Sosial</th>
										                <th>Nilai Presensi</th>
										            </tr>
										        </thead>
										        <tbody>
										        	<?php 
										        	$query = mysqli_query($koneksi, "SELECT siswa.nis AS nis, siswa.nama AS nama, nilai.pengetahuan AS pengetahuan, nilai.s_spiritual AS s_spiritual, nilai.ekskul AS ekskul, nilai.s_sosial AS s_sosial, nilai.presensi AS presensi, jurusan.jurusan AS jurusan, thajaran_smt.thajaran_smt AS thajaran_smt FROM siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa JOIN nilai ON siswa.kode_siswa = nilai.kode_siswa WHERE jurusan.jurusan = '$jurusan' AND thajaran_smt.thajaran_smt = '$thajaran_smt'");
										        	$i = 1;
										        	while ($baris = mysqli_fetch_array($query)) {
										        	?>
										        	<tr>
										        		<td><?= $i; ?></td>
										        		<td><?= $baris['nis']; ?></td>
										        		<td><?= $baris['nama']; ?></td>
										        		<td><?= $baris['pengetahuan']; ?></td>
										        		<td><?= $baris['s_spiritual']; ?></td>
										        		<td><?= $baris['ekskul']; ?></td>
										        		<td><?= $baris['s_sosial']; ?></td>
										        		<td><?= $baris['presensi']; ?></td>
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
	    $('#alternatif').DataTable();
	});
</script>
</body>
</html>