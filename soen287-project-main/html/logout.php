<?php
// Snippet from https://stackoverflow.com/questions/12209438/logout-button-php
session_start();
unset($_SESSION);
session_destroy();
session_write_close();
header('Location: login.php');
die;
?>