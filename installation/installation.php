<?php
	ini_set('display_errors', 1); // Affichage des erreurs
	error_reporting(E_ALL);
	include('../lib/mysql/mysql.php'); // Recupération des fonctions liées à MySQL
	if(!file_exists('../lib/mysql/acces.php')) { // Verification si l'installation a déjà été faite
		if(isset($_POST['base_SQL'])) { // Si l'utilisateur a rempli les infos de connexion de la BDD
			try {
				if(isset($_POST['new_base_SQL'])) { // Si l'utilisateur a demandé la creation d'une nouvelle base
					$dbh = new PDO('mysql:host=localhost', $_POST['user_SQL'], $_POST['password_SQL']);
				}
				else {
			    	$dbh = new PDO('mysql:host=localhost;dbname=' . $_POST['base_SQL'], $_POST['user_SQL'], $_POST['password_SQL']);
			    	if(isset($_POST['login'])) { // Si l'utilisateur à rempli le formulaire de création de compte
			    		$req = $dbh->exec('INSERT INTO utilisateurs VALUES (NULL , \'' . $_POST['login'] . '\', ' . cryptage($_POST['password']) . ')');
			    	}
			    	$fichier_sql = fopen('../lib/mysql/acces.php', 'w+'); // Creation du fichier php d'information de login
			    	fwrite($fichier_sql,	'<?php $login_SQL = \'' . $_POST['user_SQL'] . '\'; $password_SQL = \'' . $_POST['password_SQL'] . '\'; 
					$base_SQL = \'' . $_POST['base_SQL'] . '\'; ?>');
					fclose($fichier_sql);
			    	echo "<script type='text/javascript'>document.location.replace('../index.php');</script>"; // Redirection vers l'index
				}
			}
			catch (PDOException $e) { // Si erreur de connexion à la base
			    print "Connexion impossible à la base de données, ";
			    die();
			}
		}
?>
		<html>
			<head>
				<title>RONIN</title>
				<meta charset="utf-8" />
			</head>
			<body>
				<?php
					if(!isset($_POST['base_SQL']) && !isset($_POST['login'])) { // Premier chargement de la page
				?>
					<div align="center"><b><font size="4"> Installation RONIN </font></b>
						<br>
						<br>
						<b><font size="4">Veuillez saisir les informations suivantes</font></b>
						<br>
						<br>
					<form action="installation.php" method="post">
						Nom de la base de données MySQL</font></b>
						<br>
						<input type="text" name="base_SQL">
						<br>
						<input type="checkbox" name="new_base_SQL" value="True"> Nouvelle base ?
						<br>
						<br>
						Nom de l'utilisateur de MySQL</font></b>
						<br>
						<input type="text" name="user_SQL">
						<br>
						<br>
						Mot de passe de la base MySQL</font></b>
						<br>
						<input type="password" name="password_SQL">
						<br>
						<br>
						<input type="submit" name="Submit" value="Valider">
					</form>
					</div>
				<?php
					}
					else {
						if(isset($_POST['new_base_SQL'])) { // Creation de la nouvelle base
							$dbh->exec('CREATE DATABASE ' . $_POST['base_SQL']);
							$dbh = new PDO('mysql:host=localhost;dbname=' . $_POST['base_SQL'], $_POST['user_SQL'], $_POST['password_SQL']);
				    		structure_SQL($dbh);
						// Formulaire de creation du login et password de l'utilisateur
				?>
							<div align="center"><b><font size="4"> Installation RONIN </font></b>
								<br>
								<br>
								<b><font size="4">Création du compte administrateur</font></b>
								<br>
								<br>
							<form action="installation.php" method="post">
								Login</font></b>
								<br>
								<input type="text" name="login">
								<br>
								<br>
								Mot de passe</font></b>
								<br>
								<input type="password" name="password">
								<input type="hidden" name="base_SQL" value="<?php echo $_POST['base_SQL'] ?>">
								<input type="hidden" name="user_SQL" value="<?php echo $_POST['user_SQL'] ?>">
								<input type="hidden" name="password_SQL" value="<?php echo $_POST['password_SQL'] ?>">
								<br>
								<br>
								<input type="submit" name="Submit" value="Valider">
							</form>
							</div>
<?php
						}	
					}
	}
	else {
?>
		<html>
			<head>
				<title>RONIN</title>
				<meta charset="utf-8" />
			</head>
			<body>
				L'installation du système a déjà été effectuée.
<?php
	}
?>
	</body>
</html>