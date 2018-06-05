<?php

/** @var \app\model\entity\ProductEntity[] $products */
$products = $products ?? [];

$disabled = ( $__isUser__ ? "submit" : "hidden" );
?>

<link rel="stylesheet" href="/resources/css/index.css?v=<?= $refresh ?>" type="text/css">

<style>
	#please-sign
	{

	li
	{
		display : inline-block;
		width   : 20%;
	}

	}
</style>

<div class="container">
	<h1>Purchase summary</h1>
	<div class="row justify-content-center">
		
		<? foreach( $products as $item ): ?>

			<div class="col-12 col-md-6 col-lg-4 col-xl-3">
				<div class="special-card">
					<a class="special-card-img" href="/product/see?id=<?= $item->id ?>" target="_blank">
						<img src="/resources/img/product_repo<?= $item->getPrimaryImagePath() ?>" alt="purchase-image">
					</a>

					<div class="special-card-title">
						<?= $item->name ?>
					</div>

					<div class="special-card-cost">
						<?= $item->total_cost / 100 ?>$
					</div>
				</div>
			</div>
		
		<? endforeach; ?>
	</div>
	<div class="row justify-content-center">
		<div class="col-12">
			<h2 style="text-align: center">IN TOTAL: <?= $total / 100 ?>$</h2>
		</div>
		<div class="col-12">
			<? if( !$__isUser__ ): ?>
				<h2 class="w-100" style="text-align: center" id="please-sign">
					Please, create an account or sign in with the existing one to continue
				</h2>
				<div class="row justify-content-center">
					<div class="col-12 col-md-6">
						<a href="/sign/in" class="super-button" style="position: absolute; right: 0">sign in</a>
					</div>
					<div class="col-12 col-md-6">
						<a href="/sign/up" class="super-button">sign up</a>
					</div>
				</div>
			<? endif; ?>
			
			<form action="/purchase/submit" method="post" id="submit-purchase-form">
				<input type="hidden" name="products_id" id="products_id" value=<?= $products_id ?>>
				<input type="<?= $disabled ?>" class="super-button" style="margin: 0 auto;" value="PURCHASE">
			</form>
		</div>
	</div>
</div>
</div>

<script type="text/javascript" src="/resources/js/purchase.js" defer></script>