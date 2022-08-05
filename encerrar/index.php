<?php
require_once "./../config/includes.php";
logout();
header("X-Robots-Tag: none");

echo "<script>window.location.href='/'</script>";
?>