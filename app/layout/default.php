<?php

$refresh = rand();

/** @var \app\model\entity\UserEntity $__user__ */
$__user__ = $__user__ ?? null;

?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" type="text/css" href="/resources/css/default.css?v=<?= $refresh ?>">
	<link rel="stylesheet" type="text/css" href="/resources/css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
	      integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

	<title><?= $__title__ ?></title>
</head>

<body id="body">

<div id="debug"></div>

<div id="cart">
	<h3 class="title">shopping bag</h3>
	<div class="text-muted" id="cart-emptyness">empty now</div>
</div>

<header id="header">

	<div class="container-fluid">
		<div class="row justify-content-between align-items-center">

			<div class="col-3 col-sm-2 col-md-1 d-lg-none">
				<div id="mobile-menu-button" class="button">
					<i class="fas fa-bars fa-lg"></i>
				</div>
			</div>

			<div class="col-4 d-none d-lg-inline-block" id="nav">
				<ul>
					<li class="d-none d-md-inline-block">
						<a class="text-button" href="/">
							<span>
								categories
							</span>
						</a>
					</li>
					<li class="d-none d-md-inline-block">
						<a class="text-button" href="/arrivals">
							<span>
								arrivals
							</span>
						</a>
					</li>
					<li class="d-none d-md-inline-block">
						<a class="text-button" href="/product">
							<span>
								products
							</span>
						</a>
					</li>
				</ul>
			</div>

			<div class="col-6 col-sm-8 col-lg-5 col-xl-4" id="logo">
				<a id="logo-link" href="/">inayelle.store</a>
			</div>

			<div class="col-2 col-xl-3 d-none d-lg-inline-block">
				<div id="sign-options">
					<ul>
						<? if( $__isUser__ ): ?>
							<li class="d-none d-md-inline-block">
								<a href="#" class="text-button">
								<span>
									<?= $__user__->email ?>
								</span>
								</a>
							</li>
							<li class="d-none d-md-inline-block">
								<a class="text-button" href="/sign/logout">
								<span>
									log out
								</span>
								</a>
							</li>
						<? else: ?>
							<li class="d-none d-md-inline-block">
								<a href="/sign/in" class="text-button">
								<span>
									sign in
								</span>
								</a>
							</li>
							<li class="d-none d-md-inline-block">
								<a href="/sign/up" class="text-button">
								<span>
									sign up
								</span>
								</a>
							</li>
						<? endif; ?>
					</ul>
				</div>
			</div>

			<div class="col-3 col-sm-2 col-md-1">
				<div id="cart-button" class="button">
					<i id="cart-button-image" class="fas fa-shopping-cart fa-lg"></i>
				</div>
			</div>

		</div>
	</div>
	<div id="mobile-menu">
		<ul>
			<? if( $__isUser__ ): ?>
				<li>
					<a href="#" class="button">
						<h3>
							<?= $__userLogin__ ?>
						</h3>
					</a>
				</li>
				<li>
					<h3>
						<a href="/sign/logout" class="button">log out</a>
					</h3>
				</li>
			<? else: ?>
				<li>
					<h3>
						<a href="/sign/in" class="button">sign in</a>
					</h3>
				</li>
				<li>
					<h3>
						<a href="/sign/up" class="button">sign up</a>
					</h3>
				</li>
			<? endif; ?>
			<li>
				<h4>
					<a href="/" class="button">categories</a>
				</h4>
				<h4>
					<a href="/arrivals" class="button">arrivals</a>
				</h4>
			</li>
		</ul>
	</div>
</header>

<script type="text/javascript" src="/resources/js/jquery.js" defer></script>
<script type="text/javascript" src="/resources/js/default.js?v=<?= $refresh ?>" defer></script>

<div id="content-footer">

	<div id="content">
		
		<?= $__content__ ?? "" ?>

	</div>

	<footer id="footer">
		<div class="container-fluid">
			<div class="row align-items-center justify-content-between">
				<div class="col-12 col-md offset-0 offset-md-2 socials">
					<ul>
						<li>
							<div class="text-button-muted">
								<i class="fab fa-facebook-square fa-2x"></i>
							</div>
						</li>
						<li class="text-muted">
							<div class="text-button-muted">
								<i class="fab fa-instagram fa-2x"></i>
							</div>
						</li>
						<li class="text-muted">
							<div class="text-button-muted">
								<i class="fab fa-pinterest-p fa-2x"></i>
							</div>
						</li>
					</ul>
				</div>
				<div class="col-12 col-md helpings">
					<ul>
						<li>
							<a class="text-button-muted" href="#">
								shipping & returns
							</a>
						</li>
						<li>
							<a class="text-button-muted" href="#">
								size guide
							</a>
						</li>
						<li>
							<a class="text-button-muted" href="#">
								about
							</a>
						</li>
						<li>
							<a class="text-button-muted" href="/admin">
								administrator menu
							</a>
						</li>
						<li>
							<div class="text-muted">
								@inayelle.arts 2018
							</div>
						</li>
					</ul>
				</div>
				<div class="col spacer"></div>
			</div>
		</div>
	</footer>

</div>


</body>
</html>