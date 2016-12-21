<?php

	/**
	 * Распечатка массивов
	 */
	function print_arr($array) {
		echo "<pre>", print_r($array, true), "</pre>";
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
			$arr_cat[$row['id']] = $row;
		}
		return $arr_cat;
	}

	/**
	 * Построение дерева
	 **/
	function map_tree($dataset) {

		$tree = [];
		foreach ($dataset as $id=>&$node) {
			if (!$node['parentId']){
				$tree[$id] = &$node;
			}else{
				$dataset[$node['parentId']]['childs'][$id] = &$node;
			}
		}

		return $tree;
	}

	/**
	 * Дерево в строку
	 *
	 * @return string
	 */
	function categories_to_string($data) {

		$str = '';
		foreach ($data as $item) {
			$str .= categories_to_template($item);
		}
		return $str;

	}

	/**
	 * Шаблон вывода категорий
	 *
	 * @return string
	 */
	function categories_to_template($category) {

		ob_start();
			include 'category_template.php';

		return ob_get_clean();
	}

	function breadcrumbs($array, $id) {
		if(!$id) return false;

		$count = count($array);
		$breadcrumbs_array = [];
		for($i = 0; $i < $count; $i++) {
			if($array[$id]) {
				$breadcrumbs_array[$array[$id]['id']] = $array[$id]['name'];
				$id = $array[$id]['parentId'];
			} else break;
		}
		//echo $i; // для проверки сколько итераций прошло
		return array_reverse($breadcrumbs_array, true); // true для сохранения ключей
	}


	/**
	 * Получение id дочерних категорий
	 * @param $array
	 * @param $id
	 *
	 * @return bool|string
	 */
	function cats_id($array, $id) {
		if(!$id) return false;

		foreach($array as $item) {
			if($item['parentId'] == $id) {
				$data .= $item['id'] . ",";
				$data .= cats_id($array, $item['id']);
			}
		}
		return $data;
	}

	/**
	 *  Получение списка товаров
	 * @param $ids
	 *
	 * @return array
	 */
	function get_products($ids, $start_pos, $perpage) {
		global $connection;
		if($ids) {
			$query = "SELECT * FROM products WHERE  categoryId IN($ids) ORDER BY title LIMIT $start_pos, $perpage";
		} else {
			$query = "SELECT * FROM products ORDER BY title LIMIT $start_pos, $perpage";
		}
		$res = mysqli_query($connection, $query);
		$products = [];
		while($row = mysqli_fetch_assoc($res)) {
			$products[] = $row;
		}
		return $products;
	}

	/**
	 * Количество товаров
	 * @param $ids
	 *
	 * @return mixed
	 */
	function count_goods($ids) {
		global $connection;
		if(!$ids) {
			$query = "SELECT COUNT(*) FROM products";
		} else {
			$query = "SELECT COUNT(*) FROM products WHERE categoryId IN ($ids)";
		}
		$res = mysqli_query($connection, $query);
		$count_goods = mysqli_fetch_row($res);
		return $count_goods[0];
	}

	function pagination($page, $count_pages) {

		// <<  <  3  4  5  6  7  >  >>
		// $startpage - ссылка в НАЧАЛО
		// $endpage - ссылка в КОНЕЦ
		// $back - ссылка НАЗАД
		// $forward - ссылка ВПЕРЕД
		// $page1left - ссылка на ОДНУ страницу влево
		// $page2left - ссылка на ДВЕ страницу влево
		// $page1right - ссылка на ОДНУ страницу вправо
		// $page2right - ссылка на ДВЕ страницу вправо

		// проверка есть ли что до параметра page и сохранение этого "что-то"
		$uri = "?";
		// если есть параметры в адресной строке
		if($_SERVER['QUERY_STRING']) {
			foreach ($_GET as $key => $value) {
				if($key != 'page') $uri .= "$key=$value&amp;";
			}
		}

		if($page > 1) $back = "<li><a class='nav-link' href='{$uri}page=" . ($page-1) . "'>&lt;</a>"; // ссылка НАЗАД
		if($page < $count_pages) $forward = "<li><a class='nav-link' href='{$uri}page=" . ($page+1) . "'>&gt;</a></li>"; // ссылка ВПЕРЕД
		if($page > 3) $startpage = "<li><a class='nav-link' href='{$uri}page=" . 1 . "'>&lt;&lt;</a></li>"; // ссылка В НАЧАЛО
		if($page < ($count_pages - 2)) $endpage = "<li><a class='nav-link' href='{$uri}page=" . $count_pages . "'>&gt;&gt;</a></li>"; // ссылка В КОНЕЦ
		if(($page - 2) > 0 ) $page2left = "<li><a class='nav-link' href='{$uri}page=" . ($page - 2) . "'>" . ($page - 2) . "</a></li>"; // ссылка на 2-ю слева
		if(($page - 1) > 0 ) $page1left = "<li><a class='nav-link' href='{$uri}page=" . ($page - 1) . "'>" . ($page - 1) . "</a></li>"; // ссылка на 1-ю слева
		if(($page + 1) <= $count_pages ) $page1right = "<li><a class='nav-link' href='{$uri}page=" . ($page + 1) . "'>" . ($page + 1) . "</a></li>"; // ссылка на 1-ю справа
		if(($page + 2) <= $count_pages ) $page2right = "<li><a class='nav-link' href='{$uri}page=" . ($page + 2) . "'>" . ($page + 2) . "</a></li>"; // ссылка на 2-ю справа

		return $startpage. $back . $page2left . $page1left . '<li class="nav-active"><a>'. $page . '</a></li>' . $page1right . $page2right . $forward . $endpage;

	}