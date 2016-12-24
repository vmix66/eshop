<?php

	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', '');
	define('DB', 'eshop');

	define("PATH", "http://eshop.loc/");
	define("PERPAGE", 3);

	$option_perpage = [2, 3, 4, 5];

	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DB) or die('Нет соединения с БД');
	mysqli_set_charset($connection, 'UTF8') or die ('Не установлена кодировка');



