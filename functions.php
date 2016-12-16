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