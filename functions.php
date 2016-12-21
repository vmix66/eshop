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
		return "Постраничная навигация";
	}