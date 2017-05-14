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

	$task = strip_tags($_POST['task']);
	$whose = strip_tags($_POST['whose']);

	if(strlen($task) < 5){
		echo "<div class='failtext'>Užduotį turi sudaryti bent 5 simboliai<br>";
		echo "<a href='index.php'>Supratau, grįžti atgal.</a></div>";
	}else if(!$whose){
		echo "<div class='failtext'>Pasirinkite kam priskirsite užduotį.<br>";
		echo "<a href='index.php'>Supratau, grįžti atgal.</a></div>";
	}else{
		$sql = "INSERT INTO tasks (task, whose, status) VALUES ('$task','$whose','0')";
		$result = mysqli_query($conn, $sql);
		header("Location: index.php");
	}
?>
</body>

</html>
