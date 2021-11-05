<style>
button{background:blue;color:#fff;border:none;}
</style>
<form method="post" enctype="multipart/form-data">
<input type="file" name="csv" value="" />
<input type="submit" name="submit" value="Upload" /></form>

<?php if(!isset($_FILES['csv'])){die();}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "code";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 
if($_FILES['csv']['error'] == 0){
    $name = $_FILES['csv']['name'];
    $type = $_FILES['csv']['type'];
    $tmpName = $_FILES['csv']['tmp_name'];

    // check the file is a csv
   
        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            
$row = 0;
            while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // number of fields in the csv
                $col_count = count($data);
		
             $row++; 
             if($row!=1){
        $re=$con->query("select id from ph where date='".$data[0]."'");     
        if($re->num_rows==0){
            $timstamp=strtotime($data[0]);
         $con->query("insert into ph(date,ph,timestamp) value('".$data[0]."','".$data[3]."','$timstamp')");    
             //   print_r($data);
        }
		 }
             
                
            }
            fclose($handle);
            echo '<script>location.href="index.php";</script>';
        }
    
}
?>
