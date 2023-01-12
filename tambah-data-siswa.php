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
						<h1>Tambah Data Siswa</h1>
						<p><a href="data-siswa.php" class="text-decoration-none">Data Siswa</a>/Tambah Data Siswa</p>
						<div class="row mt-5">
							<div class="col-lg-3 mb-3"></div>
							<div class="col-lg-6 mb-3">
								<div class="card">
									<form method="post" enctype="multipart/form-data">
										<div class="card-body">
											<h4 class="card-title pb-2">Tambah Data Siswa</h4>
											<hr>
											<div class="form-floating mb-3">
												<select name="jurusan" class="form-select" id="floatingSelect" aria-label="Floating label select example">
													<?php
													$query = mysqli_query($koneksi, "SELECT * FROM jurusan");
													while ($baris = mysqli_fetch_array($query)) {
													?>
													<option value="<?= $baris['kode_jurusan'] ?>"><?= $baris['jurusan']; ?></option>
													<?php
													}
													?>
												</select>
												<label for="floatingSelect">Jurusan</label>
											</div>
											<span class="fst-italic text-danger">*format: tahun/tahun,semester(ganjil atau genap) <br> *tanpa spasi</span>
											<div class="form-floating mb-3 mt-2">
												<input name="thajaran_smt" type="text" class="form-control text-uppercase" id="floatingInput" placeholder="Tahun Ajaran, Semester" pattern="[0-9]{4}/[0-9]{4},[a-zA-Z]{5-6}" required autocomplete="off">
												<label for="floatingInput">Tahun Ajaran,Semester</label>
											</div>
											<div class="mb-3">
												<label for="formFile" class="form-label">Data Siswa <br> <span class="fst-italic text-danger">*pastikan file berformat .CSV</span></label>
												<input name="csv" accept="text/csv" class="form-control" type="file" id="formFile" required>
											</div>
										</div>
										<div class="card-footer text-end">
											<button name="tambah" class="btn btn-primary">Tambah</button>
										</div>
									</form>
									<?php
									if (isset($_POST['tambah'])) {
										$tmp_csv = $_FILES['csv']['tmp_name'];
										$jurusan = strtoupper(htmlspecialchars($_POST['jurusan']));
										$thajaran_smt = strtoupper(htmlspecialchars($_POST['thajaran_smt']));
										$delimiter = "";
										$data = array();

										$file = fopen($tmp_csv, "r");
										$cek_comma = fgetcsv($file, 0, ',');
										if ($cek_comma) {
											$delimiter = ",";
										} else {
											$delimiter = ";";
										}
										fclose($file);

										$row = file($tmp_csv);
										$file = fopen($tmp_csv, "r");
										$baris = 0;
										while ($baris < count($row)) {
											$data[] = fgetcsv($file, 0, $delimiter);
											$baris++;
										}
										fclose($file);

										$cek_exist = mysqli_query($koneksi, "SELECT siswa.nama AS nama, jurusan.jurusan AS jurusan, thajaran_smt.thajaran_smt AS thajaran_smt FROM siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa WHERE thajaran_smt = '$thajaran_smt'");

										if (mysqli_num_rows($cek_exist) > 0) {
											echo "
											<script>
												alert('Data siswa telah terdaftar, mohon masukkan data yang lain');
												document.location.href = 'data-siswa.php';
											</script>
											";
										} else {
											for ($i=1; $i < count($data); $i++) {
												$kode_siswa = rand(11111111,99999999);
												$nis = $data[$i][0];
												$nama = $data[$i][1];
												$pengetahuan = $data[$i][2];
												$s_spiritual = $data[$i][3];
												$ekskul = $data[$i][4];
												$s_sosial = $data[$i][5];
												$presensi = $data[$i][6];
												
												$table_1 = mysqli_query($koneksi, "INSERT INTO siswa(kode_siswa, nis, kode_jurusan, nama) VALUES('$kode_siswa', '$nis', '$jurusan', '$nama')");
												$table_2 = mysqli_query($koneksi, "INSERT INTO thajaran_smt(kode_siswa, thajaran_smt) VALUES('$kode_siswa', '$thajaran_smt')");
												$table_3 = mysqli_query($koneksi, "INSERT INTO nilai(kode_siswa, pengetahuan, s_spiritual, ekskul, s_sosial, presensi) VALUES('$kode_siswa', '$pengetahuan', '$s_spiritual', '$ekskul', '$s_sosial', '$presensi')");

												if (!$table_1 && !$table_2 && !$table_3) {
													echo "
													<script>
														alert('Data gagal ditambah');
														document.location.href = 'data-siswa.php';
													</script>
													";
												} else {
													echo "
													<script>
														alert('Data berhasil ditambah');
														document.location.href = 'data-siswa.php';
													</script>
													";
												}

											}
											
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
	    $('#alternatif').DataTable();
	});
</script>
</body>
</html>