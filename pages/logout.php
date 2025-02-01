<?php
require 'session-check.php';

session_start();
session_destroy();
header("Location: login.php");
exit();
?>