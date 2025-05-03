<?php
include("connection.php");
error_reporting(0);

//fetch data from database
$sql = "SELECT * FROM form";
$data = mysqli_query($conn, $sql);

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
</head>
<body>
  <h2 align="center"><mark>Displaying All Records</mark></h2>
  <table border="1" align="center" cellpadding="3" width="100%">
    <tr>
      <th>First Name</th>
      <th>Middle Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>DoB</th>
      <th>Gender</th>
      <th>Occupation</th>
      <th>Area of interest</th>
      <th>Mobile</th>
      <th>Address</th>
      <th>Country</th>
    </tr>
    <?php
    while ($result = mysqli_fetch_assoc($data))
    {
      echo "<tr>
            <td>$result[fname]</td>
            <td>$result[mname]</td>
            <td>$result[lname]</td>
            <td>$result[email]</td>
            <td>$result[dob]</td>
            <td>$result[gender]</td>
            <td>$result[occupation]</td>
            <td>$result[areaofinterest]</td>
            <td>$result[mobile]</td>
            <td>$result[address]</td>
            <td>$result[country]</td>               
          </tr>";
    }
    ?>
  </table>
</body>
</html>
