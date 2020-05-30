<?php

include('inc/config.php');
include('inc/functions.php');

//Check if Authenticated
AuthenticatedCheck('LoggedIn');

?>
<html>
<head>
    <title>Register Panel</title>
	<link rel="shortcut icon" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/register.css" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
<form method="POST">
	<div id="box">
		<div id="box-header">
			<div id="box-title">
				Register Panel | Megalodon<span class="green">HTTP</span>
			</div>
		</div>
		
		<div id="box-content">
			<div id="box-strip">
				<div id="left">
					<div id="text">
						Username
					</div>
				</div>
				
				<div id="right">
					<input type="text" name="username" placeholder="John" />
				</div>
			</div>
			
			<div id="box-strip">
				<div id="left">
					<div id="text">
						Password
					</div>
				</div>
				
				<div id="right">
					<input type="password" name="password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
				</div>
			</div>
			
			<div id="box-strip">
				<div id="left">
					<div id="text">
						Re-Password
					</div>
				</div>
				
				<div id="right">
					<input type="password" name="repassword" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
				</div>
			</div>
			
			<div id="box-strip">
				<div id="login">
					<input type="submit" name="register" value="Register" />
				</div>
			</div>

			<div id="output">
				<?php Register(); ?>
			</div>
		</div>
	</div>
</form>
</div>
</body>
</html>
