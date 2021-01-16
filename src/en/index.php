<?php

	setcookie('lang', 'en', time() + (86400 * 30), '/');

	$last_act = isset($_REQUEST['last_act']);
	if($last_act) $last_act = $_REQUEST['last_act'];

	include '../alert.php';

	session_start();

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<title>Dojazdy Paderewski</title>

	<script src="map.js"></script>

	<link rel="stylesheet" type="text/css" href="../index.css?v=5">

	<style>
		.fullscreen {
			width: 100vw;
			height: 100vh;
			position: fixed;
			left: 0;
			top: 0;
		}
	</style>
</head>
<body>

	<iframe src="map.php" class="fullscreen"></iframe>

	<nav class="navbar navbar-default navbar-inverse" role="navigation">
		<div class="container-fluid">
			
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only"><!-- Toggle navigation --></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="..">Dojazdy Paderewski</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<!-- <li class="active"><a href="#">Link</a></li> -->
					<!-- <li><a href="#">Link</a></li> -->
					<li class="dropdown btn-li">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Help<span class="caret">&nbsp;</span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
							<li class="divider"></li>
							<li><a href="#">One more separated link</a></li>
							<!--
								info
								all users

								---

								contact
								report issue
							 -->
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right">

					<li class="lang btn-li"><a href="../pl/"><img src="https://image.flaticon.com/icons/png/128/197/197529.png" style="height: 1.5em;" alt="[PL]"></a></li>
					<li class="active lang btn-li"><a href="#"><img src="https://image.flaticon.com/icons/png/128/197/197374.png" style="height: 1.5em;" alt="[EN]"></a></li>
					
					<li style="width: 2em;"><a href="#" style="pointer-events: none;"></a></li>

					<?php

						$logged_in = isset($_SESSION['me']);
						$is_mod = isset($_SESSION['me']);
						if($is_mod) $is_mod = ($_SESSION['me']['is_mod']);

						if($logged_in) {

						?>

						<li><small class="navbar-text">Logged In as <u><?php echo $_SESSION['me']['username']; ?></u></small></li>

						<?php

							if($is_mod) {

					?>

					<li class="dropdown btn-li">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: gold;"><b><u>Moderation</u></b><span class="caret"></span></a>
						<ul id="login-dp" class="dropdown-menu">
							<!-- 
								accts pending verification ( not verified / pending confirmation (sms sent) / verified )
							 -->
							<li>accounts pending verification: 0</li>
						</ul>
					</li>

					<?php

						}

					?>

					<li class="dropdown btn-li">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Edit Route</b><span class="caret"></span></a>
						<ul id="login-dp" class="dropdown-menu">
							<!--
								starting point
								3 points between
								? show my route
							-->
						</ul>
					</li>
					<li class="dropdown btn-li">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>My Account</b><span class="caret"></span></a>
						<ul id="login-dp" class="dropdown-menu">
							<!-- 
								profile pic
								delete acc
							 -->
						</ul>
					</li>
					<li class="btn-li"><a href="../logout.php" style="color: red;"><b>Log Out</b></a></li>

					<?php

						} else {

					?>
					<li class="dropdown btn-li">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="li-login"><b>Log In</b><span class="caret"></span></a>
						<ul id="login-dp" class="dropdown-menu">
							<li>
								<div class="row">
									<div class="col-md-12">
										<form class="form" role="form" method="post" action="../login.php" accept-charset="UTF-8">
											<div class="form-group">
												<label class="err" hidden>Must be a valid phone number</label>
												<input type="telephone" autocomplete="off" class="form-control" placeholder="Phone number" required name="telephone" id="login-telephone" <?php if(isset($_REQUEST['tel']) and $last_act == 'login') echo 'value="'.$_REQUEST['tel'].'"' ?>>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password" required name="password" id="login-password">
												<!-- <div class="help-block text-right"><a href="">Forgot the password?</a></div> -->
											</div>
											<div class="form-group" id="login-submit-div">
												<button type="submit" class="btn btn-primary btn-block">Log In</button>
											</div>
											<div class="form-group" id="login-submit-blocked-div" hidden>
												<button type="submit" class="btn btn-primary btn-block submit-blocked" id="login-submit-blocked">Log In</button>
											</div>
											<!-- <div class="checkbox">
												<label>
													<input type="checkbox">Remember Me
												</label>
											</div> -->
										</form>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<li class="dropdown btn-li">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="li-signup"><b>Sign Up</b><span class="caret"></span></a>
						<ul id="login-dp" class="dropdown-menu">
							<li>
								<div class="row">
									<div class="col-md-12">
										<form class="form" role="form" method="post" action="../signup.php" accept-charset="UTF-8" id="signup-form">
											<div class="form-group">
												<label class="err" hidden>Usernames can only contain letters and spaces and must be betwee 5 and 49 letters long</label>
												<input type="text" autocomplete="off" class="form-control" placeholder="User Name" required name="username" id="signup-username" <?php if(isset($_REQUEST['username']) and $last_act == 'signup') echo 'value="'.$_REQUEST['username'].'"' ?>>
											</div>
											<div class="form-group">
												<label class="err" hidden>Must be a valid phone number</label>
												<input type="telephone" autocomplete="off" class="form-control" placeholder="Phone number" required name="telephone" id="signup-telephone" <?php if(isset($_REQUEST['tel']) and $last_act == 'signup') echo 'value="'.$_REQUEST['tel'].'"' ?>>
											</div>
											<div class="form-group">
												<input type="password" class="form-control" placeholder="Password" required name="pass-1" id="signup-pass-1">
											</div>
											<div class="form-group">
												<label class="err" hidden>Passwords don't match</label>
												<input type="password" class="form-control" placeholder="Repeat Password" required name="pass-2" id="signup-pass-2">
											</div>
											<div class="form-group">
												<label>Tutor:</label>
											    <select name="tutor">
											    	<option></option>
											        <option>Marcin Boryc</option>
											    </select>
											    
											</div>
											<div class="checkbox">
												<label>
													<label class="err" hidden>You have to agree to sign up</label>
													<input type="checkbox" name="eula" id="signup-eula">I agree to <a href="../eula.html" target="blank_">the processing and displaying of my personal data</a>
												</label>
											</div>
											<div class="checkbox">
												<label>
													<label class="err" hidden>You have to agree to sign up</label>
													<input type="checkbox" name="is-parent" id="signup-is-parent">I am a parent of a student of MLO Paderewski Lublin <small>(you don't need to have an account in order to use this website as a student)</small>
												</label>
											</div>
											<div class="form-group" id="signup-submit-div">
												<button type="submit" class="btn btn-primary btn-block" name="submit" id="signup-submit">Sign Up</button>
											</div>
											<div class="form-group" id="signup-submit-blocked-div" hidden>
												<button type="submit" class="btn btn-primary btn-block submit-blocked" id="signup-submit-blocked">Sign Up</button>
											</div>
										</form>
									</div>

									<!-- <?php
										if(isset($last_act) and isset($_REQUEST['err']))
											if($last_act === 'signup') {
									?>

									<div class="bottom text-center err">
										<b>
											<?php echo $_REQUEST['err']; ?>
										</b>
									</div>

									<?php } ?> -->

								</div>
							</li>
						</ul>
					</li>

					<script src="../forms.js?v=1" id="script-forms" defer></script>

					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>

	<!-- <?php

	if(isset($last_act))
		if(in_array($last_act, array('signup', 'login')))
			echo '<script>document.querySelector("button").onclick = e => { $("#li-'.$last_act.'").click(); }</script>';

	?> -->

	<?php if(isset($_REQUEST['success'])) { alert_modal('Success', htmlspecialchars($_REQUEST['success'], ENT_QUOTES, 'UTF-8'), 'success'); }?>

	<?php if(isset($_REQUEST['err'])) { alert_modal('Error', htmlspecialchars($_REQUEST['err'], ENT_QUOTES, 'UTF-8'), 'error'); }?>
	
</body>
</html>