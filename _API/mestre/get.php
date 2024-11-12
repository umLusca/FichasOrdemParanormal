<?php
$npc = (int)$_POST["components"];

$ss = $con->prepare('SELECT * FROM fichas_npc WHERE id = ? AND missao in (SELECT id FROM missoes where token = ? AND mestre = ?);');
$ss->bind_param("isi", $npc, $token, $_SESSION["UserID"]);
$ss->execute();
$data = mysqli_fetch_array($ss->get_result());