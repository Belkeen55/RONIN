Installation RONIN (Fait sur Raspbian jessie lite 2017 04 10) 
==
#### Configuration du serveur
	$ sudo raspi-config 
		Interfacing Options
			Activer le serveur SSH 
		Dans Advanced Options 
			Expand fileSystem 
		Dans Localisation Option 
			Change Locale 
				Desactiver en_GB.UTF-8 UTF-8 
				Activer fr_FR.UTF-8 UTF-8 
				Confirmer fr_FR.UTF-8 
			Change TimeZone 
		HostName Ronin 
		Accepter le reboot 

#### Securisation de connexion au serveur
	$ sudo adduser "utilisateur" 
	$ sudo visudo 
	Ajouter "utilisateur" ALL=(ALL) NOPASSWD: ALL à la fin du fichier (Ctrl + O pour enregistrer, Ctrl + X pour fermer) 
	$ logout 
	login avec "utilisateur" 
	$ sudo deluser --remove-home pi 
	$ sudo passwd 
	
#### Mise à jour du serveur
	$ sudo apt update 
	$ sudo apt upgrade 
	
#### Installation des packages
	$ sudo apt install apache2 
	$ sudo apt install php5 
	$ sudo apt install mysql-server php5-mysql 
	$ sudo apt install phpmyadmin 
	$ sudo apt install git 

#### Preparation des dossiers web
	$ sudo mkdir /var/www/serveur-test/ 
	$ sudo mkdir /var/www/codiad/ 
	$ cd /etc/apache2/sites-available 
	$ sudo cp 000-default.conf serveur-test.conf 
	$ sudo cp 000-default.conf codiad.conf 
	$ sudo nano serveur-test.conf 
		Changer le port et le dossier (Ctrl + O pour enregistrer, Ctrl + X pour fermer) 
	$ sudo nano codiad.conf 
		Changer le port et le dossier (Ctrl + O pour enregistrer, Ctrl + X pour fermer) 
	$ sudo nano /etc/apache2/ports.conf 
		Ajouter le port du serveur de test et de codiad : Listen "xx" (Ctrl + O pour enregistrer, Ctrl + X pour fermer) 
	$ sudo a2ensite serveur-test.conf 
	$ sudo a2ensite codiad.conf 
	$ sudo service apache2 reload 
	$ sudo git clone https://github.com/Codiad/Codiad /var/www/codiad/ 
	$ sudo touch /var/www/codiad/config.php 
	$ sudo chown -R www-data:"Utilisateur" /var/www/html/ 
	$ sudo chmod -R 770 /var/www/html 
	$ sudo chown -R www-data:"Utilisateur" /var/www/serveur-test/ 
	$ sudo chmod -R 770 /var/www/serveur-test 
	$ sudo chown -R www-data:"Utilisateur" /var/www/codiad/ 
	$ sudo chmod -R 770 /var/www/codiad 
	$ sudo reboot 
	
#### Creation Key SSH pour GitHUB
	$ ssh-keygen -t rsa -b 4096 -C "adresse_mail" 
	$ cd ~/.ssh 
	$ eval `ssh-agent -s` 
	$ eval `ssh-agent -c` 
	$ ssh-add id_rsa 
	$ more id_rsa.pub 
		copier/coller le résultat dans son compte gitHub/Setting/SSH Keys

#### Mise en place du git
	$ cd /var/www/html/ 
	$ git init 
	$ sudo git remote add hub git@github.com:Belkeen55/RONIN.git 
	$ git pull hub master 
	$ cd /var/www/serveur-test/ 
	$ git init 
	$ sudo git remote add hub git@github.com:Belkeen55/RONIN.git 
	$ git pull hub master 
	
	
#### Installation outils de clonage
	$ cd ~
	$ git clone https://github.com/billw2/rpi-clone.git 
	$ cd rpi-clone 
	$ sudo cp rpi-clone /usr/local/sbin 
	$ sudo blkid 
	$ sudo rpi-clone "sdX" 
