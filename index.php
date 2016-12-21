<?php
	error_reporting(E_ALL & ~E_NOTICE);

	include 'eshop.php';

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Интернет-каталог ITCom.Od.Ua</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
	<div class="row">
		<header class="col-sm-12">
			<img src="images/eshop_logo.jpg" alt="" id="logo" >
			<img src="images/ad_banner.jpg" alt="" id="ad_banner">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="/">Ocelot</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav" id="menu1">
							<li class="active"><a href="/">Главная</a><span class="sr-only">(current)</span></li>
							<li><a href="./admin/index.php">Товары</a></li>
							<li><a href="./admin/categories.php">Категории</a></li>
							<li><a href="#">Корзина</a></li>
							<li><a href="#">Мой аккаунт</a></li>
							<li><a href="#">Регистрация</a></li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
		</header>
	</div>



	<div class="row">
		<aside class="col-sm-3">
			<div id="cats">
				<div id="categories_title">Категории</div>
				<ul class="category">
					<li><a href=""><?= $categories_menu ?></a></li>
				</ul>
			</div>
			<div id="vend">
				<div id="vendors_title">Производители</div>
				<ul class="vendors">
					<li><a href=""><?php //echo $vendors_list; ?></a></li>
				</ul>
			</div>
		</aside>
		<main class="col-sm-9">
            <p>
	            <?php echo $breadcrumbs; ?>
            </p>
            <hr>
            <?php if($products) : ?>

                <?php if($count_pages > 1) : ?> <!-- верхняя пагинация -->
                    <ul class="pagination">
                        <?= $pagination ?>
                    </ul>
                <?php endif; ?> <!-- конец верхней пагинации -->
                <br>
                <?php foreach($products as $product) : ?>
                    <a href="?product=<?= $product['id'] ?>"><?= $product['title'] ?></a><br>
                <?php endforeach; ?>

                <?php if($count_pages > 1) : ?> <!-- нижняя пагинация -->
                    <ul class="pagination">
			            <?= $pagination ?>
                    </ul>
	            <?php endif; ?> <!-- конец нижней пагинации -->

            <?php else : ?>
                <?php echo "Здесь товаров нет!"; ?>
            <?php endif; ?>

		</main>
	</div>

    <div class="row">
        <footer><?php echo "&copy; Ocelot Studio  -  2017"; ?></footer>
    </div>

</div> <!-- end .container -->

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquery.accordion.js"></script>
<script src="js/jquery.cookie.js"></script>
<script>
    $(document).ready(function() {
        $('.category').dcAccordion();
    });
</script>
</body>
</html>
