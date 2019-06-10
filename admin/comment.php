<?php
session_start();
$title = 'comments';


// check the user have a session
if (isset ($_SESSION['username'])) {

  include 'init.php';

  $do = '';
  if (isset($_GET['do'])) {
    $do = $_GET['do'];
  }
  else {
    $do='manage';
  }




  if ($do=='manage') {


    $stmt = $con->prepare("SELECT comment.*,item.Name,users.UserName 
						   FROM comment,item,users
						   WHERE comment.itemID = item.ID
						   AND   comment.UserID = users.UserID");
    $stmt->execute();

    echo '
    <div class="container">
    <h1 class="manage">Mnage Comments<span class=" glyphicon glyphicon-cog"></span></h1>
    <table class="table table-bordered">
      <tr class="top">
        <th>#ID</th>
        <th>Comment</th>
        <th>Date</th>
        <th>User Name</th>
        <th>Item Name</th>
        <th>Data Control</th>
      </tr>
       ';

    while ($row= $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo $row['C_ID']; ?></td>
        <td><?php echo $row['C_Name']; ?></td>
        <td><?php echo $row['C_Date']; ?></td>
        <td><?php echo $row['UserName']; ?></td>
        <td><?php echo $row['Name']; ?></td>
        
        <td>
          <a href="comment.php?do=edit&id=<?php echo $row['C_ID']; ?>" class="btn btn-success">Edit <i class=" glyphicon glyphicon-edit" style="color: black;"></i>
          </a>  <!-- edit button -->
          <a href="comment.php?do=delete&id=<?php echo $row['C_ID']; ?>" class="btn btn-danger">Delete <i class=" glyphicon glyphicon-trash" style="color: white;"></i>
          </a> <!-- delete button -->

          <?php

          	if ($row['C_Status']==0) { ?>

          		<a href="comment.php?do=show&id=<?php echo $row['C_ID']; ?>" class="btn btn-primary">show <i class="glyphicon glyphicon-eye-close" style="color: white;"></i>
          		</a>
          <?php	}

          ?>

        </td> 

      </tr>

<?php } //end of while loop

echo'
  </table>
  </div>
  ';


  } // end of manage page



  elseif($do=='edit'){ 
  	$id = $_GET['id'];
  	$stmt = $con->prepare("SELECT * FROM comment WHERE C_ID=:id");
  	$stmt->execute(array(':id'=>$id));
  	$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>  	

	<div class="container">	
	<form class="form-horizontal" action="comment.php?do=update" method="post">
	  <h1>Edit Member<span class="glyphicon glyphicon-edit"></span> </h1>	
	  <div class="form-group">
	    <label for="exampleInputEmail1">Comment</label>
	    <input type="Hidden" name="id" value="<?php echo $row['C_ID']; ?>">
	    <textarea  class="form-control" rows="3" name="Cname"><?php echo $row['C_Name']; ?></textarea>	  
	    </div>
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>
	</div>

<?php  } // end of edit page


	elseif ($do=='update') {
			
		if ($_SERVER['REQUEST_METHOD']=='POST') {
			$id = $_POST['id'];
			$comment = $_POST['Cname'];
			$stmt = $con->prepare("UPDATE comment SET C_Name=:name WHERE C_ID=:id");
			$stmt->execute(array(':name'=>$comment,':id'=>$id));
			$themsg = "updated Successfully ";
        	getMessage($themsg,'back');

		}else{
			$themsg = "you cant access the update page direct you will be redirect to main page after... ";
          getMessage($themsg);
		}
	} // end of update page


	elseif ($do=='delete') {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$stmt = $con->prepare("DELETE FROM comment WHERE C_ID=:id");
			$stmt->execute(array(':id'=>$id));
			$themsg = "Deleted Successfully ";
        	getMessage($themsg,'back');
		}else{
			$themsg = "you cant access the update page direct you will be redirect to main page after... ";
            getMessage($themsg);
		}
	} // end of delete page

	elseif ($do=='show') {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$stmt = $con->prepare("UPDATE comment SET C_Status=1 WHERE C_ID=:id");
			$stmt->execute(array(':id'=>$id));
			$themsg = "Showed Successfully ";
        	getMessage($themsg,'back');
		}else{
			$themsg = "you cant access the update page direct you will be redirect to main page after... ";
            getMessage($themsg);
		}
	}













 include $templates_path.'footer.php';
}

else{

	header('Location:index.php');
}
?>