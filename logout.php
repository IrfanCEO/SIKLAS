<?php
session_start();
if (!isset($_SESSION['session-admin'])) {
	echo "
	<script>
		document.location.href = 'login.php';
	</script>
	";
	exit;
} else {
	session_unset();
	session_destroy();
	echo "
	<script>
		document.location.href = 'index.php';
	</script>
	";
	exit;
}
?>