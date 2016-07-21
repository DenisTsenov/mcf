<?php session_start();
require('../functions.php');
my_adminheader('Sub Groups');
$dbc = db_connect();

if($_POST['ng'] == 1){
	
$name = data_validated($dbc, $_POST['group_name']);
$desc = data_validated($dbc, $_POST['desc']);
$cat_id = data_validated($dbc, (int)$_POST['group']);


	if(strlen($name) > 2 && strlen($desc) > 4 && $cat_id > 0){

	$id = data_validated($dbc, (int)$_POST['edit_id']);	
	
	$sql = sql_corect($dbc, 'SELECT category_id, group_cat_id, name, description, date_added FROM category WHERE name = "'.$name.'" AND category_id !='.$id);
	
		if(!mysqli_num_rows($sql) > 0){
			
				if($id > 0){
					
					sql_corect($dbc, 'UPDATE category SET name="'.$name.'", description="'.$desc.'", group_cat_id = '.$cat_id.' WHERE category_id='.$id);
					echo '<h2>Successuful Update!</h2>';
					
				}else{
					sql_corect($dbc, 'INSERT INTO category (name, description, date_added, 	group_cat_id) VALUES
					("'.$name.'", "'.$desc.'", '.time().', '.$cat_id.')');
					echo '<h1>Group is added!</h1>';
				}
				mysqli_free_result($sql);
			}else{
				echo '<h2>The name is taken</h2>';
			}
		}else{
			echo '<h2>Invalid Group or Description</h2>';
		}
		
	}
	
	$take_cat = sql_corect($dbc, 'SELECT gc.name as gcname, c.name, c.description, category_id FROM group_cat as gc, category as c WHERE gc.group_cat_id=c.group_cat_id ORDER BY gcname');
	
		echo '<div class="container">
				<div class="row">
				 <table class="table table-hover table table-bordered">
				 <thead>
					 <tr class="success">
						<div class="col-sm-4"><th>Group</th> </div>
						<div class="col-sm-4"><th>Name</th> </div>
						<div class="col-sm-4"><th>Description</th></div>
						<div class="col-sm-4"><th>Redact</th></div>
					</tr>
				</thead>';
	while($row = mysqli_fetch_assoc($take_cat)){
		echo $result =" <tbody><tr class='info'><div class='col-sm-4'><td>".$row['gcname'].'</td></div>
						<div class="col-sm-4"><td>'.$row['name'].'</td></div>
						<div class="col-sm-4"><td>'.$row['description'].'</td></div>
					<div class="col-sm-4"><td><a href="sub_groups.php?modde=eddit&id='.$row['category_id'].'">Redaction</a></td></div></tr>';
	}
	echo ' </tbody></table></div></div>';
 mysqli_free_result($take_cat);
	if(data_validated($dbc, $_GET['modde']) == 'eddit' && data_validated($dbc, $_GET['id']) > 0){
		$id = data_validated($dbc,(int)$_GET['id']);
		$res = sql_corect($dbc, 'SELECT name, description, group_cat_id, category_id FROM category WHERE category_id = '.$id);
		$edit_cat = mysqli_fetch_assoc($res);
		mysqli_free_result($res);
	}

$res = sql_corect($dbc, 'SELECT group_cat_id, name FROM group_cat');

mysqli_close($dbc);

echo  '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="POST"><br/>
Groups:<select name="group">';
   while($row = mysqli_fetch_assoc($res)){
	   if($row['group_cat_id'] == $edit_cat['group_cat_id']){
		   
			echo '<option value = "'.$row['group_cat_id'].'" selected="selected">'.$row['name'].'</option>';
		}else{
			
			echo '<option value = "'.$row['group_cat_id'].'" >'.$row['name'].'</option>';
		}
	}
echo '<select/><br/><br/>';

echo' <div class="form-group">
	Group name:<input type="text" name="group_name" value="'.$edit_cat['name'].'"></br><br/>
	<label for="comment">Description:</label>
	<textarea name="desc" class="form-control" rows="5" id="comment">'.$edit_cat['description'].'</textarea></br><br/>
	<input type="submit" class="btn btn-info" value="Create group">
	<input type="hidden" name="ng" value="1">
	</div>';
mysqli_free_result ($res);
if(data_validated($dbc, $_GET['modde']) == 'eddit'){
	echo '<input  type="hidden" name="edit_id" value="'.$_GET['id'].'">';
}

footer();

