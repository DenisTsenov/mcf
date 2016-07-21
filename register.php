<?php session_start();
require ('functions.php');  // sql_corect() is  used instead mysqli_query() because of utf8 encoding
if(!$_SESSION['is_logged'] == true){
	$db = db_connect();
	
	if($_POST['form_submit'] == 1){
		$error_array = array();
		$login = data_validated($db, $_POST['login']);
		$password = data_validated($db, $_POST['pass']);
		$password2 =  data_validated($db, $_POST['pass2']);
		$email = data_validated($db, $_POST['email']);
		$name = data_validated($db, $_POST['name']);
		$user_ip = $_SERVER['REMOTE_ADDR'];
			if(strlen($login) < 4){
				$error_array['login'] = 'Invlid name';
			}
			
			if(strlen($password) < 4){
				$error_array['pass'] = 'Invlid password';
			}
			
			if($password != $password2){
				$error_array['pass'] = 'Password do  not  match';
			}
			
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error_array['email'] = 'Invalid Email Addres';
			}
			
			if (!preg_match('/^[A-Za-z][A-Za-z]{3,31}$/', $name)){
				$error_array['name'] = 'Invalid  Name';
		}
		
		if(!count($error_array) > 0){ 	
			

			$result = sql_corect($db, 'SELECT COUNT(*) as cnt FROM users WHERE login = "'.$login.'" OR email = "'.$email.'"');
			$row = mysqli_fetch_assoc($result);
			if($row['cnt'] == 0){

				$res = sql_corect($db, 'INSERT INTO users (login, pass, real_name, email, date_registred, user_ip)
				VALUES("'.$login.'", "'.md5($password).'", "'.$name.'", "'.$email.'", '.time().',"'.$user_ip.'")');
				 mysqli_free_result($res);
				if(mysqli_error($db)){
					$error_array['sql'] = "<h3>Error! Please try  again!</h3>";
				}else{
					header('Location: index.php');
					exit;
				}
			}else{
				$error_array['login'] = 'Invlid name or email';
				$error_array['email'] = 'Invlid name or email';
			}
			mysqli_close($db);
		}
	}
	my_header('Registration');
	if($error_array['sql'] ){
		echo $error_array['sql'];
	}
	?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
		<div class="form-group">
			<label for="exampleInputEmail1">Login name</label>
			<input type="text" name='login' class="form-control" id="exampleInputEmail1" placeholder="Login"/><br/>
			<?php
			if($error_array['login']){
				echo $error_array['login'] ;
				}
			;?>
			<br/>
			<label for="exampleInputPassword1">Password</label>
			<input type="password" name='pass' class="form-control" id="exampleInputPassword1" placeholder="Password"/><br/>
			<?php
			if($error_array['pass']){
				echo $error_array['pass'] ;
				}
			;?>
			<br/>
			<label for="exampleInputPassword1">Repeat the password</label>
			<input type="password" name='pass2' class="form-control" id="exampleInputPassword1" placeholder="Password"/><br/>
			<?php
			if($error_array['pass']){
				echo $error_array['pass'] ;
				}
			;?>
			<br/>
			<label for="exampleInputEmail1">Email address</label>
			<input type="text" name='email' class="form-control" id="exampleInputEmail1" placeholder="Email"/><br/>
			<?php
			if($error_array['email']){
				echo $error_array['email'] ;
				}
			;?>
			<br/>
			<label for="exampleInputEmail1">Your  name</label>
			<input type="text" name='name' class="form-control" id="exampleInputEmail1" placeholder="Name"/><br/>
			<?php
			if($error_array['name']){
				echo $error_array['name'];
				}
			;?>
			<br/>
			<input type="hidden" name="form_submit" value='1'/>
			<input type="submit" name='submi' value='Create  account' class="btn btn-default"/>
			</div>
		</form>
	<?php
}else{
	header('Location: index.php');
	exit;
}
footer ();