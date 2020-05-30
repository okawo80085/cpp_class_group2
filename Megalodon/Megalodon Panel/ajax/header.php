<?php include('../inc/config.php'); ?>
<div id="online">
    <span class="green">Online:</span> <?php echo $con->query("SELECT COUNT(*) FROM bots WHERE (UNIX_TIMESTAMP()-time)<=20")->fetch()[0]; ?>
</div>

<div id="offline">
    <span class="red">Offline:</span> <?php echo $con->query("SELECT COUNT(*) FROM bots WHERE (UNIX_TIMESTAMP()-time)>20")->fetch()[0]; ?>
</div>

<div id="grey">
    <span class="grey">Dead:</span> <?php echo $con->query("SELECT COUNT(*) FROM bots WHERE (UNIX_TIMESTAMP()-time)>86400*$settings->deadline")->fetch()[0]; ?>
</div>

<div id="total">
    <span class="orange">Total:</span> <?php echo $con->query("SELECT COUNT(*) FROM bots")->fetch()[0]; ?>
</div>