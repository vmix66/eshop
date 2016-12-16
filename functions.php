<?php

	/**
	 * Распечатка массивов
	 */
	function print_arr($array) {
		echo "<pre>", print_r($array), "</pre>";
	}

	/**
	 * Получение категорий
	 */
	function get_cat() {
		global $connection;
		$query = "SELECT * FROM categories";
		$res = mysqli_query($connection, $query);

		$arr_cat = [];
		while($row = mysqli_fetch_assoc($res)) {
			$arr_cat[] = $row;
		}
		return $arr_cat;
	}