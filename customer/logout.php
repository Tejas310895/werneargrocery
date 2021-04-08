<?php 

session_start();

session_destroy();

setcookie("wrnuser", "", time() - 1);

echo "<script>window.open('../','_self')</script>";

?>