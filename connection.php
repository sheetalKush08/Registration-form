<?php 
// Database connection 
$servername = "localhost"; // Change this if your database is hosted elsewhere 
$username = "root"; // Your database username 
$password = ""; // Your database password 
$dbname = "regform"; // Your database name 
 
// Create connection 
$conn = new mysqli($servername, $username, $password, $dbname); 
 
// Check connection 
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 
     //insert data in database    
   $fname= $_POST['fname']; 
   $mname= $_POST['mname']; 
   $lname= $_POST['lname']; 
   $email= $_POST['email']; 
   $dob= $_POST['dob']; 
   $gender = $_POST['gender']; 
   $occupation= $_POST['occupation']; 
   $areaofinterest= $_POST['areaofinterest']; 
   $mobile= $_POST['mobile']; 
   $address= $_POST['address']; 
   $country= $_POST['country']; 
 
   $sql="INSERT INTO form(fname,mname,lname,email,dob,gender, 
   occupation,areaofinterest,mobile, address,country) values('$fname','$mname','$lname','$email','$dob','$gender', 
   '$occupation','$areaofinterest','$mobile','$address','$country')"; 
    
    if ($conn->query($sql) === TRUE) { 
    echo "New record created successfully";  
    } else { 
    echo "Error: " . $sql . "<br>" . $conn->error; 
    } 
 
    $conn->close(); 
 
 
?>
