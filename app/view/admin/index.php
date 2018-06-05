<?php

$refresh = rand();

?>

<link rel="stylesheet" href="/resources/css/admin.css?v=123">
<link rel="stylesheet" href="/resources/css/bootstrap.min.css">

<div class="container">
	<h1>Administrator menu | <?= $__user__->email ?></h1>
	<form>
		<h2>Select table</h2>
		<select name="table" id="table-select">
			<option value="ProductEntity">products</option>
			<option value="OrderEntity">orders</option>
			<option value="UserEntity">users</option>
			<option value="BrandEntity">brands</option>
			<option value="ImageEntity">images_storage</option>
		</select>
		<div class="super-button" id="save-changes-button">Save changes</div>
		<div class="super-button" id="add-row-button">Add row</div>
	</form>

	<table class="table table-striped table-bordered" id="table" style="margin-bottom: 10%">
		<thead class="thead-dark">
		<tr id="table-head">

		</tr>
		</thead>
		<tbody id="table-body">

		</tbody>
	</table>

</div>

<script type="text/javascript" src="/resources/js/admin.js?v=<?= $refresh ?>" defer></script>