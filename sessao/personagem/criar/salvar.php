<?php
header("X-Robots-Tag: none");
require_once "./../../../config/includes.php";
$con = con();
/*
 * Armas->X
 * habilidades->X
 * Inventario->X
 * proficiencias->X
 * Principal->nome,origem,classe,nex,patente,idade,local,historia//
 * Atributos-> forca,agilidade,intelecto,presenca,vigor//
 * Defesas-> passiva,bloqueio,esquiva//
 * Resistencia->Sanidade,sangue,morte,energia,conhecimento,fisica,balistica//
 * Saude->PV,SAN,PE//
 */
$msg = [];
$sucesso = true;


if (isset($_SESSION["UserID"])) {
    $iduser = $_SESSION["UserID"];
    $convite = cleanstring($_POST["convite"] ?: $_GET["convite"]);
    if (!empty($_POST["nome"])) {
        $nome = cleanstring($_POST["nome"]);
        if (!preg_match('/^[a-zA-Z áéíóúãõàèìòùÁÉÍÓÚÃÕÀÈÌÒÙçÇ]*$/', $nome)) {
            $msg = "Apenas Letras e Espaços são permitidos no nome!";
            $sucesso = false;
        }
    } else {
        $sucesso = false;
        $msg = "Preencha o nome do seu personagem!";
    }
    $fotos = "https://fichasop.com/assets/img/Man.webp";
    $fotourl = cleanstring($_POST["fotourl"]);
    if ($fotos >= 1 and $fotos <= 9) {
        if ($fotos == 9) {
            if (preg_match('/^https?:\/\/(?:[a-z\-]+\.)+[a-z]{2,6}(?:\/[^\/#?]+)+\.(?:jpg|png|jpeg|webp)$/', $fotourl)) {
                $foto = $fotourl;
            }
        } else {
	        switch ($fotos) {
		        default:
			        $foto = 'https://fichasop.com/assets/img/Man.webp';
			        break;
		        case 2:
			        $foto = 'https://fichasop.com/assets/img/Woman.webp';
			        break;
		        case 3:
			        $foto = 'https://fichasop.com/assets/img/Mauro.webp';
			        break;
		        case 4:
			        $foto = 'https://fichasop.com/assets/img/Maya.webp';
			        break;
		        case 5:
			        $foto = 'https://fichasop.com/assets/img/Bruna.webp';
			        break;
		        case 6:
			        $foto = 'https://fichasop.com/assets/img/Leandro.webp';
			        break;
		        case 7:
			        $foto = 'https://fichasop.com/assets/img/Jaime.webp';
			        break;
		        case 8:
			        $foto = 'https://fichasop.com/assets/img/Aniela.webp';
			        break;
	        }
        }
    } else {
	    $foto = 'https://fichasop.com/assets/img/Man.webp';
    }
    $origem = cleanstring($_POST["origem"], 50);
    $classe = cleanstring($_POST["classe"], 50);
    $trilha = cleanstring($_POST["trilha"], 50);
    $nex = minmax($_POST["nex"],0,100);
    $patente = minmax($_POST["patente"], 0, 5);
    $idade = minmax($_POST["idade"],0,150);
    $local = cleanstring($_POST["local"]?:'');
    $historia = cleanstring($_POST["historia"]?:'');
    $forca = intval($_POST["forca"]);
    $agilidade = intval($_POST["agilidade"]);
    $intelecto = intval($_POST["intelecto"]);
    $presenca = intval($_POST["presenca"]);
    $vigor = intval($_POST["vigor"]);
    $pv = minmax($_POST["pv"], 1, 999);
    $san = minmax($_POST["san"], 1, 999);
    $pe = minmax($_POST["pe"], 1, 999);

    if ($pv == 1) {
        $pv = calcularvida($nex, $classe, $vigor,$trilha,$origem);
    }
    if ($san == 1) {
        $san = calcularsan($nex, $classe,$trilha,$origem);
	}

    if ($pe == 1) {
        $pe = calcularpe($nex, $classe, $presenca,$trilha,$origem);
    }

    $sangue = minmax($_POST["sangue"]);
    $morte = minmax($_POST["morte"]);
    $conhecimento = minmax($_POST["conhecimento"]);
    $energia = minmax($_POST["energia"]);
    $sanidade = minmax($_POST["sanidade"]);
    $fisico = minmax($_POST["fisico"]);
    $balistico = minmax($_POST["balistico"]);

    $acrobacia = minmax($_POST["acrobacia"]);
    $adestramento = minmax($_POST["adestramento"]);
    $artes = minmax($_POST["artes"]);
    $atletismo = minmax($_POST["atletismo"]);
    $atualidades = minmax($_POST["atualidades"]);
    $ciencia = minmax($_POST["ciencia"]);
    $crime = minmax($_POST["crime"]);
    $diplomacia = minmax($_POST["diplomacia"]);
    $enganacao = minmax($_POST["enganacao"]);
    $fortitude = minmax($_POST["fortitude"]);
    $furtividade = minmax($_POST["furtividade"]);
    $intimidacao = minmax($_POST["intimidacao"]);
    $intuicao = minmax($_POST["intuicao"]);
    $investigacao = minmax($_POST["investigacao"]);
    $iniciativa = minmax($_POST["iniciativa"]);
    $luta = minmax($_POST["luta"]);
    $medicina = minmax($_POST["medicina"]);
    $ocultismo = minmax($_POST["ocultismo"]);
    $percepcao = minmax($_POST["percepcao"]);
    $pilotagem = minmax($_POST["pilotagem"]);
    $pontaria = minmax($_POST["pontaria"]);
    $profissao = minmax($_POST["profissao"]);
    $reflexo = minmax($_POST["reflexo"]);
    $religiao = minmax($_POST["religiao"]);
    $sobrevivencia = minmax($_POST["sobrevivencia"]);
    $tatica = minmax($_POST["tatica"]);
    $tecnologia = minmax($_POST["tecnologia"]);
    $vontade = minmax($_POST["vontade"]);
    $passiva = minmax($_POST["passiva"]);
    $bloqueio = minmax($_POST["bloqueio"]);
    $esquiva = minmax($_POST["esquiva"]);



    switch ($origem) {
        default:
			break;
        case "Acadêmico": //Academico
            $habnam = "Saber é Poder (Origem)";
            $habdes = "Quando faz um teste usando Intelecto, você pode gastar 2 PE para receber +5 nesse teste.";
            $ciencia = $investigacao = 5;
            break;
        case "Agente de Saúde": // Agente de Sáudeo
            $habnam = "Técnicas Medicinais (Origem)";
            $habdes = "Sempre que você cura um personagem, você adiciona seu Intelecto no total de PV curados.";
            $intuicao = $medicina = 5;
            break;
        case "Amnésico":// Amnésico
            $habnam ='Vislumbres do Passado. (Origem)';
            $habdes =' Uma vez por missão, você pode fazer um teste de Intelecto (DT 10) para reconhecer pessoas ou lugares familiares, que tenha encontrado antes de perder a memória. Se passar, recebe 1d4 PE temporários e, a critério do mestre, uma informação útil.';
		break;
        case "Artista": // Artista
            $habnam = "Magnum Opus (Origem)";
            $habdes = "Você é famoso por uma de suas obras. Uma vez por missão, pode determinar que um personagem envolvido em uma cena de Interação o reconheça. Você recebe +5 em testes de Diplomacia, Enganação, Intuição e Intimidação contra aquele personagem. A critério do mestre, pode receber esses bônus em outras situações nas quais seria reconhecido.";
            $artes = $enganacao = 5;
            break;
        case "Atleta": // Atleta
            $habnam = "110% (Origem)";
            $habdes = "Quando faz um teste de perícia usando Força ou Agilidade (exceto Luta e Pontaria) você pode gastar 2 PE para receber +5 nesse teste.";
			$atletismo = $acrobacia = 5;
            break;
        case "Chef": // Chef
            $habnam = "Ingrediente Secreto (Origem)";
            $habdes = "Em cenas de interlúdio, você pode gastar uma ação para cozinhar um prato gostoso. Cada membro do grupo (incluindo você) que gastar uma ação para se alimentar recebe o benefício de dois pratos (caso o mesmo benefício seja escolhido duas vezes, seus efeitos se acumulam).";
            $fortitude = $profissao = 5;
            break;
        case "Criminoso": // criminalidades
            $habnam = "O Crime Compensa (Origem)";
            $habdes = "No final de uma missão, escolha um item encontrado na missão. Em sua próxima missão, você pode incluir esse item em seu inventário sem que ele conte em seu limite de itens por patente.";
            $crime = $furtividade = 5;
            break;
        case "Cultista Arrependido": // Cultista Arrependido
            $habnam = "Traços do Outro Lado. (Origem)";
            $habdes = "Você possui um poder paranormal à sua escolha. Porém, começa o jogo com metade da Sanidade normal para sua classe.";
            $religiao = $ocultismo = 5;
            break;
        case "Desgarrado": // Desgarradp
            $habnam = "Calejado. (Origem)";
            $habdes = "Você recebe +1 PV para cada 5% de NEX. (Adicionado Automáticamente!)";
            $fortitude = $sobrevivencia = 5;
            break;
        case "Engenheiro": // Engenheiro
            $habnam = "Ferramentas Favoritas. (Origem)";
            $habdes = "Um item a sua escolha (exceto armas) conta como uma categoria abaixo (por exemplo, um item de categoria II conta como categoria I para você).";
            $profissao = $tecnologia = 5;
            break;
        case "Executivo": //Executivo
            $habnam = "Processo Otimizado. (Origem)";
            $habdes = "Sempre que faz um teste de perícia durante um teste estendido, pode pagar 2 PE para receber +5 nesse teste.";
            $diplomacia = $profissao = 5;
            break;
        case "Investigador": //Inbestigador
            $habnam = "Faro para Pistas. (Origem)";
            $habdes = "Uma vez por cena, quando fizer um teste para procurar pistas, você pode gastar 1 PE para receber +5 nesse teste.";
            $investigacao = $percepcao = 5;
            break;
        case "Lutador": // Lutador
            $habnam = "Mão Pesada. (Origem)";
            $habdes = "Você recebe +2 em rolagens de dano com ataques corpo a corpo.";
            $luta = $reflexo = 5;
            break;
        case "Magnata": // Magnata
            $habnam = "Patrocinador da Ordem. (Origem)";
            $habdes = "Seu limite de crédito é sempre considerado um acima do atual.";
            $diplomacia = $pilotagem = 5;
            break;
        case "Mercenário": // Mercenário
            $habnam = "Posição de Combate (Origem)";
            $habdes = " No primeiro turno de cada cena de ação, você pode gastar 2 PE para receber uma ação de movimento adicional.";
            $iniciativa = $intimidacao = 5;
            break;
        case "Militar": // mlitar
            $habnam = "Para Bellum. (Origem)";
            $habdes = "Você recebe +2 em rolagens de dano com armas de fogo.";
            $tatica = $pontaria = 5;
            break;
        case "Operário": // Operário
            $habnam = "Ferramenta de Trabalho. (Origem)";
	        $habdes = "Escolha uma arma simples ou tática que, a critério do mestre, poderia ser usada como ferramenta em sua profissão (como uma marreta para um pedreiro). Você sabe usar a arma escolhida e recebe +1 em testes de ataque, rolagens de dano e margem de ameaça com ela.";
            $fortitude = $profissao = 5;
            break;
        case "Policial": // Policiaçl
            $habnam = "Patrulha (Origem)";
            $habdes = "Você recebe +2 em Defesa.";
            $percepcao = $pontaria = 5;
            break;
        case "Religioso": // Religioso
            $habnam = "Acalentar. (Origem)";
            $habdes = "Você recebe +5 em testes de Religião para acalmar. Além disso, quando acalma uma pessoa, ela recebe um número de pontos de Sanidade igual a 1d6 + a sua Presença.";
            $religiao = $vontade = 5;
            break;
        case "Servidor Público": // Servidor Público
            $habnam = "Espírito Cívico. (Origem)";
            $habdes = "Sempre que faz um teste para ajudar, você pode gastar 1 PE para aumentar o bônus concedido em +2.";
            $intuicao = $vontade = 5;
            break;
        case "Teórico da Conspiração": // Teórico
            $habnam = "Eu Já Sabia. (Origem)";
            $habdes = "Você não se abala com entidades ou anomalias. Afinal, sempre soube que isso tudo existia. Você recebe resistência a dano mental igual ao seu Intelecto.";
			$investigacao = $ocultismo = 5;
            break;
        case "TI": // ti
            $habnam = "Motor de Busca (Origem)";
            $habdes = "A critério do Mestre, sempre que tiver acesso a internet, você pode gastar 2 PE para substituir um teste de perícia qualquer por um teste de Tecnologia.";
            $investigacao = $tecnologia = 5;
            break;
        case "Trabalhador Rural": // trabaiador
            $habnam = "Desbravador. (Origem)";
            $habdes = "Quando faz um teste de Adestramento ou Sobrevivência, você pode gastar 2 PE para receber +5 nesse teste. Além disso, você não sofre penalidade em deslocamento por terreno dif ícil.";
            $adestramento = $sobrevivencia = 5;
            break;
        case "Trambiqueiro": // rambiqueiro
            $habnam = "Impostor. (Origem)";
            $habdes = "Uma vez por cena, você pode gastar 2 PE para substituir um teste de perícia qualquer por um teste de Enganação.";
            $crime = $enganacao = 5;
            break;
        case "Universitário": // Universitário
            $habnam = "Dedicação. (Origem)";
            $habdes = "ocê recebe +1 PE, e mais 1 PE adicional a cada NEX ímpar (15%, 25%...). Além disso, seu limite de PE por turno aumenta em 1 (em NEX 5% seu limite é 2, em NEX 10% é 3 e assim por diante).";
            $investigacao = $atualidades = 5;
            break;
        case "Vítima": // Vítima
            $habnam = "Cicatrizes Psicológicas. (Origem)";
            $habdes = "Você recebe +1 de Sanidade para cada 5% de NEX (Adicionado automaticamente.)";
            $reflexo = $vontade = 5;
            break;
    }
    switch ($classe){
        default:
            break;
        case "Mundano": //Combatente
            $hcn = "Empenho (Classe)";
            $hcd = "Você pode não ter treinamento especial, mas compensa com dedicação e esforço. Quando faz um teste de perícia, você pode gastar 1 PE para receber +2 nesse teste.";
            $pt[0] = "Armas Simples";
            break;
        case "Combatente": //Combatente
            $hcn = "Ataque Especial (Classe)";
            $hcd = "Quando faz um ataque, você pode gastar 2 PE para receber +5 no teste de ataque ou na rolagem de dano.";
            $pt[0] = "Armas Simples";
            $pt[3] = "Armas de táticas";
            $pt[4] = "Proteções leves";
            break;
        case "Especialista":
            $hcn = "Perito (Classe)";
            $hcd = "Escolha duas perícias nas quais você é treinado (exceto Luta e Pontaria). Quando faz um teste de uma dessas perícias, você pode gastar 2 PE para somar +1d6 no resultado do teste. ";
            $hcn2 = "Eclético (Classe)";
            $hcd2 = "Quando faz um teste de uma perícia, você pode gastar 2 PE para receber os benefícios de ser treinado nesta perícia.";
            $pt[0] = "Armas Simples";
            $pt[2] = "Proteções leves";
            break;
        case "Ocultista":
            $hcn = "Escolhido pelo Outro Lado (Classe)";
            $hcd = "Você pode lançar rituais de 1º círculo.";
            $ocultismo = $vontade = 5;
            $pt[0] = "Armas Simples";
            break;

    }
    if ($sucesso) {
        $vp = $con->prepare("SELECT * FROM `fichas_personagem` WHERE `usuario` = ? AND `nome` = ?");
        $vp->bind_param("is", $iduser, $nome);
        $vp->execute();
        $rvp = $vp->get_result();
        if ($rvp->num_rows == 0) {
            $vapo = $con->query("SELECT * FROM `fichas_personagem` WHERE `usuario` = '$iduser' Limit 1;");
            $vl = $con->query("SELECT * FROM `ligacoes` WHERE `id_usuario`='$iduser' AND `token` = '" . $convite . "' AND `id_ficha` is null;");
                $qp = $con->prepare("INSERT INTO `fichas_personagem` (`id`, `token`, `public`, `usuario`, `nome`, `foto`, `origem`, `classe`, `trilha`, `nex`, `patente`, `idade`, `local`, `historia`, `forca`, `agilidade`, `inteligencia`, `presenca`, `vigor`, `pv`, `pva`, `san`, `sana`, `pe`, `pea`, `morrendo`, `enlouquecendo`, `passiva`, `bloqueio`, `esquiva`, `mental`, `sangue`, `morte`, `energia`, `conhecimento`, `fisica`, `balistica`,`acrobacias`,`adestramento`,`artes`,`atualidades`,`atletismo`,`ciencia`,`crime`,`diplomacia`,`enganacao`,`fortitude`,`furtividade`,`iniciativa`,`intimidacao`,`intuicao`,`investigacao`,`luta`,`medicina`,`ocultismo`,`percepcao`,`pilotagem`,`pontaria`,`profissao`,`reflexos`,`religiao`,`sobrevivencia`,`tatica`,`tecnologia`,`vontade`) 
                                                                    VALUES ('', UUID() ,'0', ? , ?, ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , 0 , 0 , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ,? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? );");
                $qp->bind_param("isssssiiissiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii", $iduser, $nome, $foto, $origem, $classe, $trilha, $nex, $patente, $idade, $local, $historia, $forca, $agilidade, $intelecto, $presenca, $vigor, $pv, $pv, $san, $san, $pe, $pe, $passiva, $bloqueio, $esquiva, $sanidade, $sangue, $morte, $energia, $conhecimento, $fisico, $balistico, $acrobacia, $adestramento, $artes, $atualidades, $atletismo, $ciencia, $crime, $diplomacia, $enganacao, $fortitude, $furtividade, $iniciativa, $intimidacao, $intuicao, $investigacao, $luta, $medicina, $ocultismo, $percepcao, $pilotagem, $pontaria, $profissao,$reflexo, $religiao, $sobrevivencia, $tatica, $tecnologia, $vontade);
                $sucesso = $qp->execute();
                $id = mysqli_insert_id($con);
                if (!empty($hcn)) {
                    $dp = $con->query("INSERT INTO `habilidades`(`id_ficha`,`nome`,`descricao`,`id`) VALUES ('$id','$hcn','$hcd','')");
                }
                if (!empty($hcn2)) {
                    $dp = $con->query("INSERT INTO `habilidades`(`id_ficha`,`nome`,`descricao`,`id`) VALUES ('$id','$hcn2','$hcd2','')");
                }
                if (!empty($habnam)) {
                    $dp = $con->query("INSERT INTO `habilidades`(`id_ficha`,`nome`,`descricao`,`id`) VALUES ('$id','$habnam','$habdes','')");
                }
                if(isset($pt)){
                    foreach ($pt as $i){
                        if(!empty($i)){
                            $p = $con->query("INSERT INTO `proeficiencias` (`nome`,`id_ficha`) VALUES ('".$i."','".$id."');");
                        }
                    }
                }
                $al = $con->query("UPDATE `ligacoes` SET `id_ficha` = '" . $id . "' WHERE `ligacoes`.`token` = '" . $convite . "' AND `ligacoes`.`id_usuario` = '" . $iduser . "' LIMIT 1;");
                $msg = $sucesso ? "Personagem Criado com sucesso!" : "Houve uma falha ao adicionar personagem na database, contate um administrador!";
        } else {
            $sucesso = false;
            $msg = 'Já Existe um Personagem seu com esse mesmo nome!(Provavelmente houve duplicação ao salvar, então só ir para pagina do seu personagem.)';
        }
    }
} else {
    $sucesso = false;
    $msg = "Sua sessão expirou, faça login novamente.";
}
$data["id"] = $id;
$data["msg"] = $msg;
$data["success"] = $sucesso;
echo json_encode($data);