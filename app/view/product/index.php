<?php

$refresh = rand();
?>

<link rel="stylesheet" href="/resources/css/arrivals.css?v=<?= $refresh ?>" type="text/css">
<link rel="stylesheet" href="/resources/css/product.css?v?=<?= $refresh ?>" type="text/css">

<div class="container" id="product-container">
	<h1>Our products</h1>
	<div class="row justify-content-center" id="products">
		<div class="row w-100" id="filters">
			<div class="col-12 col-md-6">
				<h2>Categories:</h2>
				<fieldset id="categories">
					<div class="input-grouping">
						<label for="tuxedo-filter">Tuxedo</label>
						<input type="checkbox" id="tuxedo-filter" value="1">
					</div>
					<div class="input-grouping">
						<label for="shoes-filter">Shoes</label>
						<input type="checkbox" id="shoes-filter" value="2">
					</div>
					<div class="input-grouping">
						<label for="sweater-filter">Sweater</label>
						<input type="checkbox" id="sweater-filter" value="3">
					</div>
					<div class="input-grouping">
						<label for="watch-filter">Watch</label>
						<input type="checkbox" id="watch-filter" value="4">
					</div>
					<div class="input-grouping">
						<label for="tshirt-filter">T-shirt</label>
						<input type="checkbox" id="tshirt-filter" value="5">
					</div>
					<div class="input-grouping">
						<label for="underwear-filter">Underwear</label>
						<input type="checkbox" id="underwear-filter" value="6">
					</div>
				</fieldset>
			</div>
			<div class="col-12 col-md-6">
				<h2>Pricing:</h2>
				<fieldset id="prices">
					<label for="lower-price">Lower price</label>
					<input type="number" id="lower-price">
					<label for="upper-price">Upper price</label>
					<input type="number" id="upper-price">
				</fieldset>
			</div>
			<div class="super-button" id="apply-filters">apply filters</div>
		</div>

	</div>
	<div id="no-more-message" class="hidden">no more items</div>
	<div class="super-button" id="update-button" style="margin-top: 20px">load more</div>
</div>


<script type="text/javascript" src="/resources/js/product.js?v=<?= $refresh ?>" defer></script>