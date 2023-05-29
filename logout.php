<?php

	

	include 'dbconfig.php';
	
	//distruggo la sessione
	session_start();
	session_destroy();

    header('Location: home_login.php');
	
	



?>