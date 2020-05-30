<?php
include('inc/config.php');
include('inc/functions.php');

//Logout Function
Logout();

//Check if Authenticated
AuthenticatedCheck('LoggedOut');

$_SERVER['PHP_SELF'] = basename($_SERVER['PHP_SELF']);

?>
<html>
<head>
	<title>MegalodonHTTP |
		<?php echo $_SERVER['PHP_SELF']=='index.php'?'Bots':ucfirst(basename($_SERVER["PHP_SELF"],'.php')); ?>
	</title>
	<link rel="shortcut icon" type="image/png" href="img/favicon.png" />
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">
    <link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="css/jquery-jvectormap-2.0.4.css" type="text/css" media="screen" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
	<?php if($_SERVER['PHP_SELF']=='index.php'): ?>
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript" src="js/botlist.js"></script>
	<?php elseif($_SERVER['PHP_SELF']=='tasks.php'): ?>
	<script type="text/javascript" src="js/tasks.js"></script>
	<?php elseif($_SERVER['PHP_SELF']=='management.php'): ?>
	<script type="text/javascript" src="js/manag.js"></script>
	<?php elseif($_SERVER['PHP_SELF']=='settings.php'): ?>
		<script type="text/javascript" src="js/settings.js"></script>
	<?php elseif($_SERVER['PHP_SELF']=='statistics.php'): ?>
		<script type="text/javascript" src="js/jquery-jvectormap-2.0.4.min.js"></script>
		<script type="text/javascript" src="js/jquery-jvectormap-world-mill-en.js"></script>
	<?php endif; ?>
</head>
<script>
	function getPvar(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function getHead(){
		$('#header-left').load('ajax/header.php');
	}

	setInterval(function(){ getHead(); }, 20000);
</script>
<body>
<div id="wrapper">
	<div id="header">
		<div id="header-title">
			Megalodon<span class="green">HTTP</span>
		</div>

		<div id="header-left">
		</div>
		<script>getHead();</script>
		
		<div id="header-right">
			<div id="name">
				Welcome, <?php echo $_SESSION['username']; ?>
			</div>
			<ul>
				<li><a href="?logout=1">Logout</a></li>
			</ul>
		</div>
	</div>

	<div id="menu">
		<ul>
			<li><a href="index.php" <?php echo $_SERVER["PHP_SELF"]=="index.php"?"class='current'":""; ?>><img src="img/1.png" width="18" height="18" class="icon"><span <?php echo $_SERVER["PHP_SELF"]=="index.php"?"class='green'":""; ?>>Bots</span></a></li>
			<li><a href="tasks.php" <?php echo $_SERVER["PHP_SELF"]=="tasks.php"?"class='current'":""; ?>><img src="img/2.png" width="18" height="18" class="icon"><span <?php echo $_SERVER["PHP_SELF"]=="tasks.php"?"class='green'":""; ?>>Tasks</span></a></li>
			<li><a href="statistics.php" <?php echo $_SERVER["PHP_SELF"]=="statistics.php"?"class='current'":""; ?>><img src="img/3.png" width="18" height="18" class="icon"><span <?php echo $_SERVER["PHP_SELF"]=="statistics.php"?"class='green'":""; ?>>Statistics</span></a></li>
			<?php if($settings->super == $_SESSION['username']): ?>
			<li><a href="settings.php" <?php echo $_SERVER["PHP_SELF"]=="settings.php"?"class='current'":""; ?>><img src="img/4.png" width="18" height="18" class="icon"><span <?php echo $_SERVER["PHP_SELF"]=="settings.php"?"class='green'":""; ?>>Settings</span></a></li>
			<li><a href="management.php" <?php echo $_SERVER["PHP_SELF"]=="management.php"?"class='current'":""; ?>><img src="img/5.png" width="18" height="18" class="icon"><span <?php echo $_SERVER["PHP_SELF"]=="management.php"?"class='green'":""; ?>>Management</span></a></li>
		    <?php endif; ?>
		    <li><a href="logs.php" <?php echo $_SERVER["PHP_SELF"]=="logs.php"?"class='current'":""; ?>><img src="img/6.png" width="18" height="18" class="icon"><span <?php echo $_SERVER["PHP_SELF"]=="logs.php"?"class='green'":""; ?>>Password Logs</span></a></li>
		</ul>
	</div>
