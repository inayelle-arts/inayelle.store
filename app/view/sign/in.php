<?php
$refresh = rand();
?>

<link rel="stylesheet" href="/resources/css/sign.css?v=<?= $refresh ?>">

<h1 id="sign-title">Sign in</h1>

<form action="#" id="login-form">
	
	<label for="login">Email</label>
	<input type="email" id="login" name="login" minlength="3" required>
	<label id="login-error" class="error" for="login" style=""></label>

	<label for="password" id="password-label">Password</label>
	<input type="password" id="password" name="password" minlength="6" required>
	<label id="password-error" class="error" for="password" style=""></label>
	
	<div class="text-button-muted" id="forgot-pass-button">forgot password?</div>
	
	<a href="/sign/up" id="another" class="text-button-muted">or create a new account</a>
	
	<div id="login-form-submit" class="super-button">Come in</div>
	
</form>

<form action="#" id="reset-form">

	<label for="reset-login">Email</label>
	<input type="email" id="reset-login" name="login" minlength="3" required>
	<div class="text-muted">We will send an email with reset confirmation</div>
	<label id="email-error" class="error" for="reset-login" style=""></label>

	<div class="text-button-muted" id="back-to-sign-in">back to sign in</div>
	
	<div id="reset-form-submit" class="super-button">Send confirmation</div>
	
</form>

<script type="text/javascript" src="/resources/js/jquery.validate.js" defer></script>
<script type="text/javascript" src="/resources/js/signin.js?v=<?= $refresh ?>" defer></script>