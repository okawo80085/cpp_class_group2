<?php
include('header.php');
if(isset($_GET['delete']))
	$con->prepare("DELETE FROM tasks WHERE id = ?")->execute(array($_GET['delete']));
$con->query("UPDATE tasks SET completed=2 WHERE completed=1 AND (UNIX_TIMESTAMP()-time)>300");
?>

	<div id="content">
		<form method="POST"><div id="content-content">
				<div id="content-header">
					<div id="content-title">
						<font color="#3498db">In Progress Tasks</font>
					</div>
				</div>

				<div id="content-box">
					<table>
						<th>ID</th>
						<th>Task</th>
						<th>HWID</th>
						<th>Created</th>
						<th></th>
						<?php printTasks(0); ?>
					</table>
				</div>
			</div>

			<div id="content-content">
				<div id="content-header">
					<div id="content-title">
						<font color="#f39c12">Running Tasks</font>
					</div>
				</div>

				<div id="content-box">
					<table>
						<th>ID</th>
						<th>Task</th>
						<th>HWID</th>
						<th>Created</th>
						<th></th>
						<?php printTasks(1); ?>
					</table>
				</div>
			</div>

			<div id="content-content">
				<div id="content-header">
					<div id="content-title">
						<font color="#40d47e">Completed Tasks</font>
					</div>
				</div>

				<div id="content-box">
					<table>
						<th>ID</th>
						<th>Task</th>
						<th>HWID</th>
						<th>Created</th>
						<th></th>
						<?php printTasks(2); ?>
					</table>
				</div>
			</div>

			<div id="content-footer">

			</div>
		</form>
	</div>
<script>regDelete();</script>
<?php
include('footer.php');
?>
