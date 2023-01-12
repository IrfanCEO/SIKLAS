<?php
session_start();
include 'koneksi.php';
if (isset($_SESSION['session-admin'])) {
	echo "
	<script>
		document.location.href = 'menu-admin.php';
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
	<link rel="shortcut icon" href="img/logo.png">
	<title>SIKLAS - Cari Siswa</title>
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
				<a href="index.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3"><i class="fas fa-bezier-curve pe-3"></i>Beranda</a>
				<div class="list-group-item text-secondary fw-bold bg-transparent py-4">PROSES DATA</div>
				<a href="cari-siswa.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3 active"><i class="fas fa-object-ungroup pe-3"></i>Cari Siswa</a>
				<div class="list-group-item text-secondary fw-bold bg-transparent py-4">ADMIN DATA</div>
				<a href="login.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3"><i class="fas fa-user-tie pe-3"></i>Login</a>
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
						<h1>Cari Siswa</h1>
						<p class="text-mute">Cari Siswa</p>
						<div class="row mt-5">
							<div class="col-lg-3 mb-3"></div>
							<div class="col-lg-6 mb-3">
								<div class="card">
									<div class="card-body text-center">
										<h3 class="card-title mb-3">Pencarian Data Akademik Siswa</h3>
										<i class="fas fa-user-circle fs-1 mb-3"></i>
										<p class="fst-italic text-danger">*masukkan kode siswa untuk melakukan pencarian data akademik siswa</p>
										<hr class="mb-5">
										<form method="post">
											<div class="form-floating my-4">
												<input name="nis" type="text" class="form-control" id="floatingInput" placeholder="Kode Siswa" required autocomplete="off">
												<label for="floatingInput">Kode Siswa</label>
											</div>
											<button name="cari" class="btn btn-primary w-25">Cari</button>
										</form>										
									</div>
								</div>
							</div>
							<div class="col-lg-3"></div>
							<?php
							if (isset($_POST['cari'])) {
								$nis = htmlspecialchars($_POST['nis']);
								$query = mysqli_query($koneksi, "SELECT siswa.nis AS nis, siswa.nama AS nama, jurusan.jurusan AS jurusan, thajaran_smt.thajaran_smt AS thajaran_smt, cluster.jenis_cluster AS cluster FROM siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa JOIN cluster ON siswa.kode_siswa = cluster.kode_siswa WHERE siswa.nis = '$nis'");
								if (mysqli_num_rows($query) > 0) {
									while ($data = mysqli_fetch_array($query)) {
							?>
							<div class="col-lg-3"></div>
							<div class="col-lg-6">
								<div class="alert alert-success" role="alert">
									<h4 class="alert-heading">Berhasil!!!</h4>
									<hr>
									<h3><?= $data['nama']; ?><span class="fw-lighter"> - <?= $data['nis']; ?></span></h3>
									<h5><?= $data['jurusan']?> <?= $data['thajaran_smt']; ?></h5>
									<h5>Siswa termasuk dalam kelompok <?= strtolower($data['cluster']); ?></h5>
								</div>
							</div>
							<div class="col-lg-3"></div>
							<?php
									}
								} else {
							?>
							<div class="col-lg-3"></div>
							<div class="col-lg-6">
								<div class="alert alert-danger" role="alert">
									<h4 class="alert-heading">Gagal!!!</h4>
									<hr>
									<p>NIS tidak berhasil ditemukan mohon masukkan NIS dengan benar!</p>
								</div>
							</div>
							<?php
								}
							}
							?>
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
<script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
<script src="js/styles.js"></script>
</body>
</html>