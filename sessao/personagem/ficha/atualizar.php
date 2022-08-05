<?php
$con = con();
$success = true;
error_reporting(E_ERROR | E_PARSE);
if ($edit) {
    if (isset($_POST['status'])) {
        switch ($_POST['status']) {
            case 'addarma':
                $n = test_input($_POST["nome"],$Arma_nome);
                $t = test_input($_POST["tipo"],$Arma_tipo);
                $at = test_input($_POST["ataque"],$Arma_crit);
                $al = test_input($_POST["alcance"],$Arma_alca);
                $d = test_input($_POST["dano"],$Arma_dano);
                $c = test_input($_POST["critico"],$Arma_crit);
                $m = test_input($_POST["margem"],$Arma_crit);
                $r = test_input($_POST["recarga"],$Arma_reca);
                $e = test_input($_POST["especial"],$Arma_espe);
	            $desc = test_input($_POST["desc"],$Inv_desc);
	            $peso = minmax($_POST["peso"],-50,50);
	            $pres = minmax($_POST["prestigio"],-50,50);
                $rr = $con->prepare("INSERT INTO `armas`(`id_ficha`,`arma`,`tipo`,`ataque`,`alcance`,`dano`,`critico`, `margem`,`recarga`,`especial`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
                $rr->bind_param("issssssiss", $id, $n, $t, $at, $al, $d, $c, $m, $r, $e);
                $rr->execute();
                if ($_POST["opc"] == 'addinvtoo') {
                    $p = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`nome`,`descricao`,`prestigio`,`espaco`,`quantidade`,`id`) VALUES ( ?, ?, ?, ?, ?, 1, '');");
                    $p->bind_param("issii", $id, $n, $desc, $pres, $peso);
                    $p->execute();
                }
                if ($con->affected_rows) {
                    $msg = "Sucesso ao adicionar itens";
                }
                break;
            case 'addd':
                $nome = test_input($_POST["nome"],$Dado_nome);
                $dadod = test_input($_POST["dado"],$Dado_nome);
                $foto = minmax(intval($_POST["icone"]),0,13);
                $dano = intval(($_POST["dano"]=='on' or $_POST["dano"] == 1)?1:0);
                if(empty($nome)){
                    $nome = $dadod;
                }
                $y = $con->prepare("INSERT INTO `dados_ficha`(`nome`,`foto`,`dado`,`dano`,`id_ficha`) VALUES ( ? , ? , ? , ? , ?);");
                $y->bind_param("sisii",$nome,$foto,$dadod,$dano,$id);
                $y->execute();
                break;
            case 'additem':
                $nome = test_input($_POST["nome"],$Inv_nome);
                $desc = test_input($_POST["descricao"],$Inv_desc);
                $peso = minmax($_POST["peso"],-50,50);
                $pres = minmax($_POST["prestigio"],-50,50);
                $rr = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`nome`,`descricao`,`espaco`,`prestigio`) VALUES ( ? , ? , ? , ? , ?)");
                $rr->bind_param("issii", $id, $nome, $desc, $peso, $pres);
                $rr->execute();
                break;
            case 'addhab':
                $habname = test_input($_POST["hab"],$Hab_nome);
                $habdesc = test_input($_POST["desc"],$Hab_desc);
                if (isset($_POST["poder"]) AND ($_POST["poder"] == 1 || $_POST["poder"] == "on")){
                    $a = $con->prepare ("INSERT INTO `poderes` (`id_ficha`, `nome`, `descricao`) VALUES ( ? , ? , ? );");
                } else {
                    $a = $con->prepare("INSERT INTO `habilidades` (`id_ficha`, `nome`, `descricao`) VALUES ( ? , ? , ? );");
                }
                $a->bind_param("iss",$id,$habname,$habdesc);
                $a->execute();

                break;
            case 'addpro':
                $pronome = test_input($_POST["pro"],$Pro_nome);
                //$prodesc = test_input($_POST["desc"]);
                $con->query("INSERT INTO `proeficiencias` (`id`, `id_ficha`, `nome`) VALUES (NULL, '" . $id . "', '" . $pronome . "');");
                $success = $con->affected_rows;
                break;
            case 'addritual':
                $foto = intval($_POST["foto"]);
                if ($foto == 2) {
                    $foto = test_input($_POST["simbolourl"]);
                }
                switch ($foto){
                    default:
                        $foto = 'https://fichasop.com/assets/img/desconhecido.png';
                        break;
                    case 3:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Amaldicoar_Tecnologia.webp';
                        break;
                    case 4:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Assombracao_Forcada.webp';
                        break;
                    case 5:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Camuflagem.webp';
                        break;
                    case 6:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Cicatrizacao_Acelerada.webp';
                        break;
                    case 7:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Coincidencia_Forcada.webp';
                        break;
                    case 8:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Compreensao_Paranormal.webp';
                        break;
                    case 9:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Comunicacao_com_Espiritos.webp';
                        break;
                    case 10:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_da_Dama_de_Sangue.webp';
                        break;
                    case 11:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_decadenzia.webp';
                        break;
                    case 12:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Derreter_Criaturas_De_Sangue.webp';
                        break;
                    case 13:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Descarnar.webp';
                        break;
                    case 14:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Destruicao.webp';
                        break;
                    case 15:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Dissipar_Espiritos.webp';
                        break;
                    case 16:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Invocar_Nevoa.webp';
                        break;
                    case 17:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Leitura_Psiquica.webp';
                        break;
                    case 18:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_odio_Incontrolavel.webp';
                        break;
                    case 19:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Papel_Graduacao.webp';
                        break;
                    case 20:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Paralisia_Anormal.webp';
                        break;
                    case 21:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Passagem_de_Conhecimento.webp';
                        break;
                    case 22:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Pavor_Anormal.webp';
                        break;
                    case 23:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Reacao.webp';
                        break;
                    case 24:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Ritual_Espelho.webp';
                        break;
                    case 25:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Sentir_Atraves_dois_em_um.webp';
                        break;
                    case 26:
                        $foto = 'https://fichasop.com/assets/img/Simbolo_Sugada_Mortal.webp';
                        break;
                    case 27:
                        $foto = 'https://fichasop.com/assets/img/simbolo_transcender.webp';
                        break;
                }
                $ritual = test_input($_POST["ritual"],$Ritu_nome);
                $cir = test_input($_POST["circulo"],$Ritu_circ);
                $conj = test_input($_POST["conjuracao"],$Ritu_conj);
                $ele = test_input($_POST["elemento"],$Ritu_elem);
                $efe = test_input($_POST["efeito"],$Ritu_efei);
                $dur = test_input($_POST["duracao"],$Ritu_dura);
                $alc = test_input($_POST["alcance"],$Ritu_alca);
                $alv = test_input($_POST["alvo"],$Ritu_alvo);
                $res = test_input($_POST["resistencia"],$Ritu_resi);
                $d1 = test_input($_POST["dano1"],$Ritu_dan1);
                $d2 = test_input($_POST["dano2"],$Ritu_dan2);
                $rr = $con->prepare("INSERT INTO `rituais`(`id`,`foto`,`id_ficha`,`nome`,`circulo`,`conjuracao`,`efeito`,`elemento`,`duracao`,`alcance`,`resistencia`, `alvo`,`dano`,`dano2`) VALUES ('', ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? )");
                $rr->bind_param("sisssssssssss", $foto, $id, $ritual, $cir, $conj, $efe, $ele, $dur, $alc, $res, $alv, $d1, $d2);
                $rr->execute();
                break;
            case 'editattr':
                if ($edit) {
                    $forca = minmax($_POST["forca"], -10, 10);
                    $agilidade = minmax($_POST["agilidade"], -10, 10);
                    $intelecto = minmax($_POST["intelecto"], -10, 10);
                    $presenca = minmax($_POST["presenca"], -10, 10);
                    $vigor = minmax($_POST["vigor"], -10, 10);
                    $con->query("UPDATE `fichas_personagem` SET `forca` = '$forca', `agilidade` = '$agilidade',`inteligencia` = '$intelecto',`presenca` = '$presenca',`vigor` = '$vigor' WHERE `id` = '$id';");
                }
                break;
            case 'editarma':
                $aid = intval($_POST["did"]);
                $n = test_input($_POST["nome"],$Arma_nome);
                $t = test_input($_POST["tipo"],$Arma_tipo);
                $at = test_input($_POST["ataque"],$Arma_ataq);
                $al = test_input($_POST["alcance"],$Arma_alca);
                $d = test_input($_POST["dano"],$Arma_dano);
                $c = test_input($_POST["critico"],$Arma_crit);
                $m = minmax($_POST["margem"],0,50);
                $r = test_input($_POST["recarga"],$Arma_reca);
                $e = test_input($_POST["especial"],$Arma_espe);
                $rr = $con->prepare("UPDATE `armas` SET `arma` = ?, `tipo` = ?, `ataque` = ?, `alcance` = ?, `dano` = ?, `critico` = ?, `margem` = ?, `recarga` = ?, `especial` = ? WHERE `armas`.`id` = ? AND `id_ficha` = '$id';;");
                $rr->bind_param("ssssssissi", $n, $t, $at, $al, $d, $c, $m, $r, $e, $aid);
                $rr->execute();
                $success = $rr;
                break;
            case 'editd':
                $nome = test_input($_POST["nome"],$Dado_nome);
                $dadod = test_input($_POST["dado"],$Dado_dado);
                $dano = ($_POST["dano"]=='on' or $_POST["dano"] == 1)?1:0;
                $foto = minmax(intval($_POST["icone"]),0,13);
                $did = intval($_POST["did"]);
                if(empty($nome)){
                    $nome = $dadod;
                }
                $y = $con->prepare("UPDATE `dados_ficha` SET `nome` = ?, `dado` = ?, `foto` = ?, `dano` = ? where `id` = ? AND `id_ficha` = ?;");
                $y->bind_param("ssiiii", $nome, $dadod, $foto, $dano, $did, $id);
                $y->execute();
                break;
            case 'editdet':
                $fotos = intval($_POST["foto"]);
	            if ($fotos == 9) {
		            if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', test_input($_POST["fotourl"]))) {
			            $urlphoto = test_input($_POST["fotourl"], $Fich_fotos);
		            }
		            if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', test_input($_POST["fotomor"]))) {
			            $fotomor = test_input($_POST["fotomor"], $Fich_fotos);
		            }
		            if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', test_input($_POST["fotofer"]))) {
			            $fotofer = test_input($_POST["fotofer"], $Fich_fotos);
		            }
		            if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', test_input($_POST["fotoenl"]))) {
			            $fotoenl = test_input($_POST["fotoenl"], $Fich_fotos);
		            }
	            } else {
		            switch ($fotos) {
			            default:
				            $urlphoto = 'https://fichasop.com/assets/img/Man.png';
				            break;
			            case 2:
				            $urlphoto = 'https://fichasop.com/assets/img/Woman.png';
				            break;
			            case 3:
				            $urlphoto = 'https://fichasop.com/assets/img/Mauro%20-%20up%20.png';
				            break;
			            case 4:
				            $urlphoto = 'https://fichasop.com/assets/img/Maya%20-%20Upscale.png';
				            break;
			            case 5:
				            $urlphoto = 'https://fichasop.com/assets/img/Bruna%20-%20Upscale.png';
				            break;
			            case 6:
				            $urlphoto = 'https://fichasop.com/assets/img/Leandro%20-%20Upscale.png';
				            break;
			            case 7:
				            $urlphoto = 'https://fichasop.com/assets/img/Jaime%20-%20Upscale.png';
				            break;
			            case 8:
				            $urlphoto = 'https://fichasop.com/assets/img/Aniela%20-%20Upscale.png';
				            break;
		            }
					$fotomor = $fotoenl = $fotofer = $urlphoto;
	            }
                $nex = minmax($_POST["nex"], 0, 100);
                $pp = minmax($_POST["pp"], 0, 999999);
                $origem = minmax($_POST["origem"], 0, 26);
                $trilha = minmax($_POST["trilha"],0,5);
                $classe = minmax($_POST["classe"], 0, 3);
                $patente = minmax($_POST["patente"], 0, 5);
                $desco = minmax($_POST["deslocamento"],0,50);
                $idade = minmax($_POST["idade"],0,150);
                $local = test_input($_POST["local"],$Fich_loca);

				$elemento = minmax($_POST["elemento"],0,5);

	            if(preg_match('/^[a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙçÇ]*$/', test_input($_POST["nome"]))){
					$nome = test_input($_POST["nome"]);
	            }

                $rr = $con->prepare("UPDATE `fichas_personagem` SET `foto` = ? , `nome` = ? , `afinidade` = ? , `nex` = ?, `pp` = ? , `classe` = ? , `trilha` = ? , `origem` = ? , `patente` = ? , `idade` = ?, `deslocamento` = ? , `local` = ? , `foto_morrendo` = ?, `foto_enlouquecendo` = ?, `foto_ferido` = ? WHERE `id` = '$id';");
                $rr->bind_param("ssiiiiiiiiissss",  $urlphoto,$nome, $elemento ,  $nex, $pp, $classe, $trilha, $origem, $patente, $idade, $desco, $local, $fotomor, $fotoenl, $fotofer);
                $rr->execute();
                break;
            case 'edititem':
                $iid = intval($_POST["did"]);
                $nome = test_input($_POST["nome"],$Inv_nome);
                $desc = test_input($_POST["descricao"],$Inv_desc);
                $peso = minmax($_POST["peso"],-50,50);
                $pres = minmax($_POST["prestigio"],-50,50);
                $rr = $con->prepare("UPDATE `inventario` SET `nome` = ? , `descricao` = ?, `espaco` = ?, `prestigio` = ? WHERE `inventario`.`id` = ? AND `id_ficha` = '$id';;");
                $rr->bind_param("ssiii", $nome, $desc, $peso, $pres, $iid);
                $rr->execute();
                $success = $rr;
                break;
            case 'edithab':
                for($i = 0; $i < count($_POST["nome"]); ++$i):
                    $nome = test_input($_POST['nome'][$i],$Hab_nome);
                    $desc = test_input($_POST['desc'][$i],$Hab_desc);
                    $hid = intval($_POST['did'][$i]);
                    $p = intval($_POST['p'][$i]);
                    if ($p){
                        $a = $con->prepare("UPDATE `poderes` SET `nome` = ?, `descricao` = ? WHERE `id_ficha` = ? AND `id` = ? ;");
                    } else {
                        $a = $con->prepare("UPDATE `habilidades` SET `nome` = ?, `descricao` = ? WHERE `id_ficha` = ? AND `id` = ? ;");
                    }
                    $a->bind_param("ssii",$nome,$desc,$id,$hid);
                    $a->execute();
                endfor;
                break;
            case 'editper':
                $acr = minmax($_POST["acrobacias"], 0, 99);
                $ade = minmax($_POST["adestramento"], 0, 99);
                $art = minmax($_POST["artes"], 0, 99);
                $atl = minmax($_POST["atletismo"], 0, 99);
                $atu = minmax($_POST["atualidades"], 0, 99);
                $cie = minmax($_POST["ciencia"], 0, 99);
                $cri = minmax($_POST["crime"], 0, 99);
                $dip = minmax($_POST["diplomacia"], 0, 99);
                $eng = minmax($_POST["enganacao"], 0, 99);
                $fort = minmax($_POST["fortitude"], 0, 99);
                $fur = minmax($_POST["furtividade"], 0, 99);
                $inic = minmax($_POST["iniciativa"], 0, 99);
                $inti = minmax($_POST["intimidacao"], 0, 99);
                $intu = minmax($_POST["intuicao"], 0, 99);
                $inv = minmax($_POST["investigacao"], 0, 99);
                $lut = minmax($_POST["luta"], 0, 99);
                $med = minmax($_POST["medicina"], 0, 99);
                $ocu = minmax($_POST["ocultismo"], 0, 99);
                $perc = minmax($_POST["percepcao"], 0, 99);
                $pilo = minmax($_POST["pilotagem"], 0, 99);
                $pont = minmax($_POST["pontaria"], 0, 99);
                $pres = 0;
                $prof = minmax($_POST["profissao"], 0, 99);
                $ref = minmax($_POST["reflexo"], 0, 99);
                $rel = minmax($_POST["religiao"], 0, 99);
                $sob = minmax($_POST["sobrevivencia"], 0, 99);
                $tat = minmax($_POST["tatica"], 0, 99);
                $tec = minmax($_POST["tecnologia"], 0, 99);
                $von = minmax($_POST["vontade"], 0, 99);
                $con->query("UPDATE `fichas_personagem` SET 
                               `acrobacias`='$acr', 
                               `adestramento`='$ade', 
                               `artes`='$art', 
                               `atletismo`='$atl', 
                               `atualidades` = '$atu', 
                               `ciencia`='$cie', 
                               `crime`='$cri', 
                               `diplomacia`='$dip', 
                               `enganacao`='$eng', 
                               `fortitude`='$fort', 
                               `furtividade`='$fur', 
                               `intimidacao`='$inti', 
                               `iniciativa`='$inic', 
                               `intuicao`='$intu', 
                               `investigacao`='$inv', 
                               `luta`='$lut', 
                               `medicina`='$med', 
                               `ocultismo`='$ocu', 
                               `percepcao`='$perc', 
                               `pilotagem`='$pilo', 
                               `pontaria`='$pont', 
                               `profissao`='$prof',
                               `reflexos`='$ref', 
                               `religiao`='$rel', 
                               `sobrevivencia`='$sob', 
                               `tatica`='$tat', 
                               `tecnologia`='$tec', 
                               `vontade`='$von' 
                           WHERE `id` = '$id';");
                $success = $con->affected_rows;
                $msg = $con->affected_rows ? "Sucesso" : "Falha";
                break;
            case 'editpers':
                $historia = test_input($_POST["historia"],$Fich_hist);
                $encontro = test_input($_POST["encontro"],$Fich_prim);
                $aparencia = test_input($_POST["aparencia"],$Fich_apar);
                $medos = test_input($_POST["medos"],$Fich_medo);
                $pesadelo = test_input($_POST["pesadelo"],$Fich_pesa);
                $frase = test_input($_POST["frases"],$Fich_fras);
                $favoritos = test_input($_POST["favoritos"],$Fich_favo);
                $anotacoes = test_input($_POST["anotacoes"],$Fich_note);
                $a = $con->prepare("UPDATE `fichas_personagem` SET `historia`= ?, `aparencia` = ?,`medos` = ?, `pior_pesadelo` = ?, `frases` = ?, `favoritos` = ?, `anotacoes` = ?, `encontro` = ? WHERE `id` = ?;");
                $a->bind_param("ssssssssi",$historia,$aparencia,$medos,$pesadelo,$frase,$favoritos,$anotacoes,$encontro,$id);
                $a->execute();
                break;
            case 'editpri':
                $ra = $rqs;
	            $nex = $ra["nex"];
				if($rqs["nex"] == 99){
					$nex = 100;
				}
                //Saúde
                $pv = minmax(intval($_POST["pv"]), 1, 999);
                if ($pv == 1) $pv = calcularvida($nex, $rqs["classe"],$rqs["vigor"],$rqs["trilha"],$rqs["origem"]);

                $pe = minmax(intval($_POST["pe"]), 1, 999);
                if ($pe == 1) $pe = calcularpe($nex, $rqs["classe"], $rqs["presenca"],$rqs["trilha"],$rqs["origem"]);

                $san = minmax(intval($_POST["san"]), 1, 999);
	            if($san === 1){
					$san = calcularsan($nex,$rqs["classe"],$rqs["trilha"],$rqs["origem"]);
	            }
                //Defesas
                $pa = minmax(intval($_POST["passiva"]));
                $es = minmax(intval($_POST["esquiva"]));
                //Resistencias
                $fisi = minmax(intval($_POST["fisica"]));
                $bali = minmax(intval($_POST["balistica"]));
                $fogo = minmax(intval($_POST["fogo"]));


                $mort = minmax(intval($_POST["morte"]));
                $sang = minmax(intval($_POST["sangue"]));
                $conh = minmax(intval($_POST["conhecimento"]));
                $ener = minmax(intval($_POST["energia"]));
                $ment = minmax(intval($_POST["mental"]));


                $cort = minmax(intval($_POST["corte"]));
                $impa = minmax(intval($_POST["impacto"]));
                $elet = minmax(intval($_POST["eletricidade"]));
                $frio = minmax(intval($_POST["frio"]));
                $perf = minmax(intval($_POST["perfuracao"]));
                $quim = minmax(intval($_POST["quimico"]));

                $b = $con->query("UPDATE `fichas_personagem` SET 
                `passiva`= '$pa',`mental` = '$ment', `bloqueio` = '$bl',
                `esquiva` = '$es',`fisica`= '$fisi', `balistica` = '$bali',
                `fogo`='$fogo',`morte`= '$mort', `sangue` = '$sang',
                `conhecimento`= '$conh', `energia` = '$ener',
                `eletricidade`= '$elet', `frio` = '$frio',`impacto` = '$impa',`corte` = '$cort',
                `perfuracao`= '$perf', `quimico` = '$quim',
                `pv`= '$pv', `pva` = '$pv', `pe` = '$pe', `pea` = '$pe',
                `san` = '$san', `sana` = '$san' WHERE `id` = '$id';");

                break;
            case 'editpro':
				for($i = 0; $i < count($_POST['did']); $i++):
                    $pro = test_input($_POST["pro"][$i],$Pro_nome);
                    $pid = intval($_POST["did"][$i]);
                    $con->query("UPDATE `proeficiencias` SET `nome` = '$pro' WHERE `id_ficha` = '$id' AND `id` = '$pid';");
                endfor;
                break;
            case 'editritual':
                for($c = 0 ; $c < count($_POST['did']); $c++):;
                    $did = intval($_POST["did"][$c]);
                    $foto = intval($_POST["foto"][$c]);
                    if ($foto == 2){ $foto = test_input($_POST["simbolourl"][$did],$Fich_fotos);} else {
                        switch ($foto) {
                            default:
                                $foto = 'https://fichasop.com/assets/img/desconhecido.png';
                                break;
                            case 3:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Amaldicoar_Tecnologia.webp';
                                break;
                            case 4:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Assombracao_Forcada.webp';
                                break;
                            case 5:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Camuflagem.webp';
                                break;
                            case 6:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Cicatrizacao_Acelerada.webp';
                                break;
                            case 7:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Coincidencia_Forcada.webp';
                                break;
                            case 8:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Compreensao_Paranormal.webp';
                                break;
                            case 9:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Comunicacao_com_Espiritos.webp';
                                break;
                            case 10:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_da_Dama_de_Sangue.webp';
                                break;
                            case 11:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_decadenzia.webp';
                                break;
                            case 12:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Derreter_Criaturas_De_Sangue.webp';
                                break;
                            case 13:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Descarnar.webp';
                                break;
                            case 14:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Destruicao.webp';
                                break;
                            case 15:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Dissipar_Espiritos.webp';
                                break;
                            case 16:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Invocar_Nevoa.webp';
                                break;
                            case 17:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Leitura_Psiquica.webp';
                                break;
                            case 18:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_odio_Incontrolavel.webp';
                                break;
                            case 19:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Papel_Graduacao.webp';
                                break;
                            case 20:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Paralisia_Anormal.webp';
                                break;
                            case 21:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Passagem_de_Conhecimento.webp';
                                break;
                            case 22:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Pavor_Anormal.webp';
                                break;
                            case 23:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Reacao.webp';
                                break;
                            case 24:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Ritual_Espelho.webp';
                                break;
                            case 25:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Sentir_Atraves_dois_em_um.webp';
                                break;
                            case 26:
                                $foto = 'https://fichasop.com/assets/img/Simbolo_Sugada_Mortal.webp';
                                break;
                            case 27:
                                $foto = 'https://fichasop.com/assets/img/simbolo_transcender.webp';
                                break;
                        }
                    }
                    $ritual = test_input($_POST["ritual"][$c],$Ritu_nome);
                    $cir = test_input($_POST["circulo"][$c],$Ritu_circ);
                    $conj = test_input($_POST["conjuracao"][$c],$Ritu_conj);
                    $ele = test_input($_POST["elemento"][$c],$Ritu_elem);
                    $efe = test_input($_POST["desc"][$c],$Ritu_efei);
                    $dur = test_input($_POST["duracao"][$c],$Ritu_dura);
                    $alc = test_input($_POST["alcance"][$c],$Ritu_alca);
                    $res = test_input($_POST["resistencia"][$c],$Ritu_resi);
                    $alvo = test_input($_POST["alvo"][$c],$Ritu_alvo);
                    $d1 = test_input($_POST["dano1"][$c],$Ritu_dan1);
                    $d2 = test_input($_POST["dano2"][$c],$Ritu_dan2);
                    $rr = $con->prepare("UPDATE `rituais` SET  `nome` = ?, `foto` = ? , `circulo` = ? , `conjuracao` = ? , `efeito` = ? , `elemento` = ? , `duracao` = ? , `alcance` = ? , `alvo` = ?, `dano` = ? ,`dano2` = ? WHERE `id_ficha` = ? AND `id` = ? ;");
                    $rr->bind_param("sssssssssssii", $ritual, $foto, $cir, $conj, $efe, $ele, $dur, $alc, $alvo, $d1, $d2, $id, $did);
                    $rr->execute();
                endfor;
                break;
            case 'delarma':
                $aid = intval($_POST["did"]);
                $a = $con->query("DELETE FROM `armas` WHERE `armas`.`id` = '$aid' AND `id_ficha` = '$id';");
                break;
            case 'deld':
                $did = test_input($_POST["did"]);
                $y = $con->prepare("DELETE FROM `dados_ficha` WHERE `id` = ? AND `id_ficha` = ?;");
                $y->bind_param("ii",$did,$id);
                $y->execute();
                break;
            case 'delitem':
                $iid = intval($_POST["did"]);
                $con->query("DELETE FROM `inventario` WHERE `inventario`.`id` = '$iid' AND `id_ficha` = '$id';");
                break;
            case 'delethab':
                $hid = intval($_POST["did"]);
                $con->query("DELETE FROM `habilidades` WHERE `habilidades`.`id` = '$hid' AND `id_ficha` = '$id';");
                break;
            case 'deletpod':
                $pid = intval($_POST["did"]);
                $con->query("DELETE FROM `poderes` WHERE `poderes`.`id` = '$pid' AND `id_ficha` = '$id';");
                break;
            case 'deletpro':
                $pid = intval($_POST["did"]);
                $con->query("DELETE FROM `proeficiencias` WHERE `proeficiencias`.`id` = '$pid' AND `id_ficha` = '$id';");
                break;
            case 'deleteritual':
                $rid = intval($_POST["did"]);
                $con->query("DELETE FROM `rituais` WHERE `rituais`.`id` = '$rid' AND `id_ficha` = '$id';");
                echo $con->affected_rows;
                exit;
                break;
            case 'roll':
				$dado = DadoDinamico(test_input($_POST["dado"], 50),$forca,$agilidade,$intelecto,$presenca,$vigor);
				$dano = intval(minmax($_POST["dano"],0,1));
                if(ClearRolar($dado)) {
	                $data["success"] = true;
                    $data = RolarMkII($dado,$dano);
                } else {
	                $data = ClearRolar($dado,true);
                }
				$data["dado"] = $dado;
                echo json_encode($data);
                exit;
            case 'usau':
                $sq = $con->query("Select * From `fichas_personagem` where `id` = '$id';");
                $rs = mysqli_fetch_array($sq);
				$mor = minmax($_POST["mor"],0,1);
                $pv = minmax(intval($_POST["pv"]?:0),1,999);
                $pva = minmax(intval($_POST["pva"]?:0),-99,999);
                $san = minmax(intval($_POST["san"]?:0),1,999);
                $sana = minmax(intval($_POST["sana"]?:0),0,999);
                $pe = minmax(intval($_POST["pe"]?:0),1,999);
                $pea = minmax(intval($_POST["pea"]?:0),0,999);
                if($pv === 1){
					$pv = calcularvida($nex,$rqs["classe"],$vigor,$rqs["trilha"],$rqs["origem"]);
				}
                if($san === 1){
					$san = calcularsan($nex,$rqs["classe"],$rqs["trilha"],$rqs["origem"]);
				}
                if($pe === 1) {
					$pe = calcularpe($nex,$rqs["classe"],$presenca,$rqs["trilha"],$rqs["origem"]);
				}
                if($pva > ($pv+$maxpv)){$pva = $pv+$maxpv;}
                if($sana > ($san+$maxsan)){$sana = $san+$maxsan;}
                if($pea > ($pe + $maxpe)){$pea = $pe + $maxpe;}
                if($pva < $minpva){$pva = $minpva;}
                if($sana < $minsana){$sana = $minsana;}
                if($pea < $minpea){$pea = $minpea;}
                $fg = $con->prepare("UPDATE `fichas_personagem` SET `morrendo`= ? , `pv` = ?, `pva` = ?, `san` = ?, `sana` = ?, `pe` = ?, `pea` = ? where `id` = ?");
                $fg->bind_param("iiiiiiii",$mor,$pv,$pva,$san,$sana,$pe,$pea,$id);
                $fg->execute();
                $data = [];
                $data['pv'] = $pv;
                $data['pva'] = $pva;
                $data['san'] = $san;
                $data['sana'] = $sana;
                $data['pe'] = $pe;
                $data['pea'] = $pea;
                $data['mor'] = $mor;
                echo json_encode($data);
                exit;
                break;
        }
    }
}

