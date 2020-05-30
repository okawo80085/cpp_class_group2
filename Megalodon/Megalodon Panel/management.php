<?php
include('header.php');
if($settings->super != $_SESSION['username']) header('Location: index.php');
if(isset($_GET['delete']))
    $con->prepare("DELETE FROM users WHERE id = ?")->execute(array($_GET['delete']));
$perpage = 10;
$init = isset($_GET['init']) && $_GET['init']%$perpage == 0 ? (int)$_GET['init'] : 0;
$end = isset($_GET['end']) && $_GET['end']%$perpage == 0 ? (int)$_GET['end'] : $perpage;
$users = $con->query("SELECT COUNT(*) FROM users")->fetch()[0];
?>

    <div id="content">
        <form method="POST" id="user-form">
            <div id="content-content">
                <div id="content-header">
                    <div id="content-title">
                        Users
                    </div>
                </div>

                <div id="content-box">
                    <table>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Access</th>
                        <th></th>
                        <th></th>
                        <?php printUsers($init,$perpage); ?>
                    </table>
                </div>
            </div>

            <div id="content-footer">
                <div id="navigation">
                    <ul>
                        <li><a href="management.php"><<</a></li>
                        <?php
                        for($i = $init - $perpage*10; $i <= $init + $perpage*10; $i+=$perpage) {
                            $pi = $i-$perpage;
                            $pe = $i;
                            $text = $i/$perpage;
                            if($text > 0 && $i - $perpage < $users) {
                                if ($init == $i-$perpage && $end == $i) $text = "<span class=\"green\">$text</span>";
                                echo "<li><a href=\"?init=$pi&end=$pe\">$text</a></li>";
                            }
                        }
                        $t = ((int)($users/$perpage)) * $perpage;
                        ?>
                        <li><a href="?init=<?php echo $t;?>&end=<?php echo $t + $perpage;?>">>></a></li>
                    </ul>
                </div>
            </div>

            <div id="content-content">
                <div id="content-header">
                    <div id="content-title">
                        Add New User
                    </div>
                </div>

                <div id="content-box">
                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Username
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="text" name="username" placeholder="John" />
                        </div>
                    </div>

                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Password
                            </div>
                        </div>

                        <div id="content-right">
                            <input type="password" name="password" placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" />
                        </div>
                    </div>

                    <div id="content-strip">
                        <div id="content-left">
                            <div id="left-text">
                                Access
                            </div>
                        </div>

                        <div id="content-right">
                            <select name="access">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>

                    <div id="content-strip2">
                        <div id="content-left">
                            <input type="hidden" name="id">
                            <input type="submit" name="action" value="Add User" />
                        </div>

                        <div id="content-right" class="user-result">
                            <!-- Output -->
                        </div>
                    </div>
                </div>
            </div>

            <div id="content-footer">

            </div>
        </form>
    </div>
<script>
    regDelete();
    regForm();
    regMod();
</script>
<?php
include('footer.php');
?>