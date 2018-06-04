<?php

/** @var \app\model\entity\ProductEntity $product */
$product = $product ?? null;
?>

<style>
	#content
	{
		font-size : 15px;
	}
</style>

<div class="container">
	
	
	<? if( !$productFound ): ?>
		<h1 style='margin: 50% auto 0;' class='text-muted'>Product not found</h1>
	<? else: ?>

		<div class="row">
			<div class="col-12 col-md-7">
				<img style="width: 100%;" src="/resources/img/product_repo<?= $product->getPrimaryImagePath(); ?>" alt="product image">
			</div>
			<div class="col-12 col-md-5">
				<h1>
					<?= $product->name ?>
				</h1>
				<h3>
					<?= $product->description ?>
				</h3>

				<b>Cost: </b> <?= $product->cost / 100 ?>$ <br>
				<b>In stock: </b> <?= ( $product->in_stock ? "yes" : "no" ) ?> <br>
				<b>Discount: </b> <?= $product->discount ?>% <br>
				<b>Color: </b> <?= $product->color ?> <br>
			</div>
		</div>
	
	<? endif; ?>

</div>