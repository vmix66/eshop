<?php

	include 'config.php';
	include 'functions.php';

	$categories = get_cat();
	$categories_tree = map_tree($categories);
	$categories_menu = categories_to_string($categories_tree);



	if(isset($_GET['product'])) {
		$product_id = (int)$_GET['product'];
		// массив данных продукта
		$get_one_product = get_one_product($product_id);
		// получение id категории
		$id = $get_one_product['categoryId'];

	} else {
		$id = (int)$_GET['category'];
	}

	//хлебные крошки
	// вернет true если (not empty array) || (not false)
	$breadcrumbs_array = breadcrumbs($categories, $id);

	if($breadcrumbs_array) {
		$breadcrumbs = "<a href='" . PATH . "'>Главная</a> / ";
		foreach($breadcrumbs_array as $id => $name) {
			$breadcrumbs .= "<a href='" . PATH . "?category={$id}'>{$name}</a> / ";
		}

		if(!isset($get_one_product)) {
			$breadcrumbs = rtrim($breadcrumbs, " / ");
			$breadcrumbs = preg_replace("~(.+)?<a.+>(.+)</a>$~", "$1$2", $breadcrumbs); // убираем ссылку <a> на последний элемент
		} else {
			$breadcrumbs .= $get_one_product['title'];
		}

	} else {
			$breadcrumbs = "<a href='" . PATH . "'>Главная</a> / Каталог";
	}

	// Получение id всех дочерних категорий
	$ids = cats_id($categories, $id);
	$ids = !$ids ? $id : rtrim($ids, ","); // Если NULL в $ids, то вытащим только товары из этой ($id) категории

	// ======== Пагинация ==========
	$perpage = (int)$_COOKIE['per_page'] ? $_COOKIE['per_page'] : PERPAGE ; // кол-во товаров на страницу
	$count_goods = count_goods($ids); // сколько товаров всего в выбранной категории и ее подкатегориях
	$count_pages = ceil($count_goods / $perpage); // сколько потребуется страниц
	if(!$count_pages) $count_pages = 1; // минимум одна страница
	// номер запрошенной страницы
	if(isset($_GET['page'])) {
		$page = (int)$_GET['page'];
		if($page < 1) $page = 1;
	} else {
		$page = 1;
	}
	// если запрошенная страница больше максимальной
	if($page > $count_pages) $page = $count_pages;

	// начальная позиция для запроса
	$start_pos = ($page - 1) * $perpage;

	$pagination = pagination($page, $count_pages);




	// ======== Пагинация ==========


	$products = get_products($ids, $start_pos, $perpage);
