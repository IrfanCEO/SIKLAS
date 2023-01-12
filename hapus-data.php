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

$query = mysqli_query($koneksi, "DELETE siswa, nilai, thajaran_smt FROM siswa JOIN nilai ON siswa.kode_siswa = nilai.kode_siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa WHERE jurusan.jurusan = '$jurusan' AND thajaran_smt.thajaran_smt = '$thajaran_smt'");

if ($query) {
	echo "
	<script>
		alert('Data berhasil dihapus');
		document.location.href = 'data-siswa.php';
	</script>
	";
} else {
	echo "
	<script>
		alert('Data gagal dihapus');
		document.location.href = 'data-siswa.php';
	</script>
	";
}
?>