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
	<title>SIKLAS - Hasil Pengelompokan</title>
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
				<a href="data-jurusan.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3"><i class="fas fa-object-group pe-3"></i>Data Jurusan</a>
				<a href="pengelompokkan.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3 active"><i class="fas fa-drafting-compass pe-3"></i>Hasil Pengelompokan</a>
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
						<h1>Data Pengelompokan Siswa</h1>
						<p class="text-mute">Data Pengelompokan Siswa</p>
						<div class="row">
							<?php
							$query = mysqli_query($koneksi, "SELECT * FROM cluster");
							if (mysqli_num_rows($query) > 0) {
								$query = mysqli_query($koneksi, "TRUNCATE TABLE cluster");
								if (!$query) {
									echo "
									<script>
										alert('Gagal mengosongkan data');
										document.location.href = 'menu-admin.php';
									</script>
									";
								} else {
									echo "
									<script>
										document.location.href = 'pengelompokkan.php';
									</script>
									";
								}
							} else {
								$query_loop = mysqli_query($koneksi, "SELECT DISTINCT jurusan.jurusan AS jurusan, thajaran_smt.thajaran_smt AS thajaran_smt FROM siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa");
								while ($loop_all = mysqli_fetch_array($query_loop)) {
									$jurusan = $loop_all['jurusan'];
									$thajaran_smt = $loop_all['thajaran_smt'];
									$query = mysqli_query($koneksi, "SELECT siswa.nis, siswa.nama, nilai.pengetahuan, nilai.s_spiritual, nilai.ekskul, nilai.s_sosial, nilai.presensi FROM siswa JOIN nilai ON siswa.kode_siswa = nilai.kode_siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa WHERE jurusan.jurusan = '$jurusan' AND thajaran_smt.thajaran_smt = '$thajaran_smt'");
									$data = array();
									while ($baris = mysqli_fetch_array($query)) {
										$data[] = $baris;
									}

									$jumlahAtribut = count($data[0])/2;
									$jumlahData = count($data);

									$bagiData = round($jumlahData/3);
									$c1 = round(($bagiData/2)-1);
									$c2 = $bagiData+$c1;
									$c3 = ($bagiData*2)+$c1;

									$c1start = array();
									$c2start = array();
									$c3start = array();
									$dstart = array();

									for ($i=0; $i < $jumlahData; $i++) { 
										$ed = 0;
										for ($j=2; $j < $jumlahAtribut; $j++) { 
											$ed += pow($data[$i][$j]-$data[9][$j], 2);
										}
										$c1start[] = sqrt($ed);
										$ed1 = 0;
										for ($k=2; $k < $jumlahAtribut; $k++) { 
											$ed1 += pow($data[$i][$k]-$data[15][$k], 2);
										}
										$c2start[] = sqrt($ed1);
										$ed2 = 0;
										for ($l=2; $l < $jumlahAtribut; $l++) { 
											$ed2 += pow($data[$i][$l]-$data[23][$l], 2);
										}
										$c3start[] = sqrt($ed2);									
									}

									for ($i=0; $i < $jumlahData; $i++) { 
										if ($c1start[$i] < $c2start[$i] && $c1start[$i] < $c3start[$i]) {
											$dstart[] = "C1";
										} else if ($c2start[$i] < $c1start[$i] && $c2start[$i] < $c3start[$i]) {
											$dstart[] = "C2";
										} else if ($c3start[$i] < $c1start[$i] && $c3start[$i] < $c2start[$i]) {
											$dstart[] = "C3";
										} else if ($c1start[$i] == $c2start[$i]) {
											$dstart[] = "C1";
										} else if ($c2start[$i] == $c3start[$i]) {
											$dstart[] = "C2";
										} else if ($c1start[$i] == $c3start[$i]) {
											$dstart[] = "C1";
										}
									}

									$k1get = array();
									$k2get = array();
									$k3get = array();
									$av1 = array();
									$av2 = array();
									$av3 = array();

									$c1loop = array();
									$c2loop = array();
									$c3loop = array();
									$dloop = array();

									for ($i=2; $i < $jumlahAtribut; $i++) { 
										for ($j=0; $j < $jumlahData; $j++) { 
											if ($dstart[$j] == "C1") {
												$av1[] = $data[$j][$i];
											} else if ($dstart[$j] == "C2") {
												$av2[] = $data[$j][$i];
											} else if ($dstart[$j] == "C3") {
												$av3[] = $data[$j][$i];
											}
										}
										$k1get[] = array_sum($av1)/count($av1);
										$k2get[] = array_sum($av2)/count($av2);
										$k3get[] = array_sum($av3)/count($av3);
										$av1 = (array) null;
										$av2 = (array) null;
										$av3 = (array) null;
									}

									for ($i=0; $i < $jumlahData; $i++) { 
										$ed = 0;
										for ($j=2; $j < $jumlahAtribut; $j++) { 
											$ed += pow($data[$i][$j]-$k1get[$j-2], 2);
										}
										$c1loop[] = sqrt($ed);
										$ed1 = 0;
										for ($k=2; $k < $jumlahAtribut; $k++) { 
											$ed1 += pow($data[$i][$k]-$k2get[$k-2], 2);
										}
										$c2loop[] = sqrt($ed1);
										$ed2 = 0;
										for ($l=2; $l < $jumlahAtribut; $l++) { 
											$ed2 += pow($data[$i][$l]-$k3get[$l-2], 2);
										}
										$c3loop[] = sqrt($ed2);

										if ($c1loop[$i] < $c2loop[$i] && $c1loop[$i] < $c3loop[$i]) {
											$dloop[] = "C1";
										} else if ($c2loop[$i] < $c1loop[$i] && $c2loop[$i] < $c3loop[$i]) {
											$dloop[] = "C2";
										} else if ($c3loop[$i] < $c2loop[$i] && $c3loop[$i] < $c1loop[$i]) {
											$dloop[] = "C3";
										}
									}

									$cek = 0;
									for ($i=0; $i < count($dloop); $i++) { 
										if ($dstart[$i] == $dloop[$i]) {
											
										} else {
											$cek++;
										}
									}

									if ($cek > 0) {
										$ulang = true;
										while ($ulang) {
											$c1start = (array) null;
											$c2start = (array) null;
											$c3start = (array) null;
											$c1loop = (array) null;
											$c2loop = (array) null;
											$c3loop = (array) null;
											$dstart = (array) null;
											$dstart = $dloop;
											$dloop = (array) null;
											$k1get = (array) null;
											$k2get = (array) null;
											$k3get = (array) null;
											$getDRecord = (array) null;

											for ($i=2; $i < $jumlahAtribut; $i++) { 
												for ($j=0; $j < $jumlahData; $j++) { 
													if ($dstart[$j] == "C1") {
														$av1[] = $data[$j][$i];
													} else if ($dstart[$j] == "C2") {
														$av2[] = $data[$j][$i];
													} else if ($dstart[$j] == "C3") {
														$av3[] = $data[$j][$i];
													}
												}
												$k1get[] = array_sum($av1)/count($av1);
												$k2get[] = array_sum($av2)/count($av2);
												$k3get[] = array_sum($av3)/count($av3);
												$av1 = (array) null;
												$av2 = (array) null;
												$av3 = (array) null;
											}

											for ($i=0; $i < $jumlahData; $i++) { 
												$ed = 0;
												for ($j=2; $j < $jumlahAtribut; $j++) { 
													$ed += pow($data[$i][$j]-$k1get[$j-2], 2);
												}
												$c1loop[] = sqrt($ed);
												$ed1 = 0;
												for ($k=2; $k < $jumlahAtribut; $k++) { 
													$ed1 += pow($data[$i][$k]-$k2get[$k-2], 2);
												}
												$c2loop[] = sqrt($ed1);
												$ed2 = 0;
												for ($l=2; $l < $jumlahAtribut; $l++) { 
													$ed2 += pow($data[$i][$l]-$k3get[$l-2], 2);
												}
												$c3loop[] = sqrt($ed2);

												if ($c1loop[$i] < $c2loop[$i] && $c1loop[$i] < $c3loop[$i]) {
													$dloop[] = "C1";
												} else if ($c2loop[$i] < $c1loop[$i] && $c2loop[$i] < $c3loop[$i]) {
													$dloop[] = "C2";
												} else if ($c3loop[$i] < $c2loop[$i] && $c3loop[$i] < $c1loop[$i]) {
													$dloop[] = "C3";
												}
											}

											$cek1 = 0;
											for ($i=0; $i < count($dloop); $i++) { 
												if ($dstart[$i] == $dloop[$i]) {
													
												} else {
													$cek1++;
												}
											}

											if ($cek1 > 0) {
												
											} else {
												$ulang = false;
											}
										}
									}
									$getDRecord = array();
									for ($i=0; $i < count($c1loop); $i++) { 
										$getDRecord[] = max($c1loop[$i], $c2loop[$i], $c3loop[$i]);
									}

									$query_cluster = mysqli_query($koneksi, "SELECT siswa.kode_siswa AS kode_siswa FROM siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa WHERE jurusan.jurusan = '$jurusan' AND thajaran_smt.thajaran_smt = '$thajaran_smt'");

									$i = 0;
									while ($baris = mysqli_fetch_array($query_cluster)) {										$kode_siswa = $baris['kode_siswa'];

										$kluster = "";
										$nilai_kluster = $getDRecord[$i];
										if ($dloop[$i] == "C1") {
											$kluster = "Berprestasi";
										} else if ($dloop[$i] == "C2") {
											$kluster = "Cukup Berprestasi";
										} else if ($dloop[$i] == "C3") {
											$kluster = "Tidak Berprestasi";
										}

										$insert = mysqli_query($koneksi, "INSERT INTO cluster(kode_siswa, nilai_cluster, jenis_cluster) VALUES('$kode_siswa', '$nilai_kluster', '$kluster')");
										if (!$insert) {
											echo "
											<script>
												alert('Data gagal diproses');
												document.location.href = 'menu-admin.php';
											</script>
											";
										}
										$i++;
									}
								}
							}
							?>
							<div class="col-lg-12 mb-3">
								<div class="card">
									<div class="card-body">
										<div class="hstack gap-2">
											<h4 class="card-title pb-3">Data Pengelompokan Siswa Berdasarkan Jurusan dan Tahun Ajaran</h4>
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
										        			<a class="text-primary text-decoration-none" href="lihat-pengelompokkan.php?jurusan=<?= $baris['jurusan']; ?>&thajaran_smt=<?= $baris['thajaran_smt']; ?>"><i class="fas fa-eye me-2"></i>Lihat</a> <br>
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