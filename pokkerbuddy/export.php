<?php  
//export.php  
error_reporting(0);
$servername = "localhost";
$username = "pokkerBuddy";
$password = "pokkerbuddy";
$dbname = "pokkerBuddy";


$connect = mysqli_connect($servername, $username, $password, $dbname);
$output = '';


  $query = "SELECT * FROM newletter where status=1"; 

 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Name</th>  
                         <th>Email</th>  
                         <th>City</th>
                         <th>Age</th>
                        <th>Country</th>
                        <th>Gender</th>
     
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>'.$row["name"].'</td>  
                         <td>'.$row["email"].'</td> 
                          <td>'.$row["city"].'</td>  
                         <td>'.$row["age"].'</td> 
                          <td>'.$row["country"].'</td>
                           
                             <td>'.$row["gender"].'</td> 
                    </tr>
   ';
  }
  $output .= '</table>';

  header('Content-Type: application/xls');
  header("Content-Disposition: attachment; filename=".date('d/M/Y').".xls");
  echo $output;
 

}
?>
