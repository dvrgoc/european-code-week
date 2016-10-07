<?php require_once 'credentials.php'; ?>
<?php require_once 'config.php'; ?>

<?php $conn = connect2db($credentials); ?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Homepage</title>

	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/bootstrap-theme.css">
	<link rel="stylesheet" href="css/ecw.css">
</head>
<body class="container-fluid">
	<header class="row">
		<div class="container">
			<a class="logo" href="/" title="Logo">
				<img src="images/codeweekeu.png" alt="Europe Code Week"/>
			</a>
		</div>
		<nav class="container">
			<ul class="nav nav-pills">
				<li<?php echo (strpos($_SERVER["REQUEST_URI"], "/") !== false) ? ' class="active"' : '' ?>>
					<a href="<?php $_SERVER["SERVER_NAME"] ?>/">Home</a>
				</li>
				<li<?php echo (strpos($_SERVER["REQUEST_URI"], "categories.php") !== false) ? ' class="active"' : '' ?>>
					<a href="<?php $_SERVER["SERVER_NAME"] ?>/categories.php">Categories</a>
				</li>
				<li<?php echo (strpos($_SERVER["REQUEST_URI"], "products.php") !== false)  ? ' class="active"' : '' ?>>
					<a href="<?php $_SERVER["SERVER_NAME"] ?>/products.php">Products</a>
				</li>
				<li><a href="#">Search</a></li>
			</ul>
		</nav>
	</header>
	<div class="row">
		<div class="container">