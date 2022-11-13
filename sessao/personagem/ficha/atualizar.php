<?php
$con = con();
$success = true;
if ($edit) {
    if (isset($_POST['status'])) {
        switch ($_POST['status']) {
            case 'addarma':
                $n = cleanstring($_POST["nome"],$limite_nome_inv);
                $t = cleanstring($_POST["tipo"],$Arma_tipo);
                $at = cleanstring($_POST["ataque"],$Arma_crit);
                $al = cleanstring($_POST["alcance"],$Arma_alca);
                $d = cleanstring($_POST["dano"],$Arma_dano);
                $c = cleanstring($_POST["critico"],$Arma_crit);
                $m = minmax($_POST["margem"],1,20);
                $r = cleanstring($_POST["recarga"],$Arma_reca);
                $e = cleanstring($_POST["especial"],$Arma_espe);
	            $desc = cleanstring($_POST["desc"],$Inv_desc);
	            $peso = minmax($_POST["peso"], $minimo_peso, $maximo_peso, $inv_float);
	            $pres = minmax($_POST["prestigio"], 0,10);//Categorias
                $rr = $con->prepare("INSERT INTO `armas`(`id_ficha`,`arma`,`tipo`,`ataque`,`alcance`,`dano`,`critico`, `margem`,`recarga`,`especial`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
                $rr->bind_param("issssssiss", $id, $n, $t, $at, $al, $d, $c, $m, $r, $e);
                $rr->execute();
                if ($_POST["opc"] == 'addinvtoo') {
                    $p = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`nome`,`descricao`,`prestigio`,`espaco`,`id`) VALUES ( ?, ?, ?, ?, ?, '');");
                    $p->bind_param("issid", $id, $n, $desc, $pres, $peso);
                    $p->execute();
                }
                if ($con->affected_rows) {
                    $msg = "Sucesso ao adicionar itens";
                }
                break;
            case 'addd':
                $nome = cleanstring($_POST["nome"],$Dado_nome);
                $dado = cleanstring($_POST["dado"],$Dado_nome);
                $foto = minmax(intval($_POST["icone"]),0,13);
                $dano = ($_POST["dano"]=='on' or $_POST["dano"] == 1);
                if(empty($nome)){$nome = $dado;}
                $y = $con->prepare("INSERT INTO `dados_ficha`(`nome`,`foto`,`dado`,`dano`,`id_ficha`) VALUES ( ? , ? , ? , ? , ?);");
                $y->bind_param("sisii",$nome,$foto,$dado,$dano,$id);
                $y->execute();
                break;
            case 'additem':
                $nome = cleanstring($_POST["nome"],$limite_nome_inv);
                $desc = cleanstring($_POST["descricao"],$Inv_desc);
                $peso = minmax($_POST["peso"], $minimo_peso,$maximo_peso,$inv_float);
                $quantidade = minmax($_POST["quantidade"], 0,$maximo_peso);
                $pres = minmax($_POST["prestigio"],0,10);
                $rr = $con->prepare("INSERT INTO `inventario`(`id_ficha`,`nome`,`descricao`,`espaco`,`prestigio`,`quantidade`) VALUES ( ? , ? , ? , ? , ?, ?)");
                $rr->bind_param("issiii", $id, $nome, $desc, $peso, $pres,$quantidade);
                $rr->execute();
                break;
            case 'addhab':
                $habname = cleanstring($_POST["hab"],$Hab_nome);
                $habdesc = cleanstring($_POST["desc"],$Hab_desc);
                if (isset($_POST["poder"]) AND ($_POST["poder"] == 1 || $_POST["poder"] == "on")){
                    $a = $con->prepare ("INSERT INTO `poderes` (`id_ficha`, `nome`, `descricao`) VALUES ( ? , ? , ? );");
                } else {
                    $a = $con->prepare("INSERT INTO `habilidades` (`id_ficha`, `nome`, `descricao`) VALUES ( ? , ? , ? );");
                }
                $a->bind_param("iss",$id,$habname,$habdesc);
                $a->execute();
                break;
            case 'addpro':
                $pronome = cleanstring($_POST["pro"],$Pro_nome);
				$t = $con->prepare("INSERT INTO `proeficiencias`(`id_ficha`,`nome`) VALUES (?,?);");
				$t->bind_param("is",$id,$pronome);
				$t->execute();
                break;
            case 'addritual':
                $foto = cleanstring($_POST["simbolourl"]);

                $ritual = cleanstring($_POST["ritual"],$Ritu_nome);
                $cir = cleanstring($_POST["circulo"],$Ritu_circ);
                $conj = cleanstring($_POST["conjuracao"],$Ritu_conj);
                $ele = cleanstring($_POST["elemento"],$Ritu_elem);
                $efe = cleanstring($_POST["efeito"],$Ritu_efei);
                $dur = cleanstring($_POST["duracao"],$Ritu_dura);
                $alc = cleanstring($_POST["alcance"],$Ritu_alca);
                $alv = cleanstring($_POST["alvo"],$Ritu_alvo);
                $res = cleanstring($_POST["resistencia"],$Ritu_resi);
                $d1 = cleanstring($_POST["dano1"],$Ritu_dan);
                $d2 = cleanstring($_POST["dano2"],$Ritu_dan);
                $d3 = cleanstring($_POST["dano3"],$Ritu_dan);
                $rr = $con->prepare("INSERT INTO `rituais`(
                      `foto`,`id_ficha`,`nome`,`circulo`,
                      `conjuracao`,`efeito`,`elemento`,`duracao`,`alcance`,
                      `resistencia`, `alvo`,`dano`,`dano2`,`dano3`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)");
                $rr->bind_param("sissssssssssss", $foto, $id, $ritual, $cir, $conj, $efe, $ele, $dur, $alc, $res, $alv, $d1, $d2,$d3);
                $rr->execute();
                break;
            case 'editattr':
				$forca = minmax($_POST["forca"], $minimo_atributo, $maximo_atributo);
				$agilidade = minmax($_POST["agilidade"], $minimo_atributo, $maximo_atributo);
				$intelecto = minmax($_POST["intelecto"], $minimo_atributo, $maximo_atributo);
				$presenca = minmax($_POST["presenca"], $minimo_atributo, $maximo_atributo);
				$vigor = minmax($_POST["vigor"], $minimo_atributo, $maximo_atributo);
				$con->query("UPDATE `fichas_personagem` SET `forca` = '$forca', `agilidade` = '$agilidade',`inteligencia` = '$intelecto',`presenca` = '$presenca',`vigor` = '$vigor' WHERE `id` = '$id';");
                break;
            case 'editarma':
                $aid = intval($_POST["did"]);
                $n = cleanstring($_POST["nome"],$limite_nome_inv);
                $t = cleanstring($_POST["tipo"],$Arma_tipo);
                $at = cleanstring($_POST["ataque"],$Arma_ataq);
                $al = cleanstring($_POST["alcance"],$Arma_alca);
                $d = cleanstring($_POST["dano"],$Arma_dano);
                $c = cleanstring($_POST["critico"],$Arma_crit);
                $m = minmax($_POST["margem"],1,20);
                $r = cleanstring($_POST["recarga"],$Arma_reca);
                $e = cleanstring($_POST["especial"],$Arma_espe);
                $rr = $con->prepare("UPDATE `armas` SET `arma` = ?, `tipo` = ?, `ataque` = ?, `alcance` = ?, `dano` = ?, `critico` = ?, `margem` = ?, `recarga` = ?, `especial` = ? WHERE `armas`.`id` = ? AND `id_ficha` = '$id';;");
                $rr->bind_param("ssssssissi", $n, $t, $at, $al, $d, $c, $m, $r, $e, $aid);
                $rr->execute();
                $success = $rr;
                break;
            case 'editd':
                $nome = cleanstring($_POST["nome"],$Dado_nome);
                $dadod = cleanstring($_POST["dado"],$Dado_dado);
                $dano = ($_POST["dano"]=='on' or $_POST["dano"] == 1);
                $foto = minmax(intval($_POST["icone"]),0,13);
                $did = intval($_POST["did"]);
                if(empty($nome)){$nome = $dadod;}
                $y = $con->prepare("UPDATE `dados_ficha` SET `nome` = ?, `dado` = ?, `foto` = ?, `dano` = ? where `id` = ? AND `id_ficha` = ?;");
                $y->bind_param("ssiiii", $nome, $dadod, $foto, $dano, $did, $id);
                $y->execute();
                break;
            case 'editdet':
                $fotos = intval($_POST["foto"]);
	            if ($fotos == 9) {
		            if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_POST["fotourl"]))) {
			            $urlphoto = cleanstring($_POST["fotourl"], $Fich_fotos);
		            }
		            if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_POST["fotomor"]))) {
			            $fotomor = cleanstring($_POST["fotomor"], $Fich_fotos);
		            }
		            if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_POST["fotofer"]))) {
			            $fotofer = cleanstring($_POST["fotofer"], $Fich_fotos);
		            }
		            if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_POST["fotoenl"]))) {
			            $fotoenl = cleanstring($_POST["fotoenl"], $Fich_fotos);
		            }
		            if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp|gif)$/', cleanstring($_POST["fotoef"]))) {
			            $fotoef = cleanstring($_POST["fotoef"], $Fich_fotos);
		            }
	            } else {
		            switch ($fotos) {
			            default:
				            $urlphoto = 'https://fichasop.com/assets/img/Man.webp';
				            break;
			            case 2:
				            $urlphoto = 'https://fichasop.com/assets/img/Woman.webp';
				            break;
			            case 3:
				            $urlphoto = 'https://fichasop.com/assets/img/Mauro.webp';
				            break;
			            case 4:
				            $urlphoto = 'https://fichasop.com/assets/img/Maya.webp';
				            break;
			            case 5:
				            $urlphoto = 'https://fichasop.com/assets/img/Bruna.webp';
				            break;
			            case 6:
				            $urlphoto = 'https://fichasop.com/assets/img/Leandro.webp';
				            break;
			            case 7:
				            $urlphoto = 'https://fichasop.com/assets/img/Jaime.webp';
				            break;
			            case 8:
				            $urlphoto = 'https://fichasop.com/assets/img/Aniela.webp';
				            break;
		            }
					$fotomor = $fotoenl = $fotofer = $urlphoto;
	            }
                $nex = minmax($_POST["nex"], 0, 100);
                $pp = minmax($_POST["pp"], 0, 99999999);//pontos de prestigio

                $origem = cleanstring($_POST["origem"]);
                $trilha = cleanstring($_POST["trilha"]);
                $classe = cleanstring($_POST["classe"]);
                $elemento = cleanstring($_POST["elemento"]);
                $patente = cleanstring($_POST["patente"]);



                $desco = minmax($_POST["deslocamento"],0,50);
                $per = minmax($_POST["pr"],0,127);
                $idade = minmax($_POST["idade"],0,150);
                $local = cleanstring($_POST["local"],$Fich_loca);


	            if(preg_match('/^[a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙçÇ]*$/', cleanstring($_POST["nome"]))){
					$nome = cleanstring($_POST["nome"]);
	            }

                $rr = $con->prepare("UPDATE `fichas_personagem` SET `foto` = ? , `nome` = ? , `afinidade` = ? , `nex` = ?, `pe_rodada` = ?, `pp` = ? ,
                               `classe` = ? , `trilha` = ? , `origem` = ? , `patente` = ? , `idade` = ?, `deslocamento` = ? ,
                               `local` = ? , `foto_morrendo` = ?, `foto_enlouquecendo` = ?, `foto_ferido` = ?, `foto_ferenl` = ?
                           WHERE `id` = '$id';");
                $rr->bind_param("sssiiissssiisssss",  $urlphoto,$nome, $elemento, $nex, $per, $pp, $classe, $trilha, $origem, $patente, $idade, $desco, $local, $fotomor, $fotoenl, $fotofer,$fotoef);
                $rr->execute();
                exit;
                break;
            case 'edititem':
                $iid = intval($_POST["did"]);
                $nome = cleanstring($_POST["nome"],$limite_nome_inv);
                $desc = cleanstring($_POST["descricao"],$Inv_desc);
                $peso = minmax($_POST["peso"],$minimo_peso,$maximo_peso, $inv_float);
                $pres = minmax($_POST["prestigio"],0,10);
                $rr = $con->prepare("UPDATE `inventario` SET `nome` = ? , `descricao` = ?, `espaco` = ?, `prestigio` = ? WHERE `inventario`.`id` = ? AND `id_ficha` = '$id';;");
                $rr->bind_param("ssdii", $nome, $desc, $peso, $pres, $iid);
                $rr->execute();
                $success = $rr;
                break;
            case 'edithab':
                for($i = 0; $i < count($_POST["nome"]); ++$i):
                    $nome = cleanstring($_POST['nome'][$i],$Hab_nome);
                    $desc = cleanstring($_POST['desc'][$i],$Hab_desc);
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
                $acr = minmax($_POST["acrobacias"], $minimo_pericia, $maximo_pericia);
                $ade = minmax($_POST["adestramento"], $minimo_pericia, $maximo_pericia);
                $art = minmax($_POST["artes"], $minimo_pericia, $maximo_pericia);
                $atl = minmax($_POST["atletismo"], $minimo_pericia, $maximo_pericia);
                $atu = minmax($_POST["atualidades"], $minimo_pericia, $maximo_pericia);
                $cie = minmax($_POST["ciencia"], $minimo_pericia, $maximo_pericia);
                $cri = minmax($_POST["crime"], $minimo_pericia, $maximo_pericia);
                $dip = minmax($_POST["diplomacia"], $minimo_pericia, $maximo_pericia);
                $eng = minmax($_POST["enganacao"], $minimo_pericia, $maximo_pericia);
                $fort = minmax($_POST["fortitude"], $minimo_pericia, $maximo_pericia);
                $fur = minmax($_POST["furtividade"], $minimo_pericia, $maximo_pericia);
                $inic = minmax($_POST["iniciativa"], $minimo_pericia, $maximo_pericia);
                $inti = minmax($_POST["intimidacao"], $minimo_pericia, $maximo_pericia);
                $intu = minmax($_POST["intuicao"], $minimo_pericia, $maximo_pericia);
                $inv = minmax($_POST["investigacao"], $minimo_pericia, $maximo_pericia);
                $lut = minmax($_POST["luta"], $minimo_pericia, $maximo_pericia);
                $med = minmax($_POST["medicina"], $minimo_pericia, $maximo_pericia);
                $ocu = minmax($_POST["ocultismo"], $minimo_pericia, $maximo_pericia);
                $perc = minmax($_POST["percepcao"], $minimo_pericia, $maximo_pericia);
                $pilo = minmax($_POST["pilotagem"], $minimo_pericia, $maximo_pericia);
                $pont = minmax($_POST["pontaria"], $minimo_pericia, $maximo_pericia);
                $prof = minmax($_POST["profissao"], $minimo_pericia, $maximo_pericia);
                $ref = minmax($_POST["reflexo"], $minimo_pericia, $maximo_pericia);
                $rel = minmax($_POST["religiao"], $minimo_pericia, $maximo_pericia);
                $sob = minmax($_POST["sobrevivencia"], $minimo_pericia, $maximo_pericia);
                $tat = minmax($_POST["tatica"], $minimo_pericia, $maximo_pericia);
                $tec = minmax($_POST["tecnologia"], $minimo_pericia, $maximo_pericia);
                $von = minmax($_POST["vontade"], $minimo_pericia, $maximo_pericia);
				$q = $con->prepare("UPDATE `fichas_personagem` SET 
                               `acrobacias` = ?, `adestramento` = ?, `artes` = ?, `atletismo` = ?, `atualidades` = ?,
                               `ciencia` = ?, `crime` = ?, `diplomacia` = ?, `enganacao` = ?, `fortitude` = ?,
                               `furtividade` = ?, `intimidacao` = ?, `iniciativa` = ?, `intuicao` = ?, `investigacao` = ?,
                               `luta` =?, `medicina` =?, `ocultismo` =?, `percepcao` =?, `pilotagem` =?,
                               `pontaria` =?, `profissao`= ?,`reflexos`= ?, `religiao`= ?, `sobrevivencia`= ?,
                               `tatica`= ?, `tecnologia`= ?, `vontade`= ? WHERE `id` = ?;");
                $q->bind_param("iiiiiiiiiiiiiiiiiiiiiiiiiiiii", $acr,$ade,$art,$atl,$atu, $cie,$cri,$dip,$eng,$fort, $fur,$inti,$inic,$intu,$inv, $lut,$med,$ocu,$perc,$pilo, $pont,$prof,$ref,$rel,$sob, $tat,$tec,$von,$id);
                $q->execute();
				break;
            case 'editpers':
                $historia = cleanstring($_POST["historia"],$Fich_hist);
                $encontro = cleanstring($_POST["encontro"],$Fich_prim);
                $aparencia = cleanstring($_POST["aparencia"],$Fich_apar);
                $medos = cleanstring($_POST["medos"],$Fich_medo);
                $pesadelo = cleanstring($_POST["pesadelo"],$Fich_pesa);
                $frase = cleanstring($_POST["frases"],$Fich_fras);
                $favoritos = cleanstring($_POST["favoritos"],$Fich_favo);
                $anotacoes = cleanstring($_POST["anotacoes"],$Fich_note);
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
                $pv = minmax((int)$_POST["pv"], $minimo_PV, $maximo_PV);
                if ($pv == 1) {
                    $pv = calcularvida($nex, $rqs["classe"], $rqs["vigor"], $rqs["trilha"], $rqs["origem"]);
                    if($pva < ($pv + $maximo_PVA)){
                        $pva = $pv;
                    }
                }

	            $san = minmax((int)$_POST["san"], $minimo_SAN, $maximo_SAN);
	            if($san == 1){
		            $san = calcularsan($nex,$rqs["classe"],$rqs["trilha"],$rqs["origem"]);
                    if($sana < ($san + $maximo_SANA)){
                        $sana = $san;
                    }
	            }

                $pe = minmax((int)$_POST["pe"], $minimo_PE, $maximo_PE);
                if ($pe == 1) {
                    $pe = calcularpe($nex, $rqs["classe"], $rqs["presenca"], $rqs["trilha"], $rqs["origem"]);
                    if($pea < ($pe + $maximo_PEA)){
                        $pea = $pe;
                    }
                }


                //Defesas
                $pa = minmax((int)$_POST["passiva"]);
                $es = minmax((int)$_POST["esquiva"]);
                $bl = minmax((int)$_POST["bloqueio"]);
                //Resistencias
                $fisi = minmax((int)$_POST["fisica"],$minimo_resistencia,$maximo_resistencia);
                $bali = minmax((int)$_POST["balistica"],$minimo_resistencia,$maximo_resistencia);
                $fogo = minmax((int)$_POST["fogo"],$minimo_resistencia,$maximo_resistencia);


                $mort = minmax((int)$_POST["morte"],$minimo_resistencia,$maximo_resistencia);
                $sang = minmax((int)$_POST["sangue"],$minimo_resistencia,$maximo_resistencia);
                $conh = minmax((int)$_POST["conhecimento"],$minimo_resistencia,$maximo_resistencia);
                $ener = minmax((int)$_POST["energia"],$minimo_resistencia,$maximo_resistencia);
                $ment = minmax((int)$_POST["mental"],$minimo_resistencia,$maximo_resistencia);


                $cort = minmax((int)$_POST["corte"],$minimo_resistencia,$maximo_resistencia);
                $impa = minmax((int)$_POST["impacto"],$minimo_resistencia,$maximo_resistencia);
                $elet = minmax((int)$_POST["eletricidade"],$minimo_resistencia,$maximo_resistencia);
                $frio = minmax((int)$_POST["frio"],$minimo_resistencia,$maximo_resistencia);
                $perf = minmax((int)$_POST["perfuracao"],$minimo_resistencia,$maximo_resistencia);
                $quim = minmax((int)$_POST["quimico"],$minimo_resistencia,$maximo_resistencia);

                $b = $con->prepare("UPDATE `fichas_personagem` SET 
                               `passiva`= ?, `esquiva` = ?, bloqueio = ?,`mental` = ?,`fisica`= ?,`balistica` = ?,
                               `fogo`= ?,`morte`= ?, `sangue` = ?,`conhecimento`= ?,`energia` = ?, 
                               `perfuracao` = ?,`eletricidade`= ?, `frio` = ?,`impacto` = ?,`corte` = ?,
                               `pea` = ?, `pe` = ?,`san` = ?, `sana` = ?, `quimico` = ?, `pv` = ?, `pva` = ?
                          		WHERE `id` = ?;");
				$b->bind_param("iiiiiiiiiiiiiiiiiiiiiiii",$pa,$es,$bl,$ment,$bali,$fisi,$fogo,$mort,$sang,$conh,$ener,$perf,$elet,$frio,$impa,$cort,$pea,$pe,$san,$sana,$quim,$pv,$pva,$id);
				$b->execute();
                break;
            case 'editpro':
				for($i = 0; $i < count($_POST['did']); $i++):
                    $pro = cleanstring($_POST["pro"][$i],$Pro_nome);
                    $pid = intval($_POST["did"][$i]);
					$q = $con->prepare("UPDATE `proeficiencias` SET `nome` = ? WHERE `id_ficha` = ? AND `id` = ?;");
					$q->bind_param("sii",$pro,$id,$pid);
					$q->execute();
                endfor;
                break;
            case 'editritual':
                for($c = 0 ; $c < count($_POST['did']); $c++):;
                    $did = intval($_POST["did"][$c]);
                    $foto = intval($_POST["foto"][$c]);
                    if ($foto == 2){ $foto = cleanstring($_POST["simbolourl"][$did],$Fich_fotos);} else {
                        switch ($foto) {
                            default:
                                $foto = 'https://fichasop.com/assets/img/desconhecido.webp';
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
                    $ritual = cleanstring($_POST["ritual"][$c],$Ritu_nome);
                    $cir = cleanstring($_POST["circulo"][$c],$Ritu_circ);
                    $conj = cleanstring($_POST["conjuracao"][$c],$Ritu_conj);
                    $ele = cleanstring($_POST["elemento"][$c],$Ritu_elem);
                    $efe = cleanstring($_POST["desc"][$c],$Ritu_efei);
                    $dur = cleanstring($_POST["duracao"][$c],$Ritu_dura);
                    $alc = cleanstring($_POST["alcance"][$c],$Ritu_alca);
                    $res = cleanstring($_POST["resistencia"][$c],$Ritu_resi);
                    $alvo = cleanstring($_POST["alvo"][$c],$Ritu_alvo);
                    $d1 = cleanstring($_POST["dano1"][$c],$Ritu_dan);
                    $d2 = cleanstring($_POST["dano2"][$c],$Ritu_dan);
                    $d3 = cleanstring($_POST["dano3"][$c],$Ritu_dan);
                    $rr = $con->prepare("UPDATE `rituais` SET  
                     `nome` = ?, `foto` = ? , `circulo` = ? , `conjuracao` = ? , `efeito` = ? ,
                     `elemento` = ? , `duracao` = ? , `alcance` = ?, `resistencia` = ? , `alvo` = ?,
                     `dano` = ? ,`dano2` = ?, `dano3` = ? WHERE `id_ficha` = ? AND `id` = ? ;");
                    $rr->bind_param("sssssssssssssii", $ritual, $foto, $cir, $conj, $efe, $ele, $dur, $alc, $res, $alvo, $d1, $d2, $d3, $id, $did);
                    $rr->execute();
                endfor;
                break;
            case 'delarma':
                $aid = intval($_POST["did"]);
                $a = $con->query("DELETE FROM `armas` WHERE `armas`.`id` = '$aid' AND `id_ficha` = '$id';");
                break;
            case 'deld':
                $did = cleanstring($_POST["did"]);
                $y = $con->prepare("DELETE FROM `dados_ficha` WHERE `id` = ? AND `id_ficha` = ?;");
                $y->bind_param("ii",$did,$id);
                $y->execute();
                break;
            case 'peso_inv':
                $did = minmax($_POST["peso"],1,99);
                $y = $con->prepare("UPDATE fichas_personagem SET peso_inv = ? WHERE id = ?;");
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
				$dado = DadoDinamico(cleanstring($_POST["dado"], 50),$dc);				$dano = intval(minmax($_POST["dano"],0,1));
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
				$mor = minmax($_POST["mor"],0,1);


                $pv =  minmax(($_POST["pv"]),1,$maximo_PV);

                $pva = minmax(($_POST["pva"]),-99,$maximo_PV);




                $san = minmax(($_POST["san"]),0,$maximo_SAN);
                $sana =minmax(($_POST["sana"]),0,$maximo_SAN);
                $pe =  minmax(($_POST["pe"]),0,$maximo_PE);
                $pea = minmax(($_POST["pea"]),0,$maximo_PE);





                if($pv == 1){
					$pv = calcularvida($rqs["nex"],$rqs["classe"],$vigor,$rqs["trilha"],$rqs["origem"]);
				}
                if($san == 1){
					$san = calcularsan($rqs["nex"],$rqs["classe"],$rqs["trilha"],$rqs["origem"]);
				}
                if($pe == 1) {
					$pe = calcularpe($rqs["nex"],$rqs["classe"],$presenca,$rqs["trilha"],$rqs["origem"]);
				}
                if($pva > ($pv+$maximo_PVA)){$pva = $pv+$maximo_PVA;}
                if($sana > ($san+$maximo_SANA)){$sana = $san+$maximo_SANA;}
                if($pea > ($pe + $maximo_PEA)){$pea = $pe + $maximo_PEA;}
                if($pva < $minimo_PVA){$pva = $minimo_PVA;}
                if($sana < $minimo_SANA){$sana = $minimo_SANA;}
                if($pea < $minimo_PEA){$pea = $minimo_PEA;}
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
	        case 'deletar':
				$type = cleanstring($_POST["type"]);
				$tid  = intval($_POST["tip"]);
				switch ($type){
					case "arma":
						$hid = intval($_POST["did"]);
						$con->query("DELETE FROM `habilidades` WHERE `habilidades`.`id` = '$hid' AND `id_ficha` = '$id';");
						break;
					case "habilidade":
						break;
				}
				break; // BETA
        }
    }
}

