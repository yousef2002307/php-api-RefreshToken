<?php

	include "init.php";
	$connection = new Connection($_ENV['DB_HOST'],$_ENV['DB_NAME'],$_ENV['DB_USER'],$_ENV['DB_PASS']);
	$refreshtoken2 = new refreshgatway($connection,$_ENV['SECRET_KEY']);
	
	echo $refreshtoken2->deleteExpired();

