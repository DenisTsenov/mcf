<?php 
session_start();
require ('functions.php');
$dbc = db_connect();
$cat_id = data_validated($dbc, (int)$_GET['id']);
if($cat_id > 0){
	$res = sql_corect($dbc, 'SELECT name, active FROM category WHERE category_id = '.$cat_id.' AND active = 1');
	
	if(mysqli_num_rows($res) == 1){
		$row = mysqli_fetch_assoc($res);
		
			my_header($row['name']);
				if($_SESSION['is_logged'] === true){
					echo '<a href="post.php?id='.$cat_id.'"><h4>New theme!</h4></a>';
				}
				
				//view_counter
				$user_ip = $_SERVER['REMOTE_ADDR'];
				$result;
				$new_count = null;
				
				$res = sql_corect($dbc, 'SELECT user_ip FROM users');
				$num_rows = mysqli_num_rows($res);
				
				if($num_rows == 0)
				{
					mysqli_free_result($num_rows);
				}elseif($num_rows == 1){
				
					$row = mysqli_fetch_assoc($res);
						$reg_ip = $row['user_ip'];
						if($reg_ip == $user_ip){
							$result = true;
							break;
						}else{
							$result = false;
						}
						if(!$result){
						 $current_views = sql_corect($dbc, 'SELECT  view_count FROM posts');
							$row_views = mysqli_fetch_assoc($current_views);
								$current_counts = $row_views['view_count'];
								$new_count = $current_counts + 1;
								$update_views = sql_corect($dbc, "UPDATE `mcf` . `posts` SET `view_count`= $new_count WHERE cat_id = ".$cat_id);
						}
						mysqli_free_result($num_rows);
						mysqli_free_result($current_views);
						mysqli_free_result($update_views);
				}
				
			
				//end of view_counter
				
				//pagination
				$limit = 2;
				
				if((int)$_GET['page'] > 0){
					$page = mysqli_real_escape_string($dbc, (int)$_GET['page']-1);
				}else{
					$page = 0;
				}
				
				$rs = sql_corect($dbc, 'SELECT SQL_CALC_FOUND_ROWS post_id, login, date_added, title, content, view_count, added_by FROM posts , users 
				WHERE posts.cat_id = '.$cat_id.' AND posts.added_by = users.user_id ORDER BY date_added DESC LIMIT '.($limit * $page).','.$limit);
				
				$count = sql_corect($dbc, 'SELECT FOUND_ROWS() as mx');
				$res = mysqli_fetch_assoc($count);
				$max_count = $res['mx'];
				
				$max_page = ceil($max_count/$limit);
				
				echo '<div id="posts">';
				$user_id = $_SESSION['user_info']['user_id'];
				$user_login = $_SESSION['user_info']['login'];
				if($user_id){
				
				$added = sql_corect($dbc, 'SELECT added_by FROM posts WHERE added_by = '.$user_id);
					$result = mysqli_fetch_assoc($added);
					
					if($user_id == $result['added_by']){
						while($row = mysqli_fetch_assoc($rs)){
							echo '<div class="container-fluid">
							<div class="row"><div class="post">';
							if($user_login == $row['login']){
								echo '<a href="user/redact.php?id='.$row['post_id'].'"><button class="btn btn-default">Redact your post</button></a> | ';
								echo '<a href="user/delete.php?delp='.$row['post_id'].'""><button class="btn btn-default">Delete this post</button></a><br/>';
							}
							echo $resul = 
								$row['login']
								.'<p>'.date('Y-F-d/H:i:s-A',$row['date_added']).'</p>
							<p>'.$row['title'].'</p>'.$row['content'].
							'</div></div></div></br>';			
						}	
						
					}else{
						while($row = mysqli_fetch_assoc($rs)){
							echo $resul = 
							'<div class="container-fluid">
							<div class="row"><div class="post">'
								.$row['login']
								.'<p>'.date('Y-F-d/H:i:s-A',$row['date_added']).'</p>
								<p>'.$row['title'].'</p>'.$row['content'].$res['added_by'].
							'</div></div></div></br>';			
			
						}	
					}
				}else{
					while($row = mysqli_fetch_assoc($rs)){
							
							echo $resul = 
							'<div class="container-fluid">
							<div class="row"><div class="post">'
								.$row['login']
								.'<p>'.date('Y-F-d/H:i:s-A',$row['date_added']).'</p>
								<p>'.$row['title'].'</p>'.$row['content'].$res['added_by'].
							'</div></div></div></br>';			
			
						}	
						
				}
				//mysqli_free_result($result);
				 mysqli_free_result($rs);
				 mysqli_free_result($count);
				echo '</div>';
				
				
				if($page >= 1){
					echo '<a href="topic.php?id='.$cat_id.'&page='.($page).'">Previous page | </a>';
				}
				
				for($i = 0; $i < $max_page; $i++){
					if($i == $page){
						echo ($i + 1).' | ';
					}else{
						echo '<a href="topic.php?id='.$cat_id.'&page='.($i + 1).'">'.($i + 1).' | </a>';
					}
				}
				
				if($page < ($max_page - 1)){
					echo '<a href="topic.php?id='.$cat_id.'&page='.($page + 2).'"> Next page</a>';
				}
				
				
				//end of  pagination
				mysqli_close($dbc);
			footer();
			
	}else{
		header('Location: index.php');
		exit;
	}
}else{
	header('Location: index.php');
	exit;
}
