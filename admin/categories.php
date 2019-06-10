<?php
ob_start();
session_start();
$title = 'Categories';

if (isset($_SESSION['username'])){

	include 'init.php';
	$do = '';
	if (isset($_GET['do'])) {
		$do = $_GET['do'];
	}else{
		$do = 'manage';
	}


	//start manage page
	if ($do=='manage') {
		$sort = '';
		$sorted = array('ASC','DESC');
		if (isset($_GET['sort'])&&in_array($_GET['sort'],$sorted)) {
			$sort = $_GET['sort'];
		}

		$stmt = $con->prepare("SELECT * FROM categorie ORDER BY Ordering $sort");
    	$stmt->execute();

	    echo '

	    <div class="container">

	    <h1 class="manage">Manage Categories<span class=" glyphicon glyphicon-cog"></span></h1>

	    <div class="btn-group">
	    	<label>Arrange:</label>
  			<span class="label label-info"><a href="categories.php?sort=ASC">ASC</a></span>
  			<span class="label label-info"><a href="categories.php?sort=DESC">DESC</a> </span>
		</div>

	    <table class="table table-bordered">
	      <tr class="top">
	        <th>#ID</th>
	        <th>Name</th>
	        <th>Description</th>
	        <th>Visibility</th>
	        <th>comment</th>
	        <th>ads</th>
	        <th>Control</th>
	      </tr>
	       ';

    while ($row= $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo $row['ID']; ?></td>
        <td><?php echo $row['Name']; ?></td>
        
        <td>
        	<?php if($row['Description']==''){echo "No Description";}else{
         echo $row['Description'];} ?>
        </td>
        <td>
        	<?php if($row['Visibility']==1) {
        		echo '<span class="label label-danger">Hidden</span>';
        	}else{ 
        	 echo '<span class="label label-info">Visible</span>';} ?>		
        </td>
        <td>
        	<?php if($row['Allow_comment']==1) {
        		echo '<span class="label label-danger">Comment Disabled</span>';
        	}else{ 
        	 echo '<span class="label label-info">Comment Allowed</span>';} ?>		
        </td>
        <td>
        	<?php if($row['Allow_ads']==1) {
        		echo '<span class="label label-danger">ads Disabled</span>';
        	}else{ 
        	 echo '<span class="label label-info">ads Allowed</span>';} ?>		
        </td>
      
        <td>
          <a href="categories.php?do=edit&id=<?php echo $row['ID']; ?>" class="btn btn-success">Edit <i class=" glyphicon glyphicon-edit" style="color: black;"></i>
          </a>  <!-- edit button -->
          <a href="categories.php?do=delete&id=<?php echo $row['ID']; ?>" class="btn btn-danger">Delete <i class=" glyphicon glyphicon-trash" style="color: white;"></i>
          </a> <!-- delete button -->
        </td>
      </tr>    
	<?php
	} echo'
  </table>
  <a href="categories.php?do=add" class="Add btn btn-primary btn-lg">Add New Category <i class="glyphicon glyphicon-plus-sign"></i></a>
  ';
} //end manage page


	// start delete page 
	elseif ($do=='delete') {

		if (isset($_GET['id'])) {
			
			$id = $_GET['id'];
			$stmt = $con->prepare("DELETE FROM categorie WHERE ID=:id");
			$stmt->execute(array(':id'=>$id));

			$themsg = "Deleted Successfully ";
        	getMessage($themsg,'back');

		}else{
			$themsg = "there is no such id.... you cant access the edit page direct you will be redirect to main page after ";
        	getMessage($themsg);
		}

	}//end delete page



	//start of edit page
	elseif ($do=='edit') {

		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$stmt = $con->prepare("SELECT * FROM categorie WHERE ID=:id");
			$stmt->execute(array(':id'=>$id));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			if ($count>0) {?>


  <div class="container">
    <form class="form-horizontal" action="Categories.php?do=update" method="post">
      <h1>Add New Category<span class=" glyphicon glyphicon-plus-sign"></span> </h1>
      <input type="Hidden" name="id" value="<?php echo $row['ID'] ?>">
      <!-- visibility -->
      <div class="form-group">
    	<label class="col-sm-2 control-label">Visibility</label>
    	<label class="radio-inline">
  		<input type="radio" name="visible" id="vis-yes" value="0" <?php if ($row['Visibility']==0) { echo 'checked'; } ?> > Yes
		</label>
		<label class="radio-inline">
  		<input type="radio" name="visible" id="vis-yes" value="1" <?php if ($row['Visibility']==1) { echo 'checked'; } ?>> No
		</label>
    </div>
    <!--comment-->
    <div class="form-group">
    	<label class="col-sm-2 control-label">Allow-comment</label>
    	<label class="radio-inline">
  		<input type="radio" name="comment" id="com-yes" value="0" <?php if ($row['Allow_comment']==0) { echo 'checked'; } ?>> Yes
		</label>
		<label class="radio-inline">
  		<input type="radio" name="comment" id="com-no" value="1" <?php if ($row['Allow_comment']==1) { echo 'checked'; } ?>> No
		</label>
    </div>
    <!--ads-->
    <div class="form-group">
    	<label class="col-sm-2 control-label">Allow-ads</label>
    	<label class="radio-inline">
  		<input type="radio" name="ads" id="ads-yes" value="0" <?php if ($row['Allow_ads']==0) { echo 'checked'; } ?>> Yes
		</label>
		<label class="radio-inline">
  		<input type="radio" name="ads" id="ads-no" value="1" <?php if ($row['Allow_ads']==1) { echo 'checked'; } ?>> No
		</label>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" value="<?php echo $row['Name']; ?>" required><i class='glyphicon glyphicon-asterisk'></i>
      </div>
    </div>
    <div class="form-group">
      <label  class="col-sm-2 control-label">Description</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="description" value="<?php echo $row['Description']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Ordering</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="Ordering" value="<?php echo $row['Ordering']; ?>">
      </div>
    </div>
   
    
	
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="submit" class="btn btn-default">Update Category</button>
      </div>
    </div> 
	
  </form>
  </div>


			 ?>
		
		<?php
	}}else{
       		$themsg = "there is no such id.... you cant access the edit page direct you will be redirect to main page after ";
        	getMessage($themsg);
 	    }

	}//end of edit page



	//start of update page
	elseif ($do=='update') { 

		if ($_SERVER['REQUEST_METHOD']=='POST') {

			$id 		 = $_POST['id'];
			$visible 	 = $_POST['visible'];
			$comment 	 = $_POST['comment'];
			$ads 		 = $_POST['ads'];
			$name        = $_POST['name'];
			$description = $_POST['description'];
			$Ordering    = $_POST['Ordering'];

			$stmt = $con->prepare("UPDATE categorie SET Name=:name,      	Description=:description,Ordering=:Ordering,Visibility=:visible,Allow_comment=:comment,Allow_ads=:ads WHERE ID=:id");
			$stmt->execute(array(':name'=>$name,':description'=>$description,':Ordering'=>$Ordering,':visible'=>$visible,':comment'=>$comment,':ads'=>$ads,':id'=>$id));
			$themsg = "updated Successfully ";
        	getMessage($themsg,'back');

		}else{
			$themsg = "there is no such id.... you cant access the edit page direct you will be redirect to main page after ";
        	getMessage($themsg);

		}


		} // end of update page


	//start add page
	elseif ($do=='add') { 
		?>


  <div class="container">
    <form class="form-horizontal" action="Categories.php?do=insert" method="post">
      <h1>Add New Category<span class=" glyphicon glyphicon-plus-sign"></span> </h1>
      <!-- visibility -->
      <div class="form-group">
    	<label class="col-sm-2 control-label">Visibility</label>
    	<label class="radio-inline">
  		<input type="radio" name="visible" id="vis-yes" value="0" checked> Yes
		</label>
		<label class="radio-inline">
  		<input type="radio" name="visible" id="vis-yes" value="1"> No
		</label>
    </div>
    <!--comment-->
    <div class="form-group">
    	<label class="col-sm-2 control-label">Allow-comment</label>
    	<label class="radio-inline">
  		<input type="radio" name="comment" id="com-yes" value="0" checked> Yes
		</label>
		<label class="radio-inline">
  		<input type="radio" name="comment" id="com-no" value="1"> No
		</label>
    </div>
    <!--ads-->
    <div class="form-group">
    	<label class="col-sm-2 control-label">Allow-ads</label>
    	<label class="radio-inline">
  		<input type="radio" name="ads" id="ads-yes" value="0" checked> Yes
		</label>
		<label class="radio-inline">
  		<input type="radio" name="ads" id="ads-no" value="1"> No
		</label>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" placeholder="Name Of Product" required><i class='glyphicon glyphicon-asterisk'></i>
      </div>
    </div>
    <div class="form-group">
      <label  class="col-sm-2 control-label">Description</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="description" placeholder="Description of Product">
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Ordering</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="Ordering" placeholder="Number to Arrange the Categories">
      </div>
    </div>
   
    
	
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="submit" class="btn btn-default">Add Category</button>
      </div>
    </div> 
	
  </form>
  </div>


	<?php } // end add page



	elseif ($do=='insert') { // start insert page

	  if ($_SERVER['REQUEST_METHOD']=='POST') {
      
	      $name 	   = $_POST['name'];
	      $description = $_POST['description'];
	      $Ordering    = $_POST['Ordering'];
	      $visible 	   = $_POST['visible'];
	      $comment     = $_POST['comment'];
	      $ads         = $_POST['ads'];

	      $check = check('Name','categorie',$name);
	      if ($check==1) {
	        $themsg = "<h3 style='color: black; text-align: center;'>change the name of product you will be redirect to the page after... </h3>";
	      getMessage($themsg,'back');  

	      }else{
	      	$stmt = $con->prepare("INSERT INTO categorie(Name,Description,Ordering,Visibility,Allow_comment,Allow_ads )VALUES(:name,:description,:order,:visible,:comment,:ads)"); 
	      	$stmt->execute(array(':name'=>$name,
	      						 ':description'=>$description,
	      						 ':order'=>$Ordering,
	      						 ':visible'=>$visible,
	      						 ':comment'=>$comment,
	      						 ':ads'=>$ads));

	        
	        $themsg = "Inserted Successfully ";
	        getMessage($themsg,'back');
    }
    }else{
          $themsg = "you cant access the insert page direct you will be redirect to main page after... ";
          getMessage($themsg);
        }

	} // end insert page




	include $templates_path.'footer.php';

}



ob_end_flush();

?>