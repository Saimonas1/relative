<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Klaida!</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php 
	include ("connect.php");
	session_start();

	$vardas = strip_tags($_POST['vardas']);
	$pass = strip_tags($_POST['pass']);

	$sql = "SELECT * FROM vartotojai WHERE vardas='$vardas' AND pass='$pass'";
	$result = mysqli_query($conn, $sql);

	if(!$row=mysqli_fetch_assoc($result)){
		echo "<div class='failtext'>Prisijungimo klaida. Patikrinkite ar visus duomenis įvedėte teisingai.<br>";
		echo "<a href='index.php'>Supratau, grįžti atgal.</a></div>";
	}else{
		$_SESSION['id'] = $row['id'];
		header("Location: index.php");
	}
?>
</body>
</html>