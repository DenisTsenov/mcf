<?php  session_start(); 
require('../functions.php'); // sql_corect() is  used instead mysqli_query() because of utf8 encoding
my_adminheader('Forum  groups');
$dbc = db_connect();		
if($_POST['ng'] == 1){
	
$name = data_validated($dbc, $_POST['group_name']);
$desc = data_validated($dbc, $_POST['desc']);

	if(strlen($name) > 2 && strlen($desc) > 4){

	$id = data_validated($dbc, (int)$_POST['edit_id']);	
	
	$sql = sql_corect($dbc, 'SELECT name, description, date_added FROM group_cat WHERE name = "'.$name.'" AND group_cat_id !='.$id);
	
		if(!mysqli_num_rows($sql) > 0){
			
				if($id > 0){
					
					sql_corect($dbc, 'UPDATE group_cat SET name="'.$name.'", description="'.$desc.'" WHERE group_cat_id='.$id);
					echo '<h2>Successuful Update!</h2>';
					
				}else{
					sql_corect($dbc, 'INSERT INTO group_cat (name, date_added, description) VALUES
					("'.$name.'", '.time().', "'.$desc.'")');
					echo '<h1>Group is added!</h1>';
				}
			}else{
				echo '<h2>The name is taken</h2>';
			}
			mysqli_free_result($sql);
		}else{
			echo '<h2>Invalid Group or Description</h2>';
		}
	}
	
	$take_cat = sql_corect($dbc, 'SELECT name, description, group_cat_id FROM group_cat');
		echo '<div class="container">
				 <table class="table table-hover table table-bordered">
				 <thead>
				 <tr class="success">
					<div class="col-sm-4"><th>Name</th> </div>
					<div class="col-sm-4"><th>Description</th></div>
					<div class="col-sm-4"><th>Redact</th></div>
				</tr>';
	while($row = mysqli_fetch_assoc($take_cat)){
		echo $result =  "<tbody><div class='col-sm-4'><tr class='info'><td>".$row['name'].'</td><div/>
			<div class="col-sm-4"><td>'.$row['description'].'</td></div>
			<div class="col-sm-4"><td><a href="groups.php?modde=eddit&id='.$row['group_cat_id'].'">Redaction</a></td></div></tr>';
	}
	echo '</tbody></table></div>';
	mysqli_free_result($take_cat);
		if(data_validated($dbc, $_GET['modde']) == 'eddit' && data_validated($dbc, $_GET['id']) > 0){
			$id = data_validated($dbc, (int)$_GET['id']);
			$res = sql_corect($dbc, 'SELECT name, description FROM group_cat WHERE group_cat_id='.$id);
			$edit_cat = mysqli_fetch_assoc($res);
		}
	

echo  '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="POST"><br/>
<div class="form-group">
	<label for="name">Group  name:</label>
	<input type="text" id="name" name="group_name" value="'.$edit_cat['name'].'"></br><br/>
	<label for="comment">Description:</label>
	<br/><textarea name="desc" class="form-control" rows="5" id="comment">'.$edit_cat['description'].'</textarea></br>
	<input type="submit" class="btn btn-info" value="Create">
	<input type="hidden" name="ng" value="1">
	<div>';

if(data_validated($dbc, $_GET['modde']) == 'eddit'){
	echo '<input  type="hidden" name="edit_id" value="'.$_GET['id'].'">';
}
mysqli_close($dbc);
echo "</form>";
footer();




