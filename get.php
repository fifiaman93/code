<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "code";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} $j=[];
$q='';
if(isset($_GET['s'])){
   $start=strtotime($_GET['s']);
  $end=strtotime($_GET['e']);
  $q.=" where timestamp between '$start' and '$end'";
} 
  //echo "select * from ph where timestamp between '$start' and '$end'";
  $re=$con->query("select * from ph".$q) or die($con->error);     
  while($r=$re->fetch_assoc()){
      $j[]=array('d'=>$r['date'],'p'=>$r['ph']);
     
  }
  echo json_encode($j);
?>
