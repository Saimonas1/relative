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
	$level = $_POST['level'];

	if(strlen($vardas)<3 or strlen($vardas)>20){
		echo "<div class='failtext'>Prisijungimo vardą turi sudaryti nuo 3 iki 20 simbolių.<br>";
		echo "<a href='index.php'>Supratau, grįžti atgal.</a></div>";
	}elseif(strlen($pass)<5 or strlen($pass)>20){
		echo "<div class='failtext'>Slaptažodį turi sudaryti nuo 5 iki 20 simbolių.<br>";
		echo "<a href='index.php'>Supratau, grįžti atgal.</a></div>";
	}else{
		$sql = "INSERT INTO vartotojai (vardas, pass, level) VALUES ('$vardas','$pass','$level')";
		$result = mysqli_query($conn, $sql);
		if($result){
			header("Location: index.php");
		}else{
			echo "<div class='failtext'>Toks vartotojo vardas jau egzistuoja.<br>";
			echo "<a href='index.php'>Supratau, grįžti atgal.</a></div>";
		}
	}
?>
</body>
</html>