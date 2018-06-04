<link rel="stylesheet" href="/resources/css/arrivals.css" type="text/css">

<?php

/** @var \app\model\entity\ProductEntity[] $arrivals */
$arrivals = $arrivals ?? [];

?>

<div class="container">
	<h1>Latest arrivals</h1>
	<div class="row">
		<? foreach( $arrivals as $product ): ?>
			<? $primaryImage = $product->getPrimaryImagePath(); ?>

			<div class="col-12 col-md-6 col-lg-4">

				<div class="product">

					<img class="image" src="/resources/img/product_repo<?= $product->getPrimaryImagePath(); ?>">

					<div class="row">
						<div class="col-12 col-lg-6">
							<div class="name">
								<?= $product->name ?>
							</div>
						</div>

						<div class="col-12 col-lg-6">
							<div class="cost">
								<?= $product->cost / 100 ?>$
							</div>
						</div>
					</div>

					<div class="row align-items-center">
						<div class="col-12 col-lg-7">
							<div class="description">
								<?= $product->description ?>
							</div>
						</div>

						<div class="col-12 col-lg-5">
							<a class="checkout" href="/product/see?id=<?= $product->id ?>">
								checkout
							</a>
						</div>
					</div>

				</div>
			</div>
		
		<? endforeach; ?>
	</div>
</div>