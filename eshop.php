<?php

	include 'config.php';
	include 'functions.php';

	$categories = get_cat();
	$categories_tree = map_tree($categories);
	$categories_menu = categories_to_string($categories_tree);

	if(isset($_GET['category'])) {
		$id = (int)$_GET['category'];

		//хлебные крошки
		// вернет true если (not empty array) || (not false)
		$breadcrumbs_array = breadcrumbs($categories, $id);

		if($breadcrumbs_array) {
			$breadcrumbs = "<a href='/eshop/'>Главная</a> / ";
			foreach($breadcrumbs_array as $id => $name) {
				$breadcrumbs .= "<a href='?category={$id}'>{$name}</a> / ";
			}
			$breadcrumbs = rtrim($breadcrumbs, " / ");
			$breadcrumbs = preg_replace("~(.+)?<a.+>(.+)</a>$~", "$1$2", $breadcrumbs); // убираем ссылку <a> на последний элемент
		} else {
				$breadcrumbs = "<a href='/'>Главная</a> / Каталог";
		}

	}