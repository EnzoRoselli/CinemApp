<?php

namespace Views;


include('header.php');
include('nav.php');



//require 'app/fb_init.php';

?>



<?php if (isset($message)) {
	foreach ($message as $value) {
		echo "<p> $value </p>";
	}
} ?>

<body class="tuvieja">
	<div class="login-body">

	
	<h1>CinemApp</h1>
	<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form class="login-form" action=<?php echo FRONT_ROOT . "/User/createUser" ?> method="POST" class="login-form">
				<h2>Create Account</h2>
				<div class="social-container">
					<!-- <a href="#" class="social"><i class="fab fa-facebook-f"></i></a> -->

				</div>
				<span>or use your email for registration</span>
				<input class="input-login" name="SignupName" type="text" placeholder="Name" />
				<input class="input-login" name="SignupLastName" type="text" placeholder="Last Name" />
				<input class="input-login" name="SignupDNI" type="text" placeholder="ID Number" />
				<input class="input-login" name="SignupEmail" type="email" placeholder="Email" />
				<input class="input-login" name="SignupPassword" type="SignupPassword" placeholder="Password" />
				<button class="login-btn">Sign Up</button>
			</form>
		</div>
		<div class="form-container sign-in-container">
			<form class="login-form" action=<?php echo FRONT_ROOT . "/User/loginAction" ?> method="POST" class="login-form">
				<h2>Log in</h2>
				<div class="social-container">
					<!-- <a href="#" class="social"><i class="fab fa-facebook-f"></i></a> FIJARSE EL LOIGIN DE FB -->
				</div>
				<span>or use your account</span>
				<input class="input-login" type="LoginEmail" placeholder="Email" />
				<input class="input-login" type="LoginPassword" placeholder="Password" />
				<a class="login-a" href="ForgotPassword.html">Forgot your password?</a>
				<button class="login-btn">Log In</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="login-overlay">
				<div class="overlay-panel overlay-left">
					<h1>Welcome Back!</h1>
					<p class="login-p">To keep connected with us please login with your info</p>
					<button class="ghost login-btn" id="signIn">Sign In</button>
				</div>
				<div class="overlay-panel overlay-right">
					<h1>Hello!</h1>
					<p class="login-p">Enter your personal details and welcome to CinemApp</p>
					<button class="ghost login-btn" id="signUp">Sign Up</button>
				</div>
			</div>
		</div>
	</div>

	<!-- <footer> VER SI PODEMOS PONER ALGO PUBLICITARIO NOSE ALGO FLA
	<p>
		Created with <i class="fa fa-heart"></i> by
		<a target="_blank" href="https://florin-pop.com">Florin Pop</a>
		- Read how I created this and how you can join the challenge
		<a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
	</p>
</footer> -->

	<script src=<?php echo JS_PATH . "/login.js" ?>></script>
	</div>
</body>