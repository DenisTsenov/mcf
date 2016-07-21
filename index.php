<?php 
session_start();
require ('functions.php');
my_header("Begining");
$dbc = db_connect();
//search bar
echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="POST" class="form-inline">
<div class="form-group">
	<input  type="text" name="search" placeholder="Search..." class="form-control" id="exampleInputName2">
	<input  type="submit" value=" Start search" class="btn btn-default">
	<input  type="hidden" name="submited" value="1" class="btn btn-default">
</div>
</form>';
if($_POST['submited'] == 1){
	$searched = data_validated($dbc, strtolower($_POST['search']));
	$searched = preg_replace("#[^0-9a-z+_ -]#i", '', $searched);
	$search_err = array();
	$output = '';
	
	if(strlen($searched) > 2){
		if(!count($search_err) > 0){
			$res = sql_corect($dbc, "SELECT category_id, name, description FROM category WHERE name LIKE '%$searched%' OR description LIKE '%$searched%'");
			$count = mysqli_num_rows($res);
				if(!$count == 0){
					echo "<div class='group_cat'><p class='text-success'>Results found!</p></div>";
					while($row = mysqli_fetch_array($res)){
						echo '<div class="group_cat"><p>'.$row['name'].'</p>
					  <div class="cat"><a href="topic.php?id='.$row['category_id'].'">'.$row['name'].'</a><p>'.$row['description'].'</p></div></div></br><hr/>';
					}
				}else{
					echo "<div class='group_cat'><p class='text-danger'>".$output = 'No result found.'."</p></div><hr/>";
				}
				mysqli_free_result($res);
			}
		}else{
			echo "<div class='group_cat'><p class='text-danger'>".$search_err ['too_short'] = 'Please enter a search query!'."</p></div><hr/>"; 
		}
	}
//end of search 
$res = sql_corect($dbc, "SELECT group_cat_id, name FROM  group_cat WHERE active = 1");

	while($row = mysqli_fetch_assoc($res)){
		$groups[]= $row;
	}
		foreach($groups as $v){
			$res = sql_corect($dbc, "SELECT category_id, name, description FROM category WHERE active = 1 AND group_cat_id =".data_validated($dbc, $v['group_cat_id']));
			echo '<div class="group_cat"><p>'.$v['name'].'</p>';
				while($row = mysqli_fetch_assoc($res)){
					echo '<div class="cat"><a href="topic.php?id='.$row['category_id'].'">'.$row['name'].'</a><p>'.$row['description'].'</p></div>';
				}
			echo '</div>';
			mysqli_free_result($res);
		}
	mysqli_close($dbc);
footer();


