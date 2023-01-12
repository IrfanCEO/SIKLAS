<?php
session_start();
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
	<title>SIKLAS - Login</title>
</head>
<body>
	<div class="container">
		<div class="row mb-3">
			<div class="col-lg-3"></div>
			<div class="col-lg-6" style="margin-top: 5rem;">
				<div class="card">
					<form method="post">
						<div class="card-body">
							<h4 class="card-title">Menu Login</h4>
							<p class="fst-italic text-danger">*Untuk melanjutkan ke dashbord Admin, silahkan login terlebih dahulu</p>
							<hr>						
							<div class="form-floating mb-4">
								<input name="username" type="text" class="form-control" id="floatingInput" placeholder="Username" required autocomplete="off">
								<label for="floatingInput">Username</label>
							</div>
							<div class="form-floating mb-4">
								<input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required autocomplete="off">
								<label for="floatingPassword">Password</label>
							</div>
						</div>
						<div class="card-footer text-end">
							<div class="btn-group py-2">
								<button name="login" class="btn btn-primary">Login</button>
								<a href="index.php" class="btn btn-dark">Batal</a>
							</div>
						</div>						
					</form>
					<?php
					if (isset($_POST['login'])) {
						$username = htmlspecialchars($_POST['username']);
						$password = htmlspecialchars($_POST['password']);

						if ($username === "admin" && $password === "admin") {
							$_SESSION['session-admin'] = true;
							echo "
							<script>
								alert('Login berhasil');
								document.location.href = 'menu-admin.php';
							</script>
							";
						} else {
							echo "
							<script>
								alert('Login gagal');
								document.location.href = 'login.php';
							</script>
							";
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="footer mt-4">
		<hr>
		<div class="container">
			<p class="text-end pb-3">copyright&#169; Febrina Wahyu Ibtyani 2022</p>
		</div>
	</div>
</body>
</html>