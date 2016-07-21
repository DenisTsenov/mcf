<?php
session_start();
require ('../functions.php');
my_header("Redact");
$dbc = db_connect();
$post_id = data_validated($dbc, (int)$_GET['id']);

if($post_id > 0){
	
	$new_title = data_validated($dbc, $_POST['post_name']);
	$new_description = data_validated($dbc, $_POST['desc']);
	
		$res = sql_corect($dbc, 'SELECT title, content, cat_id FROM posts WHERE post_id = '.$post_id);
		$result = mysqli_fetch_assoc($res);
			$q = sql_corect($dbc, 'SELECT group_cat_id FROM group_cat WHERE group_cat_id = '.$result['cat_id']);
			$r = mysqli_fetch_assoc($q);
			
			if($_POST['np'] == 1){
				
				if(strlen($new_title) > 2 && strlen($new_description) > 4 ){
					
					sql_corect($dbc, 'UPDATE posts SET title = "'.$new_title.'", content = "'.$new_description.'" WHERE post_id = '.$post_id);
					header('Location: ../topic.php?id='.$r['group_cat_id']);
					
				}else{
					echo '<h2>Invalid Group or Description</h2>';
				}
			}
			//because of  some reason  the action of  the  form  do not work....
		echo' <form  method="POST">
				<div class="form-group">
				Post name:<input type="text" name="post_name" value="'.$result['title'].'"></br><br/>
				<label for="comment">Description:</label>
				<textarea name="desc" class="form-control" rows="5" id="comment">'.$result['content'].'</textarea></br><br/>
				<input type="submit" class="btn btn-info" value="Redact post">
				<input type="hidden" name="np" value="1">
				</div></form>';
	
	}else{
		mysqli_free_result($result);
		mysqli_free_result($result);
	echo "<h2>No results Found</h2>";
}
footer();











