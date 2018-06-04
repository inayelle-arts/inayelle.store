<?php

$refresh = rand();
?>

<link rel="stylesheet" href="/resources/css/sign.css?v=<?= $refresh ?>">

<div class="container">
	<h1>Enter new password</h1>
	<form action="#" id="change-form">
		<input type="password" id="code" value="<?= $code ?>" style="display: none !important;">
		<input type="password" id="password" name="password" minlength="6">
		<label id="password-error" class="error" for="password" style=""></label>

		<div class="button" id="confirm-button">change password</div>
	</form>
</div>

<script type="text/javascript" src="/resources/js/jquery.validate.js" defer></script>
<script type="text/javascript" src="/resources/js/resetconfirm.js?v=<?= $refresh ?>" defer></script>
