<?php
require "./../config/config.php";
session_start();
session_write_close();
set_time_limit(6000);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 6000);
ignore_user_abort(true);


function s()
{
    $err = error_get_last();
    file_put_contents("test.txt", $err["message"]);

}

register_shutdown_function('s');

if ($_GET["start"] == 1) {
    $c = con();

    $a = $c->query("SELECT id,foto,foto_enlouquecendo,foto_ferenl,foto_ferido,foto_morrendo FROM fichas_personagem");
    $b = $c->query("SELECT id,marca FROM usuarios");

    $c->close();
    $dir = ROOT . "assets/users";
    //  $fotosfichas = $a->fetch_assoc();
    $fotosficha = $a->fetch_all(2);
    $fotosuser = $b->fetch_all(2);

    $arquivos = scandir($dir);

    $hashes = [];
    $duplicates = [];

    $a = count($arquivos);

    $i = apcu_fetch("index");
    $duplicates = apcu_fetch("hashes");
    var_dump($duplicates);
    echo $i;
    //apcu_store("index", 0);
    //apcu_store("hashes", []);
    //apcu_store("duplicates", []);
    for ($i = apcu_fetch("index"); $i < $a; $i++) {
        $arquivo = $arquivos[$i];
        try {

            if ($arquivo != "." && $arquivo != "..") {
                $local = $dir . "/" . $arquivo;
                if (touch($local)) {
                    $hash = md5_file($local);
                    $hashes = apcu_fetch("hashes");
                    if (!array_key_exists($hash, $hashes)) {
                        $hashes[$hash] = $local;
                        apcu_store("hashes", $hashes);
                    } else {
                        apcu_store("hasduplicated", true);

                        $duplicates = apcu_fetch("duplicates");

                        $duplicates[] = [$hash, $local];
                        apcu_store("duplicates", $duplicates);

                    }
                }
            }
        } catch (Exception $e) {

        }
        apcu_store("index", $i);
    }

    file_put_contents("test.txt", json_encode([$hashes, $duplicates]));
    exit();


}