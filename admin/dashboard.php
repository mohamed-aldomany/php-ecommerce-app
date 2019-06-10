<?php
ob_start();
session_start();
if (isset($_SESSION['username'])) {
$title='Dashboard';

include 'init.php';

//start dashboard page
?>

<div class="container">
    <h1 class="title">DashBoard <span class="glyphicon glyphicon-home"></span></h1>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <div class="thumbnail">
            <h1>Total Members</h1>
            <span><a href="member.php"><?php echo countItem('UserID','users'); ?></a></span>
        </div>
      </div>

      <div class="col-xs-6 col-md-3">
        <div class="thumbnail">
            <h1>  Pending Members</h1>
            <span><a href="member.php?do=manage&page=pending"><?php echo check('RegStatus','users',0) ?></a></span>
        </div>
      </div>

      <div class="col-xs-6 col-md-3">
        <div class="thumbnail">
            <h1>Total Items</h1>
            <span><a href="items.php"><?php echo countItem('ID','item'); ?></a></span>
        </div>
      </div>

      <div class="col-xs-6 col-md-3">
        <div class="thumbnail">
            <h1>Total Comments</h1>
            <span><a href="comment.php"><?php echo countItem('C_ID','comment'); ?></a></span>
        </div>
        </div>

      <div class="col-xs-6">
          <div class="panel panel-default latest">
          <div class="panel-body">
              <span class="glyphicon glyphicon-user"></span>     Latest 3 Register User
          </div>
        <div class="panel-footer">
            <?php

                 $row = latest('UserName','users','UserID',3);
                 foreach ($row as $rows) {
                     echo "<div class='item'>"
                             ."<span class='glyphicon glyphicon-hand-right'></span>"." ".$rows['UserName'].
                          "</div>"."<br>";}
             ?>
        </div>
        </div>
      </div>

      <div class="col-xs-6">
          <div class="panel panel-default latest">
          <div class="panel-body">
              <sapn class="glyphicon glyphicon-shopping-cart"></sapn> Latest 3 Items
          </div>
        <div class="panel-footer">
            <?php

                 $row = latest('Name','item','ID',3);
                 foreach ($row as $rows) {
                     echo "<div class='item'>"
                             ."<span class='glyphicon glyphicon-hand-right'></span>"." ".$rows['Name'].
                          "</div>"."<br>";}
             ?>

        </div>
        </div>
       </div>

       <div class="col-xs-6">
          <div class="panel panel-default latest">
          <div class="panel-body">
              <sapn class="glyphicon glyphicon-envelope"></sapn> Latest 3 Comments
          </div>
        <div class="panel-footer">
            <?php

                 $row = latest('C_Name','comment','C_ID',3);
                 foreach ($row as $rows) {
                     echo "<div class='item'>"
                             ."<span class='glyphicon glyphicon-hand-right'></span>"." ".$rows['C_Name'].
                          "</div>"."<br>";}
             ?>

        </div>
        </div>
       </div>

      </div> <!-- end of row  -->
</div> <!-- end of container  -->



<?php
//end dashboard page
include $templates_path.'footer.php';

}else{
    header('Location:index.php');
}





ob_end_flush();
?>
