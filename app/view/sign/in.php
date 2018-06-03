<?php

$refresh = rand();

?>

<link rel="stylesheet" href="/resources/css/sign.css?v=<?= $refresh ?>">

<h1>Sign in</h1>

<form action="#" id="form">
	<label for="login">Email</label>
	<input type="email" id="login" name="login" minlength="3" required>
	<label id="login-error" class="error" for="login" style=""></label>

	<label for="password" id="password-label">Password</label>
	<input type="password" id="password" name="password" minlength="6" required>
	<label id="password-error" class="error" for="password" style=""></label>
	
	<a href="/sign/up" id="another" class="text-button">or create a new account</a>
	<div id="sign-in-button" class="button">Come in</div>
</form>


<script type="text/javascript" src="/resources/js/jquery.validate.js" defer></script>
<script type="text/javascript" src="/resources/js/signin.js?v=<?= $refresh ?>" defer></script>