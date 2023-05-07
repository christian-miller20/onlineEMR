<?php

session_start();

session_destroy();

header("Location: http://3.95.80.50:8005/dashboard");
exit;
?>
