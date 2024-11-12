<?php

$fichaToken = cleanstring($_POST["token"]);

session_start();
$ok = true;
if (empty($_SESSION["UserID"])) {
	$ok = false;
	$return["msg"] = "Você precisa estar logado!";
	$return["status"] = 403;
}

if ($ok && !empty($fichaToken)) {
	$c = con_pdo();
	$a = $c->prepare("SELECT fichas_personagem.*, u.nome as usuario FROM `fichas_personagem` inner join usuarios u on fichas_personagem.usuario = u.id WHERE fichas_personagem.`token`= ?;");
	$a->execute([$fichaToken]);
	if (!$a->rowCount()) {
		$ok = false;
		$return["status"] = 404;
		$return["msg"] = "Ficha não encontrada...";
	}
	if ($ok) {
		$ficha = $a->fetch(2);
		
		if (VerificarPermissaoFicha($fichaToken, $_SESSION["UserID"])) {
			$ficha["editable"] = true;
		} else {
			$ficha["editable"] = false;
			if ($ficha["public"]) {
				$ok = false;
				$return["status"] = 403;
				$return["msg"] = "Sem permissão para acessar components!";
			}
		}
	}
	if ($ok) {
		
		$b = $c->prepare("SELECT id,  nome, descricao FROM `poderes` WHERE `id_ficha` = ? ;");
		$b->execute([$ficha["id"]]);
		$ficha["poderes"] = $b->fetchAll(2);
		
		$d = $c->prepare("SELECT id,  nome, descricao FROM `habilidades` WHERE `id_ficha` = ? ;");
		$d->execute([$ficha["id"]]);
		$ficha["habilidades"] = $d->fetchAll(2);
		
		
		$h = $c->prepare("SELECT id,  nome FROM `proeficiencias` WHERE `id_ficha` = ?;");
		$h->execute([$ficha["id"]]);
		$ficha["proficiencias"] = $h->fetchAll(2);
		
		$d = $c->prepare("SELECT id,  foto, nome, circulo, elemento, conjuracao, alcance, alvo, duracao, resistencia, efeito, dano, dano2, dano3 FROM `rituais` WHERE `id_ficha` = ? ;");
		$d->execute([$ficha["id"]]);
		$ficha["rituais"] = $d->fetchAll(2);
		
		$g = $c->prepare("SELECT token, owner, nome, dado, foto, dano, token_pai FROM `dados_customizados` WHERE `token_pai` = ? ");
		$g->execute([$ficha["token"]]);
		$ficha["dices"] = $g->fetchAll(2);
		
		
		$e = $c->prepare("SELECT id, foto, nome, descricao, quantidade, espaco, prestigio FROM inventario WHERE id_ficha = :id AND id NOT IN (SELECT item_id FROM armas WHERE armas.id_ficha = :id)");
		$e->execute([":id" => $ficha["id"]]);
		$ficha["inventario"] = $e->fetchAll(2);
		
		$f = $c->prepare("Select a.id, item_id, a.arma, a.tipo, a.ataque, a.alcance, a.dano, a.critico, a.margem, a.recarga, a.especial, i.id as itemId, i.foto, i.nome, i.descricao, i.quantidade, i.espaco, i.prestigio FROM inventario i INNER JOIN armas a ON a.item_id = i.id WHERE i.id_ficha = :id");
		$f->execute([":id" => $ficha["id"]]);
		$ficha["armas"] = $f->fetchAll(2);
		
		
		$ficha["pericias"] = [
			"acrobacias"   => ["atributo" => "agi", "bonus" => $ficha["acrobacias"], "grau" => $ficha["tacrobacias"], "ramo" => $ficha[""] ?: "Nenhum"],
			"adestramento" => ["atributo" => "pre", "bonus" => $ficha["adestramento"], "grau" => $ficha["tadestramento"], "ramo" => $ficha[""] ?: "Nenhum"],
			"atletismo"    => ["atributo" => "for", "bonus" => $ficha["atletismo"], "grau" => $ficha["tatletismo"], "ramo" => $ficha[""] ?: "Nenhum"],
			"artes"        => ["atributo" => "pre", "bonus" => $ficha["artes"], "grau" => $ficha["tartes"], "ramo" => $ficha[""] ?: "Nenhum"],
			"atualidades"  => ["atributo" => "int", "bonus" => $ficha["atualidades"], "grau" => $ficha["tatualidades"], "ramo" => $ficha[""] ?: "Nenhum"],
			"ciencia"      => ["atributo" => "int", "bonus" => $ficha["ciencia"], "grau" => $ficha["tciencia"], "ramo" => $ficha[""] ?: "Nenhum"],
			
			"crime"       => ["atributo" => "agi", "bonus" => $ficha["crime"], "grau" => $ficha["tcrime"], "ramo" => $ficha[""] ?: "Nenhum"],
			"diplomacia"  => ["atributo" => "pre", "bonus" => $ficha["diplomacia"], "grau" => $ficha["tdiplomacia"], "ramo" => $ficha[""] ?: "Nenhum"],
			"enganacao"   => ["atributo" => "pre", "bonus" => $ficha["enganacao"], "grau" => $ficha["tenganacao"], "ramo" => $ficha[""] ?: "Nenhum"],
			"fortitude"   => ["atributo" => "vig", "bonus" => $ficha["fortitude"], "grau" => $ficha["tfortitude"], "ramo" => $ficha[""] ?: "Nenhum"],
			"furtividade" => ["atributo" => "agi", "bonus" => $ficha["furtividade"], "grau" => $ficha["tfurtividade"], "ramo" => $ficha[""] ?: "Nenhum"],
			
			"iniciativa"   => ["atributo" => "agi", "bonus" => $ficha["iniciativa"], "grau" => $ficha["tiniciativa"], "ramo" => $ficha[""] ?: "Nenhum"],
			"intimidacao"  => ["atributo" => "pre", "bonus" => $ficha["intimidacao"], "grau" => $ficha["tintimidacao"], "ramo" => $ficha[""] ?: "Nenhum"],
			"intuicao"     => ["atributo" => "pre", "bonus" => $ficha["intuicao"], "grau" => $ficha["tintuicao"], "ramo" => $ficha[""] ?: "Nenhum"],
			"investigacao" => ["atributo" => "int", "bonus" => $ficha["investigacao"], "grau" => $ficha["tinvestigacao"], "ramo" => $ficha[""] ?: "Nenhum"],
			"luta"         => ["atributo" => "for", "bonus" => $ficha["luta"], "grau" => $ficha["tluta"], "ramo" => $ficha[""] ?: "Nenhum"],
			
			"medicina"  => ["atributo" => "int", "bonus" => $ficha["medicina"], "grau" => $ficha["tmedicina"], "ramo" => $ficha[""] ?: "Nenhum"],
			"ocultismo" => ["atributo" => "int", "bonus" => $ficha["ocultismo"], "grau" => $ficha["tocultismo"], "ramo" => $ficha[""] ?: "Nenhum"],
			"percepcao" => ["atributo" => "pre", "bonus" => $ficha["percepcao"], "grau" => $ficha["tpercepcao"], "ramo" => $ficha[""] ?: "Nenhum"],
			"pilotagem" => ["atributo" => "agi", "bonus" => $ficha["pilotagem"], "grau" => $ficha["tpilotagem"], "ramo" => $ficha[""] ?: "Nenhum"],
			"pontaria"  => ["atributo" => "agi", "bonus" => $ficha["pontaria"], "grau" => $ficha["tpontaria"], "ramo" => $ficha[""] ?: "Nenhum"],
			
			"profissao"     => ["atributo" => "int", "bonus" => $ficha["profissao"], "grau" => $ficha["tprofissao"], "ramo" => $ficha["nprofissao"] ?: "Nenhum"],
			"reflexo"       => ["atributo" => "agi", "bonus" => $ficha["reflexos"], "grau" => $ficha["treflexo"], "ramo" => $ficha[""] ?: "Nenhum"],
			"religiao"      => ["atributo" => "pre", "bonus" => $ficha["religiao"], "grau" => $ficha["treligiao"], "ramo" => $ficha[""] ?: "Nenhum"],
			"sobrevivencia" => ["atributo" => "int", "bonus" => $ficha["sobrevivencia"], "grau" => $ficha["tsobrevivencia"], "ramo" => $ficha[""] ?: "Nenhum"],
			"tatica"        => ["atributo" => "int", "bonus" => $ficha["tatica"], "grau" => $ficha["ttatica"], "ramo" => $ficha[""] ?: "Nenhum"],
			
			"tecnologia" => ["atributo" => "int", "bonus" => $ficha["tecnologia"], "grau" => $ficha["ttecnologia"], "ramo" => $ficha[""] ?: "Nenhum"],
			"vontade"    => ["atributo" => "pre", "bonus" => $ficha["vontade"], "grau" => $ficha["tvontade"], "ramo" => $ficha[""] ?: "Nenhum"]
		];
		
		unset($ficha["id"]);
		$return["success"] = true;
		$return["status"] = 200;
		$return["msg"] = "Ficha encontrada!";
		$return["dados"] = $ficha;
		
	}
} else  {
	$c = con_pdo();
	$a = $c->prepare("SELECT fichas_personagem.nome, fichas_personagem.token,public, foto, trilha, classe, origem, nex, local, idade, missoes.nome as missao FROM fichas_personagem LEFT JOIN ligacoes ON ligacoes.id_ficha = fichas_personagem.id LEFT JOIN missoes ON ligacoes.id_missao = missoes.id WHERE fichas_personagem.usuario = ? ORDER BY fichas_personagem.id desc;");
	$a->execute([$_SESSION["UserID"]]);
	$return["dados"] = [];
	$return["status"] = 200;
	$return["msg"] = "Nenhuma components encontrada.";
	$return["success"] = true;
	$return["total"] = $a->rowCount();
	if ($a->rowCount()){
		$return["msg"] = "Encontrado!";
		$return["dados"] = $a->fetchAll(2);
	}
	
}
