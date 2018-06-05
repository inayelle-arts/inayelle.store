<?php

/** @var \app\model\entity\ProductEntity[] $discounted */
$discounted = $discounted ?? [];
?>

<link rel="stylesheet" href="/resources/css/index.css?v=<?= $refresh ?>" type="text/css">

<div class="arrivals-parallax card">
	<div class="card-title">
		new arrivals
	</div>
	<a class="super-button" href="/arrivals">
		take a look
	</a>
</div>

<div class="container">
	<div class="row justify-content-center align-items-center">
		<div class="col-12 col-lg-6">
			<div class="tuxedo">
				<div class="card-title">
					tuxedo
				</div>

				<a class="super-button" href="/product?cat=1">
					must fit you fabuluos
				</a>
			</div>
		</div>

		<div class="col col-lg-6">
			<div class="shoes">
				<div class="card-title">
					shoes
				</div>

				<a class="super-button" href="/product?cat=2">
					do sports freely
				</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12 col-lg-8">
			<div class="sweater">
				<div class="card-title">
					sweater
				</div>

				<a class="super-button" href="/product?cat=3">
					warms nice
				</a>
			</div>
		</div>
		<div class="col-12 col-lg-4">
			<div class="watch">
				<div class="card-title">
					elegant watches
				</div>

				<a class="super-button" href="/product?cat=4">
					keep solid
				</a>
			</div>
		</div>
	</div>
</div>

<div class="about card">
	<div class="card-title">
		about us
	</div>
	<div class="super-button">
		feel free to be in touch
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col col-lg-6">
			<div class="t-shirt">
				<div class="card-title">
					fresh look t-shirt
				</div>

				<a class="super-button" href="/product?cat=5">
					feel the freedom
				</a>
			</div>
		</div>
		<div class="col col-lg-6">
			<div class="underwear">
				<div class="card-title">
					underwear
				</div>

				<a class="super-button" href="/product?cat=6">
					become attractive
				</a>
			</div>
		</div>
	</div>
</div>

<div class="special-parallax card-right">
	<div class="card-title">
		special offers
	</div>
</div>

<div class="container">
	<div class="row justify-content-center">
		
		<? foreach( $discounted as $item ): ?>
			<? if( $item->discount === 0 ): ?>
				<? continue; ?>
			<? endif; ?>
			<div class="col-12 col-md-6 col-lg-4 col-xl-3">
				<div class="special-card">
					<div class="special-card-img">
						<img src="/resources/img/product_repo<?= $item->getPrimaryImagePath() ?>" alt="discounted-image">
					</div>

					<div class="special-card-title">
						<?= $item->name ?>
					</div>

					<div class="special-card-cost">
						<?= $item->cost / 100 ?>$
					</div>
					<div class="special-card-subtitle">
						<?= $item->discount ?>%
					</div>

					<a class="special-card-button" href="/product/see?id=<?= $item->id ?>">
						checkout
					</a>
				</div>
			</div>
		<? endforeach; ?>
	</div>
</div>