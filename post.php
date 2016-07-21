<?php session_start();
require ('functions.php');
$dbc = db_connect();
	$cat_id = (int)$_GET['id'];
	$res = sql_corect($dbc, 'SELECT category_id, name FROM category WHERE category_id = '.data_validated($dbc, $cat_id).' AND active = 1');
		
		if($_SESSION['is_logged'] === true && mysqli_num_rows($res) == 1){
		
			if($_POST['new_post'] == 1){
				
				$error_array = array();
				$new_name = data_validated($dbc, $_POST['title']);
				$new_desc = data_validated($dbc, $_POST['content']);
				
				if(strlen($new_name) < 3 ){
					$error_array ['short_name'] = '<h3>Too short  name</h3>';
				}
				
				if(strlen($new_desc) < 7 ){
					$error_array ['short_desc'] = '<h3>Too short description</h3>';
				}
				
				if(strlen($new_desc) > 3000 ){
					$error_array ['long_desc'] = '<h3>Too long description</h3>';
				}
					
			if(count($error_array) == 0){
				sql_corect($dbc, 'INSERT INTO posts(cat_id, added_by, date_added, title, content)VALUES
				('.$cat_id.', '.$_SESSION['user_info']['user_id'].', '.time().', "'.$new_name.'", "'.$new_desc.'")');
				
				header('Location: topic.php?id='.$cat_id);
				exit;
				}
				
		}
			$row = mysqli_fetch_assoc($res);
			my_header("New theme-".$row['name']);
			mysqli_free_result($res);
			echo '<div class="form-group">
			<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$cat_id.'" method="POST"><br/>
				Title:<input  type="text" name="title"><br/><br/>';
				if($error_array['short_name']){
					echo $error_array['short_name'];
				}
				echo '<label for="comment">Description:</label>
				<br/><textarea name="content" class="form-control" rows="5" id="comment"></textarea></br><br/>';
				if($error_array['short_desc']){
					echo $error_array['short_desc'];
				}
				echo '<input type="submit" class="btn btn-info" value="Add theme">
				<input type="hidden" name="new_post" value="1">
				</form></div>';
		mysqli_close($dbc);
		footer();
}else{
	header('Location: index.php');
	exit;
}