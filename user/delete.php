<?php
session_start();
require ('../functions.php');
//my_header("Begining");
$dbc = db_connect();
$delp = (int)$_GET['delp'];
if($delp > 0){
	
		$res = sql_corect($dbc, 'SELECT cat_id FROM posts WHERE post_id = '.$delp);
		$result = mysqli_fetch_assoc($res);
	
			$q = sql_corect($dbc, 'SELECT group_cat_id FROM group_cat WHERE group_cat_id = '.$result['cat_id']);
			$r = mysqli_fetch_assoc($q);
	
		$del_q = sql_corect($dbc, 'DELETE FROM posts WHERE post_id ='.$delp);
		if($del_q){
			header('Location: ../topic.php?id='.$r['group_cat_id']);
		}else{
			echo "<h2>You can't delete  the  post</h2>";
		}
}else{
	header('Location: ../index.php');
}

