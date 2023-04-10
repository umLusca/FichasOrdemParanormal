<?php
require_once "./../config/includes.php";
logout((int)$_SESSION["UserID"]);
header("X-Robots-Tag: none");
header("location: /");
