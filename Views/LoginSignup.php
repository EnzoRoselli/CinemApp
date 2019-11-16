<?php

namespace Views;


include('header.php');
include('nav.php');



//require 'app/fb_init.php';

?>

<?php if (!empty($message)) {

echo '<script type="text/javascript">
alert('. $message .');
</script>';  

}
 ?>

<body class="">
	<div class="login-body">

	<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form class="login-form" action=<?php echo FRONT_ROOT . "/User/createUser" ?> method="POST" class="login-form">
				<h2>Create Account</h2>
				<div class="social-container">
					<!-- <a href="#" class="social"><i class="fab fa-facebook-f"></i></a> -->

				</div>
				<span>or use your email for registration</span>
				<input class="input-login" name="SignupName" type="text"  placeholder="Nombre" pattern="[A-Za-z]{2,}" title="Debe contener más de 2 letras" required>
				<input class="input-login" name="SignupLastName" type="text" placeholder="Apellido" pattern="[A-Za-z]{2,}" title="Debe contener más de 2 letras" required>
				<input class="input-login" name="SignupDNI" type="text" placeholder="D.N.I" pattern="[0-9]{8,}" title="Solo se permiten numeros(minimo 8), sin espacios ni guiones" required>
				<input class="input-login" name="SignupEmail" type="email" placeholder="Email" required/>
				<input class="input-login" name="SignupPassword" type="SignupPassword" placeholder="Contraseña" required/>
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
				<input class="input-login" name="LoginEmail" type="text" value="<?php if(!empty($_POST['LoginEmail'])){ echo $_POST['LoginEmail']; } ?>" placeholder="Email" required/>
				<input class="input-login" name="LoginPassword" type="password" placeholder="Contraseña" required/>
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