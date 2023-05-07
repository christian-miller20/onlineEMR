<?php
session_start();

if (isset($_SESSION["username"])) {
        echo $_SESSION["username"];
}
else {
        header("Location: http://3.95.80.50:8005/");
        exit;
}
?>
