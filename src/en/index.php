<?php

	setcookie('lang', 'en', time() + (86400 * 30), '/');

	$last_act = isset($_REQUEST['last_act']);
	if($last_act) $last_act = $_REQUEST['last_act'];

	include '../alert.php';

	session_start();

	// include '../connection.php';
	// include '../functions.php';

	// $routes = array();

	// $sql = "SELECT `username`,`telephone`,`route__start`,`route_point_1`,`route_point_2`,`route_point_3` FROM `users` WHERE NOT `route__start` IS NULL";
	// $result = $conn->query($sql);

	// if ($result->num_rows > 0) {
	// 	$routes = $result->fetch_assoc();
	// } else {
	// 	res_err(lang() == 'en' ? 'Could not establish database connection' : 'Nie udało się połączyć z bazą danych', 'index');
	// }

	// $routes = json_encode($routes, JSON_UNESCAPED_UNICODE);

	// echo $routes; exit();

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	<link href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<link rel="icon" href="../res/paderewski_logo.png" type="image/png" sizes="64x64">

	<title>Dojazdy Paderewski</title>

	<link rel="stylesheet" type="text/css" href="../index.css?v=6">

	<meta name="description" content="dojazdy paderewski">

	<style>
		.fullscreen {
			width: 100vw;
			height: 100vh;
			position: fixed;
			left: 0;
			top: 0;
		}

		/*.gm-ui-hover-effect {display: none;}*/
	</style>

	<script src="map.js?v=9" defer></script>
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

					<li class="lang btn-li">
						<a href="../pl/">
							<img src="../res/poland-icon.png" style="height: 1.5em;" alt="[PL]">
						</a>
					</li>

					<li class="active lang btn-li">
						<a href="#">
							<img src="../res/great-britain-icon.png" style="height: 1.5em;" alt="[EN]">
						</a>
					</li>
					
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
							<!-- <?php var_dump($_SESSION['me']); ?> -->
							<!--
								starting point
								3 points between
								? show my route
							-->
							<li>
								<div class="row">
									<div class="col-md-12">
										<form class="form" role="form" method="post" action="../edit_route.php" accept-charset="UTF-8">
											<div class="form-group">
												<label class="err" hidden>Must be a valid phone number</label>
												<input
												type="text"
												autocomplete="off"
												class="form-control"
												placeholder="Starting point"
												required
												name="route__start"
												id="route__start"
												<?php
													if(isset($_SESSION['me']['route__start'])) if($_SESSION['me']['route__start'])
														echo 'value="'.$_SESSION['me']['route__start'].'"';
												?>>
											</div>
											<div class="form-group">
												<label class="err" hidden>Must be a valid phone number</label>
												<input
												type="text"
												autocomplete="off"
												class="form-control"
												placeholder="Point 1"
												name="route_point_1"
												id="route_point_1"
												<?php
													if(isset($_SESSION['me']['route_point_1'])) if($_SESSION['me']['route_point_1'])
														echo 'value="'.$_SESSION['me']['route_point_1'].'"';
												?>>
											</div>
											<div class="form-group">
												<label class="err" hidden>Must be a valid phone number</label>
												<input
												type="text"
												autocomplete="off"
												class="form-control"
												placeholder="Point 2"
												name="route_point_2"
												id="route_point_2"
												<?php
													if(isset($_SESSION['me']['route_point_2'])) if($_SESSION['me']['route_point_2'])
														echo 'value="'.$_SESSION['me']['route_point_2'].'"';
												?>>
											</div>
											<div class="form-group">
												<label class="err" hidden>Must be a valid phone number</label>
												<input
												type="text"
												autocomplete="off"
												class="form-control"
												placeholder="Point 3"
												name="route_point_3"
												id="route_point_3"
												<?php
													if(isset($_SESSION['me']['route_point_3'])) if($_SESSION['me']['route_point_3'])
														echo 'value="'.$_SESSION['me']['route_point_3'].'"';
												?>>
											</div>
											<div class="form-group" id="login-submit-div">
												<button type="submit" class="btn btn-primary btn-block">Update</button>
											</div>
											<div class="form-group" id="login-submit-blocked-div" hidden>
												<button type="submit" class="btn btn-primary btn-block submit-blocked" id="login-submit-blocked">Update</button>
											</div>
										</form>
									</div>
								</div>
							</li>
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
												<input
												type="telephone"
												autocomplete="off"
												class="form-control"
												placeholder="Phone number"
												required
												name="telephone"
												id="login-telephone"
												<?php
													if(isset($_REQUEST['tel']) and $last_act == 'login')
														echo 'value="'.$_REQUEST['tel'].'"'
												?>>
											</div>
											<div class="form-group">
												<input
												type="password"
												class="form-control"
												placeholder="Password"
												required
												name="password"
												id="login-password">
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
												<label class="err" hidden>First names can only contain letters and must be between 3 and 20 letters long</label>
												<input
												type="text"
												autocomplete="off"
												class="form-control"
												placeholder="First Name"
												required
												name="first-name"
												id="signup-first-name"
												<?php
													if(isset($_REQUEST['first-name']) and $last_act == 'signup')
														echo 'value="'.$_REQUEST['first-name'].'"'
												?>>
											</div>
											<div class="form-group">
												<label class="err" hidden>Last names can only contain letters and must be between 3 and 20 letters long</label>
												<input
												type="text"
												autocomplete="off"
												class="form-control"
												placeholder="Last Name"
												required
												name="last-name"
												id="signup-last-name"
												<?php
													if(isset($_REQUEST['last-name']) and $last_act == 'signup')
														echo 'value="'.$_REQUEST['last-name'].'"'
												?>>
											</div>
											<div class="form-group">
												<label class="err" hidden>Must be a valid phone number</label>
												<input
												type="telephone"
												autocomplete="off"
												class="form-control"
												placeholder="Phone number"
												required
												name="telephone"
												id="signup-telephone"
												<?php
													if(isset($_REQUEST['tel']) and $last_act == 'signup')
														echo 'value="'.$_REQUEST['tel'].'"'
												?>>
											</div>
											<div class="form-group">
												<input
												type="password"
												class="form-control"
												placeholder="Password"
												required
												name="pass-1"
												id="signup-pass-1">
											</div>
											<div class="form-group">
												<label class="err" hidden>Passwords don't match</label>
												<input
												type="password"
												class="form-control"
												placeholder="Repeat Password"
												required
												name="pass-2"
												id="signup-pass-2">
											</div>
											<!-- <div class="form-group">
												<label>Tutor:</label>
											    <select name="tutor">
											    	<option></option>
											        <option>Marcin Boryc</option>
											    </select>
											    
											</div> -->
											<div class="form-group">
												<label class="err" hidden>Invalid number</label>
												<input type="text"
												class="form-control"
												placeholder="Identity Card Number"
												required
												name="id-card-nr"
												id="signup-id-card-nr">
											</div>
											<div class="checkbox">
												<label>
													<label class="err" hidden>You have to agree to sign up</label>
													<input
													type="checkbox"
													name="eula"
													id="signup-eula">I agree to <a href="../eula.html" target="blank_">the processing and displaying of my personal data</a>
												</label>
											</div>
											<div class="checkbox">
												<label>
													<label class="err" hidden>You have to agree to sign up</label>
													<input
													type="checkbox"
													name="is-parent"
													id="signup-is-parent">I am a parent of a student of MLO Paderewski Lublin <small>(you don't need to have an account in order to use this website as a student)</small>
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
								</div>
							</li>
						</ul>
					</li>

					<script src="../forms.js?v=5" id="script-forms" defer></script>

					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>

	<!-- 
	<?php

	if(isset($last_act))
		if(in_array($last_act, array('signup', 'login')))
			echo '<script>document.querySelector("button").onclick = e => { $("#li-'.$last_act.'").click(); }</script>';

	?>
	-->

	<?php if(isset($_REQUEST['success'])) { alert_modal('Success', htmlspecialchars($_REQUEST['success'], ENT_QUOTES, 'UTF-8'), 'success'); }?>

	<?php if(isset($_REQUEST['err'])) { alert_modal('Error', htmlspecialchars($_REQUEST['err'], ENT_QUOTES, 'UTF-8'), 'error'); }?>
	
</body>
</html>