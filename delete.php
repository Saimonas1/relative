<?php 
include ("connect.php");
session_start();

$uid = strip_tags($_POST['uid']);

$sql = "DELETE FROM tasks WHERE uid='$uid'";
mysqli_query($conn, $sql);

header("Location: index.php");
?>