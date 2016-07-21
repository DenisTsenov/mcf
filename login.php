<?php session_start();
require ('functions.php'); // sql_corect() is  used instead mysqli_query() because of utf8 encoding
if($_POST['form_submit'] == 1){
	$dbc = db_connect();
	$login = data_validated($dbc, $_POST['username']);
	$password = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	
		if(strlen($login) > 3 && strlen($password) > 3){
			
			
			$res = sql_corect($dbc, 'SELECT * FROM  users WHERE login = "'.$login.'" AND pass = "'.md5($password).'"');
			$login_error = array();
				if(mysqli_num_rows($res) == 1){
					$row = mysqli_fetch_assoc($res);
						if($row['active'] == 1){
						
						$_SESSION['is_logged'] = true;
						$_SESSION['user_info'] = $row;
						
					header('Location: index.php');
					exit;
				}else{
					echo 'Access forbidden';
				}
			}elseif(mysqli_num_rows($res) == 0){
				echo $login_error['no_user_found'] = '<h3>Wrong  email or  password</h3>';
			}
			 mysqli_free_result($res);
		}else{
			$login_error['error'] = 'Too short name or password';
		}
		mysqli_close($dbc);
}
my_header("Entrance");
?>
	<form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>
	<div class="form-group">
		<label for="exampleInputEmail1">Login</label>
		<input type='text' name='username' class="form-control" id="exampleInputEmail1" placeholder="Email"></br>
		<?php
		if($login_error['error']){
			echo $login_error['error'];
		}
		?></br>
		<label for="exampleInputEmail1">Password</label>
		<input type='password' name='pass' class="form-control" id="exampleInputEmail1" placeholder="Email"></br>
		<?php
		if($login_error['error']){
			echo $login_error['error'];
		}
		?></br>
		<input  type='submit' value='Login' class="btn btn-default">
		<input  type='hidden' value='1' name="form_submit" >
		</div>
	</form>
<?php
footer();