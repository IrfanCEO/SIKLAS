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

$query1 = mysqli_query($koneksi, "DELETE siswa, nilai, thajaran_smt FROM siswa JOIN nilai ON siswa.kode_siswa = nilai.kode_siswa JOIN jurusan ON siswa.kode_jurusan = jurusan.kode_jurusan JOIN thajaran_smt ON siswa.kode_siswa = thajaran_smt.kode_siswa WHERE jurusan.jurusan = ANY(SELECT jurusan FROM jurusan WHERE kode_jurusan = '$id')");

$query2 = mysqli_query($koneksi, "DELETE FROM jurusan WHERE kode_jurusan = '$id'");

if ($query1 && $query2) {
	echo "
	<script>
		alert('Data berhasil dihapus');
		document.location.href = 'data-jurusan.php';
	</script>
	";
} else {
	echo "
	<script>
		alert('Data gagal dihapus');
		document.location.href = 'data-jurusan.php';
	</script>
	";
}
?>