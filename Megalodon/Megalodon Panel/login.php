<?php

include('inc/config.php');
include('inc/functions.php');

//Check if Authenticated
AuthenticatedCheck('LoggedIn');

?>
<html>
<head>
    <title>Login Panel | MegalodonHTTP</title>
	<link rel="shortcut icon" type="image/png" href="img/favicon.png" />
    <link rel="stylesheet" href="css/login.css" type="text/css" media="screen" />
</head>
<body>
<div id="wrapper">
<form method="POST">
	<div id="box">
		<div id="box-header">
			<div id="box-title">
				Login Panel | Megalodon<span class="green">HTTP</span>
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
				<div id="login">
					<input type="submit" name="login" value="Login" />
				</div>
			</div>

			<div id="output">
				<?php Login(); ?>
			</div>
		</div>
	</div>
</form>
</div>
</body>
</html>
