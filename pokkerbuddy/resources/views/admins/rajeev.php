<?php  
//export.php  

$servername = "database-5000034056.ud-webspace.de";
$username = "dbu63883";
$password = "!9xx2domainz";
$dbname = "dbs29133";


$connect = mysqli_connect($servername, $username, $password, $dbname);
$output = '';
if(isset($_POST["export"]))
{
  $query = "SELECT * FROM newletter";
 

 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Name</th>  
                         <th>Address</th>  
                         <th>City</th>  
       <th>Postal Code</th>
       <th>Country</th>
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>'.$row["name"].'</td>  
                         <td>'.$row["email"].'</td>  
                         <td>'.$row["age"].'</td>  
       <td>'.$row["PostalCode"].'</td>  
       <td>'.$row["Country"].'</td>
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
 }
}
?>
