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
	<script src="https://code.jquery.com/jquery-3.6.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<link rel="shortcut icon" href="img/logo.png">
	<title>SIKLAS - Beranda</title>
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
				<a href="index.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3 active"><i class="fas fa-bezier-curve pe-3"></i>Beranda</a>
				<div class="list-group-item text-secondary fw-bold bg-transparent py-4">PROSES DATA</div>
				<a href="cari-siswa.php" class="list-group-item list-group-item-action text-white bg-transparent pb-3"><i class="fas fa-object-ungroup pe-3"></i>Cek Siswa</a>
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
						<h1>Beranda</h1>
						<p class="text-mute">Beranda</p>
						<div class="row mt-5">
							<div class="col-lg-6 mb-3">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title pb-3">Selamat Datang di SIKLAS</h4>
										<p style="text-align: justify;">Sistem Informasi Clustering SMKN 19 Samarinda merupakan sistem yang menampilkan hasil belajar siswa berdasarkan kelompok siswa berprestasi, kurang berprestasi, dan tidak berprestasi. Pengelompokan/Clustering siswa dilakukan menggunakan nilai persemester yang mana meliputi Nilai Pengetahuan, Nilai Absensi, Nilai Ekstrakurikuler, Nilai Sikap Spiritual, dan Nilai Sikap Sosial. Adanya sistem ini bertujuan untuk menjadi motivasi bagi peserta belajar dan juga menjadi bahan evaluasi bagi tenaga pengajar yang ada di SMKN 19 Samarinda</p>
									</div>
								</div>
							</div>
							<?php
				            $cluster1 = array();
				            $query1 = mysqli_query($koneksi, "SELECT nilai_cluster AS nilai FROM cluster WHERE jenis_cluster = 'Berprestasi'");
				            while ($baris= mysqli_fetch_array($query1)) {
				                $cluster1[] = $baris['nilai'];
				            }
				            $cluster2 = array();
				            $query2 = mysqli_query($koneksi, "SELECT nilai_cluster AS nilai FROM cluster WHERE jenis_cluster = 'Cukup Berprestasi'");
				            while ($baris= mysqli_fetch_array($query2)) {
				                $cluster2[] = $baris['nilai'];
				            }
				            $cluster3 = array();
				            $query3 = mysqli_query($koneksi, "SELECT nilai_cluster AS nilai FROM cluster WHERE jenis_cluster = 'Tidak Berprestasi'");
				            while ($baris= mysqli_fetch_array($query3)) {
				                $cluster3[] = $baris['nilai'];
				            }
				            $json_C1 = json_encode($cluster1);
				            $json_C2 = json_encode($cluster2);
				            $json_C3 = json_encode($cluster3);
				            ?>
				            <div class="col-lg-6">
				                <div class="card">
				                    <div class="card-body">
				                        <canvas id="1"></canvas>
				                        <p class="text-center text-danger fw-bold fst-italic mt-4">*Capaian Siswa SMKN 19 Samarinda tahun 2023, dalam Grafik Scatterplot</p>
				                    </div>
				                </div>
				            </div>
				            <script type="text/javascript">
				                var json_C1 = jQuery.parseJSON( '<?= $json_C1; ?> ' );
				                var json_C2 = jQuery.parseJSON( '<?= $json_C2; ?> ' );
				                var json_C3 = jQuery.parseJSON( '<?= $json_C3; ?> ' );
				                var plotData1 = [];
				                var plotData2 = [];
				                var plotData3 = [];
				                var rand = 0;
				                for (var i=0; i < Object.keys(json_C1).length; i++) {
				                    rand = Math.floor(Math.random() * 10) + 1;
				                    plotData1.push({'x': json_C1[i], 'y': rand});
				                }
				                for (var i=0; i < Object.keys(json_C2).length; i++) {
				                    rand = Math.floor(Math.random() * 10) + 1;
				                    plotData2.push({'x': json_C2[i], 'y': rand});
				                }
				                for (var i=0; i < Object.keys(json_C3).length; i++) {
				                    rand = Math.floor(Math.random() * 10) + 1;
				                    plotData3.push({'x': json_C3[i], 'y': rand});
				                }

				                const ctx = document.getElementById('1');
				                const data = {
				                    datasets: [{
				                        label: 'Berprestasi',
				                        data: plotData1,
				                        backgroundColor: 'rgb(84, 180, 53)'
				                    }, {
				                        label: 'Cukup Berprestasi',
				                        data: plotData2,
				                        backgroundColor: 'rgb(60, 121, 245)'                        
				                    }, {
				                        label: 'Tidak Berprestasi',
				                        data: plotData3,
				                        backgroundColor: 'rgb(255, 99, 132)'                        
				                    }],
				                };

				                new Chart(ctx, {
				                    type: 'scatter',
				                    data: data,
				                    options: {
				                        scales: {
				                            x: {
				                                type: 'linear',
				                                position: 'bottom'
				                            }
				                        }
				                    }
				                });
				            </script>
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