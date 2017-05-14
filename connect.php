<?php 
$conn = mysqli_connect("localhost","root","");

mysqli_select_db($conn, "fortest"); 

if (!$conn) 
{
  die("<b>Duomenų bazės klaida:</b> ".mysqli_connect_error());
}
?>
