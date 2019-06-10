<?php
session_start();

$title = 'items';

if (isset($_SESSION['username'])) {
	
	include 'init.php';

	$do = '';
	if (isset($_GET['do'])) {
		$do = $_GET['do'];
	}else{
		$do = 'manage';
	}


	if ($do=='manage') {

    $stmt = $con->prepare("SELECT  item.*,categorie.Name AS Category_Name,users.UserName
						  FROM item,users,categorie
						  WHERE item.User_ID = users.UserID
						  AND   item.Cat_ID  = categorie.ID	");
    $stmt->execute();

    echo '
    <div class="container">
    <h1 class="manage">Mnage Items<span class=" glyphicon glyphicon-cog"></span></h1>
    <table class="table table-bordered">
      <tr class="top">
        <th>#ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Adding Date</th>
        <th>Category Name</th>
        <th>User Name</th>
        <th>Data Control</th>
      </tr>
       ';

    while ($row= $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo $row['ID']; ?></td>
        <td><?php echo $row['Name']; ?></td>
        <td><?php echo $row['Description']; ?></td>
        <td><?php echo $row['Price']; ?></td>
        <td><?php echo $row['Date']; ?></td>
        <td><?php echo $row['Category_Name']; ?></td>
        <td><?php echo $row['UserName'] ?></td>  
        <td>
          <a href="items.php?do=edit&id=<?php echo $row['ID']; ?>" class="btn btn-success btn-sm">Edit <i class=" glyphicon glyphicon-edit" style="color: black;"></i>
          </a>  <!-- edit button -->

          <a href="items.php?do=delete&id=<?php echo $row['ID']; ?>" class="btn btn-danger btn-sm">Delete <i class=" glyphicon glyphicon-trash" style="color: white;"></i>
          </a> <!-- delete button -->

          <a href="items.php?do=comment&id=<?php echo $row['ID']; ?>" class="btn btn-info btn-sm">Comments <i class=" glyphicon glyphicon-envelope" style="color: white;"></i>
          </a> <!-- comment button -->

          <?php if($row['Approve']==0){ ?>
	
			<a href="items.php?do=Approve&id=<?php echo $row['ID']; ?>" class="btn btn-primary btn-sm">Approve <i class=" glyphicon glyphicon-check" style="color: white;"></i>
          	</a> <!--approve button-->          

          <?php } ?>
        </td> 

      </tr>

<?php } //end of while loop

echo'
  </table>
  <a href="items.php?do=add" class="Add btn btn-primary btn-lg">Add New Item <i class="glyphicon glyphicon-plus-sign"></i></a>
  </div>
  ';

	} // end of manage page


	elseif ($do=='comment') {
		if (isset($_GET['id'])) {

			$id = $_GET['id'];

			$stmt = $con->prepare("SELECT comment.C_Name,comment.C_ID,users.UserName,comment.C_Date
				FROM comment,users,item 
				WHERE comment.UserID = users.UserID 
				AND comment.itemID = item.ID
				AND item.ID=:id");

			$stmt->execute(array(':id'=>$id));

		    echo '
		    <div class="container">
		    <h1 class="manage">Mnage Comment<span class=" glyphicon glyphicon-cog"></span></h1>
		    <table class="table table-bordered">
		      <tr class="top">
		        <th>Comment</th>
		        <th>User Name</th>
		        <th>Added Date</th>
		        <th>Data Control</th>
		      </tr>
		       ';
		      		    
		      while ($row= $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
		      <tr>
		        <td><?php echo $row['C_Name']; ?></td>
		        <td><?php echo $row['UserName']; ?></td>
		        <td><?php echo $row['C_Date']; ?></td>
		        <td>
		        	<a href="comment.php?do=edit&id=<?php echo $row['C_ID']; ?>" class="btn btn-success">Edit <i class=" glyphicon glyphicon-edit" style="color: black;"></i>
          			</a>  <!-- edit button -->

		        	<a href="comment.php?do=delete&id=<?php echo $row['C_ID']; ?>" class="btn btn-danger">Delete <i class=" glyphicon glyphicon-trash" style="color: white;"></i>
          			</a> <!-- delete button -->
      		    </td>
		      </tr>

		<?php 

		}
	}}





	elseif ($do=='delete') {

		if (isset($_GET['id'])) {
			$id = $_GET['id'];	
			$stmt = $con->prepare("DELETE FROM item WHERE ID=:id");
			$stmt->execute(array(':id'=>$id));

			$themsg = "Deleted Successfully ";
            getMessage($themsg,'back');

		}else{
			$themsg = "there is no such id.... you cant access the edit page direct you will be redirect to main page after ";
        getMessage($themsg);
		}
	} // end of delete page


	elseif ($do=='edit') {

		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$stmt = $con->prepare("SELECT * FROM item WHERE ID=:id");
			$stmt->execute(array(':id'=>$id));
			$row = $stmt->fetch(PDO::FETCH_ASSOC); 
			$count = $stmt->rowCount();
			if ($count>0) {
			?>

			<div class="container">
		    <form class="form-horizontal" action="items.php?do=update" method="post">
		      <h1>Update Item<span class=" glyphicon glyphicon-plus-sign"></span> </h1>
		    <input type="Hidden" name="item_id" value="<?php echo $row['ID']; ?>"> 
		    <div class="form-group">
		      <label class="col-sm-2 control-label">Name</label>
		      <div class="col-sm-10">
		        <input type="text" class="form-control" name="name" value="<?php echo $row['Name']; ?>" required><i class='glyphicon glyphicon-asterisk'></i>
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="col-sm-2 control-label">Description</label>
		      <div class="col-sm-10">
		        <input type="text" class="form-control" name="description" value="<?php echo $row['Description']; ?>" required><i class='glyphicon glyphicon-asterisk'></i>
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="col-sm-2 control-label">Price</label>
		      <div class="col-sm-10">
		        <input type="text" class="form-control" name="price" value="<?php echo $row['Price']; ?>" required><i class='glyphicon glyphicon-asterisk'></i>
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="col-sm-2 control-label">Country</label>
		      <div class="col-sm-10">
		        <input type="text" class="form-control" name="country" value="<?php echo $row['Country']; ?>" required><i class='glyphicon glyphicon-asterisk'></i>
		      </div>
		    </div>
		    <div class="form-group">
		    	<label class="col-sm-2 control-label">Status</label>
		    	<select class="col-sm-10 style" style="width: 75%;position: relative;left: 25px;top: 7px;" name="status">
	  				<option value="0">....</option>
					<option value="1" <?php if($row['Status']==1)echo "selected"; ?>>New</option>
					<option value="2" <?php if($row['Status']==2)echo "selected"; ?>>Like New</option>
					<option value="3" <?php if($row['Status']==3)echo "selected"; ?>>Old</option>
				</select>
		    </div>
		    <div class="form-group">
		    	<label class="col-sm-2 control-label">UserName</label>
		    	<select class="col-sm-10 style" style="width: 75%;position: relative;left: 25px;top: 7px;" name="user">
	  				<option value="0">....</option>
					<?php 

					$stmt = $con->prepare("SELECT * FROM users");
					$stmt->execute();
					while ($user = $stmt->fetch(PDO::FETCH_ASSOC)){?>

						<option value="<?php echo $user['UserID'] ?>"
						<?php if ($user['UserID']==$row['User_ID']) {
							echo "selected"; } 
						?>>
						<?php echo $user['UserName']; ?></option>
						
					<?php }

					?>
				</select>
		    </div>
		    <div class="form-group">
		    	<label class="col-sm-2 control-label">Category</label>
		    	<select class="col-sm-10 style" style="width: 75%;position: relative;left: 25px;top: 7px;" name="Category">
	  				<option value="0">....</option>
					<?php 

					$stmt = $con->prepare("SELECT * FROM categorie");
					$stmt->execute();
					while ($cat = $stmt->fetch(PDO::FETCH_ASSOC)){?>

						<option value="<?php echo $cat['ID'] ?>" 
						<?php if ($cat['ID']==$row['Cat_ID']) {
							echo "selected";
						}

						?>><?php echo $cat['Name']; ?></option>
						
					<?php }

					?>
				</select>
		    </div>
		    
		    <div class="form-group">
		      <div class="col-sm-offset-2 col-sm-10">
		        <button type="submit" name="submit" class="btn btn-default btn-lg">Add Item</button>
		      </div>
    		</div>
		  </form>
  		</div>

		<?php	}}

	} // end of edit page

	elseif($do=='update'){

		if ($_SERVER['REQUEST_METHOD']=='POST') {
			
			$item_id = $_POST['item_id'];
			$name = $_POST['name'];
			$description = $_POST['description'];
			$price = $_POST['price'];
			$country = $_POST['country'];
			$status = $_POST['status'];
			$user = $_POST['user'];
			$Category = $_POST['Category'];

			$stmt = $con->prepare("UPDATE item SET Name=:name,Description=:description,Price=:price,Country=:country,Status=:status,User_ID=:user_id,Cat_ID=:cat_ID WHERE ID=:item_id");
			$stmt->execute(array(':name'=>$name,
								 ':description'=>$description,
								 ':price'=>$price,
								 ':country'=>$country,
								 ':status'=>$status,
								 ':user_id'=>$user,
								 ':cat_ID'=>$Category,
								 ':item_id'=>$item_id));
			$themsg = "updated Successfully ";
            getMessage($themsg,'back');

			}else{
			$themsg = "there is no such id.... you cant access the edit page direct you will be redirect to main page after ";
        getMessage($themsg);
		}
		} // end of update page


	elseif($do=='add'){ ?>

		<div class="container">
		    <form class="form-horizontal" action="items.php?do=insert" method="post">
		      <h1>Add New Item<span class=" glyphicon glyphicon-plus-sign"></span> </h1>
		    <div class="form-group">
		      <label class="col-sm-2 control-label">Name</label>
		      <div class="col-sm-10">
		        <input type="text" class="form-control" name="name" placeholder="Name Of The Product" required><i class='glyphicon glyphicon-asterisk'></i>
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="col-sm-2 control-label">Description</label>
		      <div class="col-sm-10">
		        <input type="text" class="form-control" name="description" placeholder="descripe your Product" required><i class='glyphicon glyphicon-asterisk'></i>
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="col-sm-2 control-label">Price</label>
		      <div class="col-sm-10">
		        <input type="text" class="form-control" name="price" placeholder="Set The Price" required><i class='glyphicon glyphicon-asterisk'></i>
		      </div>
		    </div>
		    <div class="form-group">
		      <label class="col-sm-2 control-label">Country</label>
		      <div class="col-sm-10">
		        <input type="text" class="form-control" name="country" placeholder="Enter The Country Made" required><i class='glyphicon glyphicon-asterisk'></i>
		      </div>
		    </div>
		    <div class="form-group">
		    	<label class="col-sm-2 control-label">Status</label>
		    	<select class="col-sm-10 style" style="width: 75%;position: relative;left: 25px;top: 7px;" name="status">
	  				<option value="0">....</option>
					<option value="1">New</option>
					<option value="2">Like New</option>
					<option value="3">Old</option>
				</select>
		    </div>
		    <div class="form-group">
		    	<label class="col-sm-2 control-label">UserName</label>
		    	<select class="col-sm-10 style" style="width: 75%;position: relative;left: 25px;top: 7px;" name="user">
	  				<option value="0">....</option>
					<?php 

					$stmt = $con->prepare("SELECT * FROM users");
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){?>

						<option value="<?php echo $row['UserID'] ?>"><?php echo $row['UserName']; ?></option>
						
					<?php }

					?>
				</select>
		    </div>
		    <div class="form-group">
		    	<label class="col-sm-2 control-label">Category</label>
		    	<select class="col-sm-10 style" style="width: 75%;position: relative;left: 25px;top: 7px;" name="Category">
	  				<option value="0">....</option>
					<?php 

					$stmt = $con->prepare("SELECT * FROM categorie");
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){?>

						<option value="<?php echo $row['ID'] ?>"><?php echo $row['Name']; ?></option>
						
					<?php }

					?>
				</select>
		    </div>
		    
		    <div class="form-group">
		      <div class="col-sm-offset-2 col-sm-10">
		        <button type="submit" name="submit" class="btn btn-default btn-lg">Add Item</button>
		      </div>
    		</div>
		  </form>
  		</div>
	<?php } // end of add page

	elseif($do=='insert'){

		if ($_SERVER['REQUEST_METHOD']=='POST') {

			$name 		 = $_POST['name'];
			$description = $_POST['description'];
			$price 		 = $_POST['price'];
			$country 	 = $_POST['country'];
			$status  	 = $_POST['status'];
			$user 		 = $_POST['user'];
			$categorie   = $_POST['Category'];


			$stmt = $con->prepare("INSERT INTO item(Name,Description,	Price,Country,Status,Cat_ID,User_ID,Date) Values(:name,:description,:price,:country,:status,:cat_id,:user_id,NOW())");

			$stmt->execute(array(':name'=>$name,
								 ':description'=>$description,
								 ':price'=>$price,
								 ':country'=>$country,
								 ':status'=>$status,
								 ':cat_id'=>$categorie,
								 ':user_id'=>$user));

			$themsg = "Inserted Successfully ";
	        getMessage($themsg,'back');

		}else{

			$themsg = "you cant access the insert page direct you will be redirect to main page after... ";
          getMessage($themsg);
		}
	} // end of insert page


	elseif($do=='Approve'){
		if (isset($_GET['id'])) {
			
			$id = $_GET['id'];
			$stmt = $con->prepare("UPDATE item SET Approve=1 WHERE ID=:id");
			$stmt->execute(array(':id'=>$id));
			$themsg = "Approved Successfully ";
	        getMessage($themsg,'back');


		}else{
			$themsg = "you cant access the Approve page direct you will be redirect to main page after... ";
          getMessage($themsg);
      }


	} // end of approve page




	
}else{
	$themsg = "you cant access the Item page direct you will be redirect to main page after... ";
    getMessage($themsg);
}


?>