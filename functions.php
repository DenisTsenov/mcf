<?php
error_reporting(E_ALL ^ E_NOTICE);
function my_header($title){
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen, projection"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.min.css" media="screen, projection"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap-theme.min.css" media="screen, projection"/>
	<script src='C:\xampp\htdocs\mcf\css\bootstrap\js\bootstrap.min.js'>
	</script>
	
	<script src='C:\xampp\htdocs\mcf\css\bootstrap\js\jquery-3.0.0.min.js'>
	</script>
	
	<title><?php echo  $title ;?></title>
</head>
<body>
<div class="container-fluid">
  <div class="row">
  <div class="center">
<?php

	if($_SESSION['is_logged'] === true){
			echo '<div class="col-sm-12"><kbd>Helloo '.$_SESSION['user_info']['login']."</kbd></div><br/>";
			echo '<div class="col-sm-4"><a href="index.php">Start</div> </a>';
			if($_SESSION['user_info']['type'] == 3){
				echo '<div class="col-sm-4"><a href="admin/index.php">Administrator panel</a></div>';
			}
			echo '<div class="col-sm-4"><a href="logout.php">Loguot</a></div>';
	}else{
		echo '<div class="col-sm-4"><a href="index.php">Start</div> </a><div class="col-sm-4"><a href = "register.php">Create  Account</a> </div> <div class="col-sm-4"><a href = "login.php">Enter in to your  account</a></div>';
	}
?>
</div></div></div>

<div class="container-fluid">
  <div class="row">
<?php
}

function my_adminheader($title){
	
	if($_SESSION['is_logged'] !== true || $_SESSION['user_info']['type'] != 3){
		header('Location: ../index.php');
		exit;
	}else{
		
	}
	?>
</div></div>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo  $title ;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/style.css" media="screen, projection"/>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap/css/bootstrap.min.css" media="screen, projection"/>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap/css/bootstrap-theme.min.css" media="screen, projection"/>
	<script src='C:\xampp\htdocs\mcf\css\bootstrap\js\bootstrap.min.js'>
	</script>
	
	<script src='C:\xampp\htdocs\mcf\css\bootstrap\js\jquery-3.0.0.min.js'>
	</script>
</head>
<body>
<div class="container-fluid" >
  <div class="row">
  <div class="center">
	<div class="col-sm-12" ><a href='../index.php'>Start</a></div>
	<div class="col-sm-12"><a href='groups.php'>Forum  groups</a></div> 
	<div class="col-sm-12" ><a href='sub_groups.php'>Sub groups</a></div> 
	<div class="col-sm-12"><a href='../logout.php'>Exit</a></div>
</div></div>
</div><br/>
<?php
}

function data_validated($dbc, $data){
	$data = mysqli_real_escape_string($dbc, $data);
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
	$data = strip_tags($data);
	return $data;	
}

function crypt_pass($input, $round=9){
	$salt="";
	$salt_chars=array_merge(range("A","Z"),range("a", "z"), range(0,9));
		for($i=0;$i<22;$i++){
			$salt.=$salt_chars[array_rand($salt_chars)];
		}
		return crypt($input, sprintf('$2y$%02d$', $round). $salt);
}

function db_connect(){
	$connection = mysqli_connect('localhost', 'Denis', 'deniscenov', 'mcf');

	if (!$connection) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error($connection) . PHP_EOL;
    exit;
	}
		mysqli_set_charset($connection, 'utf8');
		return $connection;
}

function sql_corect($dbc, $sql){
	mysqli_query($dbc, "SET NAMES utf8");
	mysqli_query($dbc, "SET CHARACTER SET 'utf8'");
	return mysqli_query($dbc, $sql);
}

function footer (){
	echo '</body></html>';
}










