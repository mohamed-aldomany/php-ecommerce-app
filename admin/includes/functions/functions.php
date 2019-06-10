<?php


// set the title to each page  :
 function getTitle(){

  global $title;
  if (isset($title)) {
    echo $title;
  }else {
    echo "Default";
  }
}




//used to redirect the url when there is a hack:
function getMessage($themsg,$url=null,$secounds=5){

    if ($url==null) {
        $url = 'dashboard.php';
    }else{

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=='' ) {

            $url=$_SERVER['HTTP_REFERER'];
        }else{
            $url='dashboard.php';
        }
    }



    echo $themsg."<h3 style='color: black; text-align: center;'>".$secounds."secounds "."</h3>";
    header("refresh:$secounds;url=$url");

}



//used to check the availability element in database:

function check($select,$table,$cond){

    global $con;
    $stmt = $con->prepare("SELECT $select FROM $table WHERE $select=:cond");
    $stmt->execute(array(':cond'=>$cond));
    $count = $stmt->rowCount();
    return $count;
}




/*
*count the passed element in the database and return the numbers of it
*/

function countItem($column,$table){

    global $con;
    $stmt = $con->prepare("SELECT COUNT($column) FROM $table");
    $stmt->execute();
    return $stmt->fetchcolumn();
}





/*
function get the latest users ,items,etc from database
*/
function latest($column,$table,$order,$limit=4){

    global $con;
    $stmt =$con->prepare("SELECT $column  FROM $table ORDER BY($order) DESC LIMIT $limit ");
    $stmt->execute();
    $row = $stmt->fetchall();
    return $row;
}





 ?>





