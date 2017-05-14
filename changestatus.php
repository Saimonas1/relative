<?php 
include ("connect.php");
session_start();

$uid = strip_tags($_POST['uid']);

$sql = "UPDATE tasks
		SET status = '1'
		WHERE uid = '$uid'";
mysqli_query($conn, $sql);

header("Location: index.php");
?>