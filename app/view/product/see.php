<?php

$refresh = rand();
/** @var \app\model\entity\ProductEntity $product */
$product = $product ?? null;
?>

<link rel="stylesheet" href="/resources/css/see.css?v=<?= $refresh ?>" type="text/css">

<div class="container">
	
	
	<? if( !$productFound ): ?>
		<h1 style='margin: 50% auto 0;' class='text-muted'>Product not found</h1>
	<? else: ?>

		<div class="row">
			<div class="col-12 col-md-5">
				<img style="width: 100%;" id="primary-image" src="/resources/img/product_repo<?= $product->getPrimaryImagePath(); ?>"
				     alt="product image" data-id="<?=$product->id?>">
				
				<? foreach( $product->images as $image ): ?>
					<div class="small-img">
						<img id="img-<?= $image->id ?>" src="/resources/img/product_repo<?= $image->path ?>" alt="alter image">
					</div>
				
				<? endforeach; ?>
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
				<b>Total cost: </b> <?= $product->total_cost / 100 ?>$ <br>


				<div class="super-button" id="add-to-card-button">add to card</div>
			</div>
		</div>
	
	<? endif; ?>

</div>

<script type="text/javascript" src="/resources/js/see.js?v=<?= $refresh ?>" defer></script>