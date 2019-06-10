<?php
session_start();
$title = 'member';


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








  //manage page
  if ($do=='manage') {

    $query = '';
    if(isset($_GET['page']) && $_GET['page']=='pending') {
      $query = 'AND RegStatus = 0'; // to show the pending member in ta
    }


    $stmt = $con->prepare("SELECT * FROM users WHERE GroupID!=1 $query");
    $stmt->execute();

    echo '
    <div class="container">
    <h1 class="manage">Mnage Members<span class=" glyphicon glyphicon-cog"></span></h1>
    <table class="table table-bordered">
      <tr class="top">
        <th>#ID</th>
        <th>User Name</th>
        <th>Email</th>
        <th>Full Name</th>
        <th>Regression Date</th>
        <th>Data Control</th>
      </tr>
       ';

    while ($row= $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
      <tr>
        <td><?php echo $row['UserID']; ?></td>
        <td><?php echo $row['UserName']; ?></td>
        <td><?php echo $row['Email']; ?></td>
        <td><?php echo $row['FullName']; ?></td>
        <td><?php echo $row['Date']; ?></td>
        <td>
          <a href="member.php?do=edit&id=<?php echo $row['UserID']; ?>" class="btn btn-success">Edit <i class=" glyphicon glyphicon-edit" style="color: black;"></i>
          </a>  <!-- edit button -->
          <a href="member.php?do=delete&id=<?php echo $row['UserID']; ?>" class="btn btn-danger">Delete <i class=" glyphicon glyphicon-trash" style="color: white;"></i>
          </a> <!-- delete button -->
          <?php
            if($row['RegStatus']==0){?>
              <a href="member.php?do=activate&id=<?php echo $row['UserID']; ?>" class="btn btn-primary">Activate <i class=" glyphicon glyphicon-plus-sign" style="color: white;"></i>
           <?php }
          ?>
        </td> 

      </tr>

<?php } //end of while loop

echo'
  </table>
  <a href="member.php?do=add" class="Add btn btn-primary btn-lg">Add New Member <i class="glyphicon glyphicon-plus-sign"></i></a>
  </div>
  ';

  }//end of manage page
  

  elseif ($do=='delete') {
    
    if (isset($_GET['id'])) {
      $userid = $_GET['id'];
      $stmt = $con->prepare("DELETE FROM users WHERE UserID=:userid");
      $stmt->execute(array(':userid'=>$userid)); 
     
      $themsg = "Deleted Successfully ";
      getMessage($themsg,'back');

    }else{
      
      $themsg = "you cant access the delete page direct...  you will be redirect to main page after ";
      getMessage($themsg);

    }    
  }   //end of delete page


  elseif($do=='activate'){

    if (isset($_GET['id'])) {
      $userid = $_GET['id'];

      $stmt = $con->prepare("UPDATE users SET RegStatus=1 WHERE UserID=:userid");
      $stmt->execute(array(':userid'=>$userid));

      $themsg = "Activated Successfully...you will be redirect to page after ";
      getMessage($themsg,'back');

    }else{
      
      $themsg = "you cant access the Activate page direct...  you will be redirect to main page after ";
      getMessage($themsg);

    }


  }



    // edit page
  elseif ($do=='edit') { 

    if (isset($_GET['id'])) {

      $userid = $_GET['id'];
      $stmt = $con->prepare("SELECT * FROM users WHERE UserID=:userid");
      $stmt->execute(array(':userid'=>$userid));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $count = $stmt->rowCount();
      if ($count>0) { ?>
    <div class="container">    
    <form class="form-horizontal" action="member.php?do=update" method="post">

      <input type="hidden" name="userid" value="<?php echo $userid; ?>">

      <h1>Edit Member<span class="glyphicon glyphicon-edit"></span> </h1>
    <div class="form-group">
      <label class="col-sm-2 control-label">UserName</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="username" value="<?php echo $row['UserName']; ?>" required  ><i class='glyphicon glyphicon-asterisk'></i>
      </div>
    </div>
    <div class="form-group">
      <label  class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>" >
        <input type="text" class="form-control" name="newpassword" >
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="email" value="<?php echo $row['Email'];?>" required><i class='glyphicon glyphicon-asterisk'></i>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">FullName</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="fullname" value="<?php echo $row['FullName'];?>" required ><i class='glyphicon glyphicon-asterisk'></i>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="submit" class="btn btn-default">Edit Member</button>
      </div>
    </div>
  </form>
   </div>
<?php
      }}
      else{
        $themsg = "there is no such id.... you cant access the edit page direct you will be redirect to main page after ";
        getMessage($themsg);
      }
      } //end of edit page  




   // update page   
  elseif ($do=='update') { 

    if ($_SERVER['REQUEST_METHOD']=='POST') {

      $userid   = $_POST['userid'];
      $username = $_POST['username'];
      $email    = $_POST['email'];
      $fullname = $_POST['fullname'];
      if (empty($_POST['newpassword'])) {
        $password = $_POST['oldpassword'];
      }else{
        $password = sha1($_POST['newpassword']);
      }
      
      $stmt1 = $con->prepare("SELECT * FROM users WHERE UserName=:username AND UserID!=:userid");
      $stmt1->execute(array(':username'=>$username,':userid'=>$userid));
      $count = $stmt1->rowCount();
      if ($count==1) {
        $themsg = "the username is exist... ";
        getMessage($themsg,'back');
      }else{

      
        $stmt = $con->prepare("UPDATE users SET UserName=:username , Password=:password , Email=:email , FullName=:fullname WHERE UserID=:userid");
        $stmt->execute(array(':username'=>$username,':password'=>$password,':email'=>$email,':fullname'=>$fullname,':userid'=>$userid));

        $themsg = "updated Successfully ";
        getMessage($themsg,'back');
      } }
    else{
          $themsg = "you cant access the update page direct you will be redirect to main page after... ";
          getMessage($themsg);
        }
}    //end of update page





  //Add page
  elseif($do=='add'){ ?>

  <div class="container">
    <form class="form-horizontal" action="member.php?do=insert" method="post">
      <h1>Add New Member<span class=" glyphicon glyphicon-plus-sign"></span> </h1>
    <div class="form-group">
      <label class="col-sm-2 control-label">UserName</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="username" placeholder="User Name Used In Login" required><i class='glyphicon glyphicon-asterisk'></i>
      </div>
    </div>
    <div class="form-group">
      <label  class="col-sm-2 control-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="password" placeholder="Password Must Be Hard&Complex" required ><i class='glyphicon glyphicon-asterisk'></i>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="email" placeholder="Email Must Be Valid" required><i class='glyphicon glyphicon-asterisk'></i>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label">FullName</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="fullname" placeholder="Full Name Used In Profile Name " required ><i class='glyphicon glyphicon-asterisk'></i>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="submit" class="btn btn-default">Add Member</button>
      </div>
    </div>
  </form>
  </div>
  <?php
  }//end of add page

  
  //insert page
  elseif ($do=='insert') {
    if ($_SERVER['REQUEST_METHOD']=='POST') {
      
      $username = $_POST['username'];
      $password = sha1($_POST['password']);
      $email    = $_POST['email'];
      $fullname = $_POST['fullname'];

      $check = check('UserName','users',$username);
      if ($check==1) {
        $themsg = "<h3 style='color: black; text-align: center;'>change the username you will be redirect to the page after... </h3>";
      getMessage($themsg,'back');  

        
      }else{


        $stmt = $con->prepare("INSERT INTO users(UserName,Password,Email,FullName,RegStatus,Date) VALUES (:username,:password,:email,:fullname,1,NOW()) ");
        $stmt->execute(array(':username'=>$username,
                             ':password'=>$password,
                             ':email'   =>$email,
                             ':fullname'=>$fullname ));
        
        $themsg = "Inserted Successfully ";
        getMessage($themsg,'back');
    }
    }else{
          $themsg = "you cant access the insert page direct you will be redirect to main page after... ";
          getMessage($themsg);
        }

  } // end of insert page





include $templates_path.'footer.php';

}  // if of seesion ==>username
else {
  header('Location:index.php');
}
?>