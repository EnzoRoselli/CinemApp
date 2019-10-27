<?php

namespace Views;




//require 'app/fb_init.php';

?>



<?php if (isset($message)) {
	foreach ($message as $value) {
		echo "<p> $value </p>";
	}
} ?>


<body class="login-body">
	<h1>CinemApp</h1>
	<div class="login-container" id="container">
		<div class="form-container sign-up-container">
			<form action="<?php echo FRONT_ROOT . "/User/createUser" ?>" method="POST" class="login-form">
				<h2>Create Account</h2>
				<div class="social-container">
					<!-- <a href="#" class="social"><i class="fab fa-facebook-f"></i></a> -->

				</div>
				<!-- <span>or use your email for registration</span> -->
				<input class="imput-login" name="SignupName" type="text" placeholder="Name" />
				<input class="imput-login" name="SignupLastName" type="text" placeholder="Last Name" />
				<input class="imput-login" name="SignupDNI" type="text" placeholder="ID Number" />
				<input class="imput-login" name="SignupEmail" type="email" placeholder="Email" />
				<input class="imput-login" name="SignupPassword" type="SignupPassword" placeholder="Password" />
				<button class="login-button">Sign Up</button>
			</form>
		</div>
		<div class="form-container sign-in-container">
			<form action="<?php echo FRONT_ROOT . "/User/loginAction" ?>" method="POST" class="login-form">
				<h2>Log in</h2>
				<!-- <div class="social-container"> -->

				<?php
				/*	if (isset($_SESSION['facebook_access_token'])) {
					$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
					try {
						$response = $fb->get('/me');
						$userNode = $response->getGraphUser();
					} catch (Facebook\Exceptions\FacebookResponseException $e) {
						echo "graph returned an error: " . $e->getMessage();
						exit;
					} catch (Facebook\Exceptions\FacebookSDKException $e) {
						echo "SDK returned an error: " . $e->getMessage();
						exit;
					}
					echo "Logged in as " . $userNode->getName();
					session_start();
					$_SESSION['loggedUser']=$userNode->getName();
					header("Location: ../views/home.php");
					echo '<br/> <a href="logout.php"> Log out</a>';
				} else {
					$helper = $fb->getRedirectLoginHelper();
					$permissions = []; // Optional permissions
					$loginUrl = $helper->getLoginUrl('http://localhost/Final-Tp-Lab4/Final-Tp-Lab4/Proyecto/Login/login-callback.php', $permissions);

					echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
				}*/ ?>

				<!-- </div> -->
				<span class="login-span">or use your account</span>
				<input class="imput-login" name="LoginEmail" type="LoginEmail" placeholder="Email" />
				<input class="imput-login" name="LoginPassword" type="LoginPassword" placeholder="Password" />
				<a href="ForgotPassword.html" class="login-a">Forgot your password?</a>
				<button class="login-button">Log In</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h2>Welcome Back!</h2>
					<p class="login-p">To keep connected with us please login with your info</p>
					<button class="ghost" id="signIn">Sign In</button>
				</div>
				<div class="overlay-panel overlay-right">
					<h2>Hello!</h2>
					<p class="login-p">Enter your personal details and welcome to CinemApp</p>
					<button class="ghost login-button" id="signUp">Sign Up</button>
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
	<script src=<?php echo "js/scripts.js" ?>></script>
</body>