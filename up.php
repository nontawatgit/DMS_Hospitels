<?php
	session_start();
    require("connect_db.php");
    if ($_SESSION['user_leve'] == "a"){
            header("Location: backup_sql/backup.php");
    } elseif ($_SESSION['user_leve'] != "a"){
        header("Location: index.php");
    }
?>