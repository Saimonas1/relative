<?php
include("connect.php");
session_start(); ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>For Relative Works</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    </head>

    <body>
        <?php if(isset($_SESSION['id'])){
			///////////TEKSTAS JEI VARTOTOJAS PRISIJUNGĘS IR KINTAMŲJŲ PRISKYRIMAS PAGAL ID///////////
			$userid = $_SESSION['id'];
			$result = mysqli_query($conn,"SELECT * FROM vartotojai WHERE id='$userid'"); 
			$row = mysqli_fetch_row($result); //Paruošia duomenis, suskirtso pasiimta eilutę į masyvą.
			$level = $row['3'];
			$name = $row['1'];
			switch ($level) {
		 		case '1':
		 			$lvl="Administratorius";
		 			break;
		 		case '0':
		 			$lvl="Vartotojas";
		 			break;
		 		default:
		 			$lvl="Error";
		 			break;
		 	}					 		
			echo "<div id='insidenav'>Tu prisijungęs kaip: <b>".$name."</b> Tu esi<b>: ".$lvl."</b>";
			echo "<form action='logout.php'>
					<button type='submit'>Atsijungti</button>
			</form>
			</div>";
			} ?>
        <?php if(!isset($_SESSION['id'])){
			echo "
			<div id='nav'>
				<a href='javascript:void(0)' onClick='toggleLogin()'>Prisijungimas</a> | 
				<a href='javascript:void(0)' onClick='toggleRegister()'>Registracija</a>
			</div>
			";
			} ?>
        <div id="login">
            <?php if(!isset($_SESSION['id'])){
			//////////////////PRISIJUNGIMO FORMA////////////////////
			echo "<form action='login.php' method='post'>
					Slapyvardis: <input type='text' name='vardas'><br>
					Slaptažodis: <input type='password' name='pass'><br>
					<button type='submit'>Prisijungti</button>
			</form><br>";
				}
			?>
        </div>
        <div id="register">
            <form action="register.php" method="post">
                Slapyvardis: <input type="text" name="vardas"><br> Slaptažodis: <input type="password" name="pass"><br> Vartotojo lygmuo:
                <select name="level">
				<option value="0">Vartotojas</option>
				<option value="1">Administratorius</option>
			</select><br>
                <button type="submit" value="Registruotis">Registruotis</button>
            </form>
        </div>
        <?php
		/////////////////////////VIDUS, KAI VARTOTOJAS PRISIJUNGIA/////////////////////////
		if(isset($level)){
        echo "<div class='content'>";
		switch ($level) {
		 	case '1':
		 			//ADMINISTRATORIAUS VIDUS
		 			$vartotojai = mysqli_query($conn,"SELECT * FROM vartotojai"); ?>
            <div class="cont1">Sukurti užduotį vartotojui:<br>
                <form action='addtask.php' method='post'>
                    <i>Užduotis:</i> <input type='text' name='task'> <i>Kam:</i>
                    <select name='whose'>"
								<?php 
								echo "<option value=''></option>";
								while ($vartlist = mysqli_fetch_assoc($vartotojai)) {
		 							echo "<option value='".$vartlist['vardas']."'>".$vartlist['vardas']."</option>";
		 						}
		 						?>
						</select>
                    <button type='submit'>Pridėti</button><br><br>
                </form>

                <?php $uzduotys = mysqli_query($conn,"SELECT * FROM tasks ORDER BY uid");
		 			$rowcount=mysqli_num_rows($uzduotys);
		 			//UŽDUOČIŲ LENTELĖ
		 			if($rowcount>0){
		 				echo "Užduotys kurias turi atlikti vartotojai:</div>";
		 				echo "<table>";
		 				echo "<tr><th>Užduoties ID</th><th>Užduotis</th><th>Kieno</th><th>Statusas</th><th></th><th></th></tr>";
		 				while ($tasks = mysqli_fetch_assoc($uzduotys)) {
		 					switch ($tasks['status']) {
		 						case '1':
		 							$statusas="Atlikta";
		 							break;
		 						case '0':
		 							$statusas="Neatlikta";
		 							break;
		 						default:
		 							$statusas="Error";
		 							break;
		 					}
							echo "<tr><td>".$tasks['uid']."</td><td>".$tasks['task']."</td><td>".$tasks['whose']."</td><td>".$statusas."
							<td class='none'><form action='delete.php' method='post'>
        						<input type='hidden' name='uid' value=".$tasks['uid'].">
        						<button type='submit'>Trinti</button>
    						</form></td>
    						<td class='none'><form action='edit.php' method='post'>
        						<input type='hidden' name='uid' value=".$tasks['uid'].">
        						<button type='submit'>Redaguoti</button>
    						</form></td></tr>";
						}
						echo "</table>";
		 			}else{
		 				echo "<div class='cont1' style='padding-bottom: 10px;'>Užduočių sąrašas tuščias</div>";
		 			}
		 		break;
		 	case '0':
		 			//VARTOTOJO VIDUS
		 			$uzduotys = mysqli_query($conn,"SELECT * FROM tasks WHERE whose='$name' ORDER BY uid");
		 			$rowcount=mysqli_num_rows($uzduotys);
		 			//UŽDUOČIŲ LENTELĖ
		 			if($rowcount>0){
		 				echo "<div class='cont1'>Užduotys kurias tu turi atlikti:</div>";
		 				echo "<table>";
		 				echo "<tr><th>Užduoties ID</th><th>Užduotis</th><th>Statusas</th><th></th></tr>";
		 				while ($tasks = mysqli_fetch_assoc($uzduotys)) {
		 					switch ($tasks['status']) {
		 						case '1':
		 							$statusas="Atlikta";
		 							break;
		 						case '0':
		 							$statusas="Neatlikta";
		 							break;
		 						default:
		 							$statusas="Error";
		 							break;
		 					}
							echo "<tr><td>".$tasks['uid']."</td><td>".$tasks['task']."</td><td>".$statusas."</td>
							<td><form action='changestatus.php' method='post'>
        						<input type='hidden' name='uid' value=".$tasks['uid'].">
        						<button type='submit'>Atlikau</button>
    						</form></td>
							</tr>";
						}
						echo "</table>";
		 			}else{
		 				echo "<div class='cont1' style='padding-bottom: 10px;'>Tau nėra paskirta užduočių.</div>";
		 			}
		 		break;
		 	default:
		 			echo "<div class='cont1' style='padding-bottom: 10px;'>Tu neturi jokio lygio. Registruokis iš naujo, kad gauti lygį.</div>";
		 		break;
		 } 
           echo "</div>";
		}
		?>
                <script src="jscript.js"></script>
    </body>

    </html>
