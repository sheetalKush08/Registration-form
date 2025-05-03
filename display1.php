<?php

  include("connection.php");
 error_reporting(0);
  
  $query = "SELECT * FROM FORM";
  $data = mysqli_query($conn, $query);
  
  $total = mysqli_num_rows($data);
  
  echo "Total Numbers of records : " . $total ."";
  
  if ($total != 0)
  {
   // echo "Total has records";
  }
  else

  {
    echo "not found";
  }

    
 ?>
 <html>
<head>
  <title>Display</title>
<style>
  body
  {   background-color: #ccc;
        background-attachment: fixed;
        
  }
  table
  {
    font-family: sans-serif;
    font-size: 15px;
    background-color: white;

  }
  th
  {
    font-family: gadugi;  
    background-color: deeppink;
  }
  td
  {
    background-color: transparent;
    color: black;
    text-align: center;
  }
  
</style>

</head>
<body>
</html>

<?php

  include("connection.php");
  error_reporting(0);
  
  $query = "SELECT * FROM form";
  $data = mysqli_query($conn, $query);
  
  $total = mysqli_num_rows($data);
  
  
  
  if ($total != 0)
  {
    
 ?>

  <h2 align="center"><mark>Displaying All Records</mark></h2>
   
   <table border="10" align="center" cellpadding="3" width="100%">
    <tr bgcolor="red">
      <th width="15%">First Name </th>
      <th width="15%">Middle Name </th>
      <th width="15%">Last Name</th>
      <th width="15%">Email</th>
      <th width="15%">DoB</th>
      <th width="10%">Gender</th>
      <th width="15%">Occupation</th>
      <th width="25%">Area of interest</th>
      <th width="15%">Mobile</th>
      <th width="25%">Address</th>
      <th width="15%">Country</th>
      

    </tr>
   


 <?php
    while ($result = mysqli_fetch_assoc($data))
    {
        
      echo "<tr>
            <td>$result[fname]</td>
             <td>$result[mname] </td>
              <td>$result[lname] </td>
              <td>$result[email] </td>
              <td>$result[dob] </td>
              <td>$result[gender] </td>
              <td>$result[occupation]</td>
              <td>$result[areaofinterest] </td>
              <td>$result[mobile]</td>
              <td>$result[address]</td>
              <td>$result[country] </td>               
        </tr>
          ";
    }
   
} 
else
{
    echo "No records found";
}
?>


</table>