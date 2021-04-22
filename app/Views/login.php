<!DOCTYPE html>
<html lang="en">
<head>
	<title>User Login</title>
	<?php include('header.php'); include('menu.php'); ?>
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
				<span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("Error")) echo session()->getFlashData("Error"); ?></span>
				<span style="text-align: center; color: red;font-size: x-large;"><?php if(session()->getFlashData("Success")) echo session()->getFlashData("Success"); ?></span>
				<form class="login100-form validate-form flex-sb flex-w" action="" method="post" >
					<span class="login100-form-title p-b-32"> User Login </span>

					<span class="txt1 p-b-11"> Email </span>
					<div class="wrap-input100 validate-input m-b-36" data-validate="Email is required">
						<input class="input100" type="text" name="email" value="">
						<span class="focus-input100"></span>						
						<span></span>
					</div>

					<span class="txt1 p-b-11"> Password </span>
					<div class="wrap-input100 validate-input m-b-12" data-validate="Password is required">
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
						<span></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn"> Login </button>
					</div>
				</form>
				<br>
				<?php 
					echo $googleButton;
				?>
			</div>
		</div>
	
    <?php include('footer.php'); ?>
