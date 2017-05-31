<?php	
	function cryptage($passwd) {
		return 'PASSWORD(\'ronin' . sha1($passwd) . 'ninor\')';
	}
	
	function structure_SQL($dbh) {
		// Création de table des utilisateurs
		$req = $dbh->exec(	"CREATE TABLE `utilisateurs` (
		    				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
							`login` VARCHAR(255) UNIQUE NOT NULL ,
							`password` VARCHAR(255) NOT NULL)");
	}
?>