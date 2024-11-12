<?php
$user = checksession($session_id);
$a = $con->prepare("DELETE FROM user_tokens WHERE user_id = ? ;");
$a->bind_param("i", $user);
$a->execute();
