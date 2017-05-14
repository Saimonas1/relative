<?php 
	include ("connect.php");
	session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Užduoties redagavimas</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>

<body>
    <div class="content edit">
        <?php
		$uid = strip_tags($_POST['uid']);
		$sql = "SELECT * FROM tasks WHERE uid='$uid'";
		$result = mysqli_query($conn, $sql);
		$arr = mysqli_fetch_row($result); 
        
        echo "Redaguoti vartotojo užduotį: <br><br>";
		echo "
		<form id='editform' action='edit.php' method='post'>
			<input type='hidden' name='uid' value='$uid'>
			ID: <input type='number' value='$arr[0]' name='uidedited'><br>
			Užduotis: <input type='text' value='$arr[1]' name='taskedited'><br>
			Statusas: 
			<select name='stedited'>
				<option value='$arr[3]'></option>
				<option value='1'>Atlikta</option>
				<option value='0'>Neatlikta</option>
			</select><br><br>
			<button type='submit'>Redaguoti</button>  <a href='index.php'>Grįžti atgal</a>
		</form>";


		if(isset($_POST['uidedited']) OR isset($_POST['taskedited'])){
			if(strlen($_POST['taskedited'])<5){
				echo '<br><br>Užduotis turi būti sudaryt bent iš 5 simbolių.';
			}else if($_POST['uidedited']<1){
				echo '<br><br>ID turi būti teigiamas skaičius.';
			}else{
				$uied = $_POST['uidedited'];
				$tasked = $_POST['taskedited'];
				$stedited = $_POST['stedited'];
				$sql = "UPDATE tasks
				SET uid = '$uied', task = '$tasked', status = '$stedited'
				WHERE uid = '$uid'";
				mysqli_query($conn, $sql);
				header("Location: index.php");
			}
		}
	?>
    </div>
</body>

</html>
