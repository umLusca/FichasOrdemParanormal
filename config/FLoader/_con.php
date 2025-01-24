<?php


function con()
{
	$con = new mysqli(dbhost, dbuser, dbpass, dbname);
	if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
	}
	return $con;
}

function con_pdo(): PDO
{
	var_dump(dbhost);
	$dsn = "mysql:host=".dbhost.";dbname=".dbname.";charset=UTF8";
	try {
		$c = new PDO($dsn, dbuser,dbpass);
		$c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$c->query("SET time_zone = '-04:00'");
		return $c;
	} catch (PDOException $e) {
		// Log or handle the exception as needed
		die("Database connection failed: " . $e->getMessage());
	}
}

function sendTelegram($Message, $ApiToken, $ChatID): false|string
{
	$apiURL = "https://api.telegram.org/bot{$ApiToken}/sendMessage?";
	$param = [
		'chat_id'    => $ChatID,
		'text'       => $Message,
		'parse_mode' => 'html',
		//	'disable_web_page_preview' => false,
	];
	return file_get_contents($apiURL . http_build_query($param));
	
}

function setMeta(string $tableName, int $rowId, string $name, string $value): bool
{
	$c = con();
	
	$a = $c->prepare("SELECT * FROM metadata WHERE tableName = :tableName AND tableID = :id AND name = :name");
	$a->execute([":tableName" => $tableName, ":id" => $rowId, ":name" => $name]);
	if ($a->rowCount()) {
		$meta = $a->fetch(PDO::FETCH_ASSOC);
		$b = $c->prepare("UPDATE metadata SET value = :value WHERE id = :metaId");
		return $b->execute([":value" => $value, ":metaId" => $meta["id"]]);
	}
	
	$b = $c->prepare("INSERT INTO metadata (tableName, tableID, name, value) VALUES (:tableName, :id, :name, :value)");
	return $b->execute([":tableName" => $tableName, ":id" => $rowId, ":name" => $name, ":value" => $value]);
}

function getMeta(string $tableName, int $id): array
{
	$c = con();
	$a = $c->prepare("SELECT * FROM metadata WHERE tableName = :tableName AND tableID = :id AND name = :name");
	$a->execute([":tableName" => $tableName, ":id" => $id]);
	if ($a->rowCount()) {
		return $a->fetch(PDO::FETCH_ASSOC);
	}
	return [];
}


/**
 * <h3>Essa função cria um log no banco de dados</h3>
 * <p>Essa função por padrão pega as variáveis $_GET $_POST $_SERVER $_SESSION PHP://Input <br>
 * Logo, não precisa passar essas variáveis no campo extra.</p>
 * <p>Geralmente aqui se coloca o HTTP STATUS de resposta da API</p>
 * <strong>[Recomendado]</strong>
 * <p>Coloque aqui uma mensagem, essa mensagem irá aparecer como resumo no painel.<br>Exemplo: "Houve alteração em dados de uma campanha"</p>
 * @param int $priority <br> <strong>[Recomendado]</strong> <br>
 *  Abaixo de 50, não precisa alertar, ou não há grau de risco;<br>
 *  Acima de 100, Há grau de risco, e requer uma atenção mínima<br>
 *  Acima de 70, será notificado aos administradores.</p>
 * <strong>[Obrigatório]</strong>
 * @return boolean
 * success on true, false on fail... duh
 */
function logThis(int $priority = 0, array $extra = [], array $returns = []): bool
{
	global $con, $_CONFIG;
	global $return;
	global $query;
	
	if (empty($query)) {
		$query = $_SERVER["REDIRECT_URL"];
	} else {
		if (is_array($query)) $query = implode("/", $query);
	}
	
	if (empty($return)) {
		$return = $returns;
	}
	
	if (!is_a($con, "PDO")) {
		$con = con();
	}
	$extra["query"] = $query;
	$extra["return"] = [
		"status" => $returns["status"],
		"msg" => $returns["msg"],
	];
	try {
		$jsonPost = json_encode($_POST);
		$jsonGet = json_encode($_GET);
		$jsonSession = json_encode($_SESSION);
		$jsonServer = json_encode($_SERVER);
		$jsonBody = file_get_contents('php://input');
		$jsonExtra = json_encode($extra, JSON_PRETTY_PRINT);
		$jsonReturn = json_encode($return);
		$queryString = $query;
		$category = $query;
		
		
		$q = $con->prepare('INSERT INTO logsApi(priority, category, responseStatus, responseText, route,responseJson, postArray, getArray, sessionArray, extraArray, serverArray, postBody) VALUES (:priority,:category,:responseStatus,:responseText,:route,:responseJson, :postArray,:getArray,:sessionArray,:extraArray,:serverArray, :postBody);');
		
		$q->bindParam(":priority", $priority, PDO::PARAM_INT);     // INT
		$q->bindParam(":responseStatus", $status, PDO::PARAM_INT); //INT
		$q->bindParam(":responseText", $msg);                      //STRING
		$q->bindParam(":category", $category);                     //STRING
		$q->bindParam(":route", $queryString);                     //STRING
		$q->bindParam(":responseJson", $jsonReturn);               //JSON
		$q->bindParam(":postArray", $jsonPost);                    //JSON
		$q->bindParam(":getArray", $jsonGet);                      //JSON
		$q->bindParam(":sessionArray", $jsonSession);              //JSON
		$q->bindParam(":extraArray", $jsonExtra);                  //JSON
		$q->bindParam(":serverArray", $jsonServer);                //JSON
		$q->bindParam(":postBody", $jsonBody);                     //JSON
		
		$title = mb_strtoupper("<b>LOG API - {$_CONFIG["URL"]}</b>\n");
		$desc = "Prioridade: <b>{$priority}</b>\n";
		$user = "User: <span class='tg-spoiler'>{$_SESSION['UserToken']}</span>\n";
		$json = "<pre><code class='language-json'>{$jsonExtra}</code></pre>";
		$message = "{$title}{$desc}{$user}{$json}";
		
		if ($priority >= 50) {
			sendTelegram($message, $_ENV["TelegramWarningsBotKey"], 6238258245);
		} else {
			sendTelegram($message, $_ENV["TelegramAlertsBotKey"], 6238258245);
		}
		
		
		return $q->execute();
	} catch (Exception $e) {
		return false;
	}
	
}

/**
 * Retorna os parâmetros necessários para fazer um mysqli_prepare();
 * <h2>Exemplo de uso</h2>
 *  $arr = ("coluna"=>"valor" , "coluna2"=>"valor2" );<br/><br/>
 *  $return = get_stmt($arr);<br/><br/>
 *  $q = mysqli_prepare($con,"UPDATE tabela SET <b>{return["query"]}</b>;");<br/>
 *  $q->bind_param(<b>$return["bind"]</b>,...<b>$return["values"]</b>);<br/>
 *  $q->execute();<br/>
 *
 *
 * @param false|PDO &$con [Opcional]
 *  <p>
 *  Se não houver, ele puxa uma conexão pela função con(); e Retorna a conexão no final
 *  </p>
 * @param array $updates [Obrigatório] <p>
 * Um Array contendo indices e valores, sendo a coluna e valor respectivamente a tabela que será aplicada.<br/>
 * Exemplo:
 * <ul>
 * <li>array(<br/>      "nome" => "Lucas",<br/>       "idade" => 18<br/>);</li>
 * </ul>
 * </p>
 * @param array|string $includes [Obrigatório]
 *  <p>
 *  <h4>Array</h4>
 *  Fará com que apenas os indices dentro deste array sejam atualizados. Sendo limitado apenas pelo <b>$excludes</b>,
 *  isto é, caso tenha uma coluna que esteja em ambos, será priorizado a exclusão no processo.
 *  Exemplo:
 *  <ul>
 *  <li>array("nome","idade");</li>
 *  </ul>
 *  <h4>String</h4>
 *  Será o nome da tabela, que será alterado. Fazendo com que o $con Seja obrigatório para poder pegar as colunas dentro da mesma.
 *  E fazendo assim, o includes automaticamente. Sendo limitado apenas ao $excludes.
 *  </p>
 * @param false|array $excludes [Opcional]
 * <p> Um Array contendo colunas que deverão ser excluídas ou não alteráveis no processo.
 *  Exemplo:
 * <ul>
 * <li>array("nome","idade");</li>
 * </ul>
 * Com isso, as colunas <b>Nome</b> e <b>Idade</b> não vão ser alteradas, mesmo que dentro do array principal.
 * </p>
 * @return array
 * <p>
 *  Retorna um Array com 3 Valores sendo <br />
 *  <var>$return["query"]</var>: uma string que contem cada atualização para alterar no banco de dados.
 *   <var>$return["values"]</var>: uma array contendo os valores separados de cada coluna na ordem da $return["query"].
 * <p>
 */
function sqlAutoUpdater(PDO &$connection, array $_DATA, string|array $table, array $allowed = [], array $excludes = []): array|false
{
	$columns = [];
	if (is_string($table)) {
		$table = vartreat($table);
		$_d = $connection->prepare("SELECT * FROM   INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? ;");
		$_d->execute([$table]);
		if (!$_d->rowCount()) {
			throw new Exception("Table or Database not found...", 500);
		}
		foreach ($_d as $f) {
			if (!in_array($f["COLUMN_NAME"], $excludes, true)) $columns[$f["COLUMN_NAME"]] = [
				"type"   => $f["DATA_TYPE"],
				"length" => $f["CHARACTER_MAXIMUM_LENGTH"],
			];
		}
	}
	
	$values = [];
	$query = [];
	foreach ($_DATA as $key => $value) {
		if (key_exists($key, $columns) && (!empty($allowed) && in_array($key, $allowed, true))) {
			
			$query[] = "$key = :$key";
			switch ($columns[$key]["type"]) {
				default:
					$values[":$key"] = vartreat($value);
					break;
				
				case "tinyint":
				case "int":
					$values[":$key"] = (int) vartreat($value);
					break;
				case "text":
				case "varchar":
					
					$values[":$key"] = (string) vartreat($value);
					break;
				case "date":
				case "timestamp":
				case "datetime":
					$values[":$key"] = (string) vartreat($value);
					//
					break;
			}
		}
	}
	return array($query, $values);
}

function getUserLimits($user, PDO|null $c = null)
{
	if (!$c) $c = con();
	if (!empty($user)) {
		$a = $c->prepare("SELECT * FROM getlimits WHERE uuid_usuario = ?;");
		$a->execute([$user]);
		if ($a->rowCount()) {
			return $a->fetch(2);
		}
	}
	return false;
}

function getPermissionCampanha(string $campanha, string|null $user = null, &$error = []): array|bool
{
	if (empty($user)) {
		session_start();
		if (empty($_SESSION["UserToken"])) {
			$error["status"] = 403;
			$error["msg"] = 'Você precisa estar logado';
			return false;
		}
		$user = (string) $_SESSION['UserToken'];
		session_write_close();
	}
	$c = con();
	$fq = $c->prepare("SELECT * FROM campanhas WHERE uuid_campanha = ? AND status = 1");
	$fq->execute([$campanha]);
	if ($fq->rowCount()) {
		$camp = $fq->fetch(2);
		if ($camp["uuid_usuario"] === $user) {
			return true;
		}
		$sq = $c->prepare("SELECT * FROM getlider WHERE uuid_campanha = ? AND uuid_usuario = ?");
		$sq->execute([$camp["uuid_campanha"], $user]);
		if ($sq->rowCount()) {
			return $sq->fetch(2);
		}
		
		$error["msg"] = 'Você não é líder';
		$error["status"] = 403;
	} else {
		$error["msg"] = "Campanha não encontrada";
		$error["status"] = 404;
	}
	return false;
}

function checkCampanha(string $uuid_campanha, &$error): bool
{
	_loadFunction("inputTreat");
	
	$c = con();
	$a = $c->prepare("SELECT * FROM campanhas WHERE uuid_campanha = ?");
	$a->execute([$uuid_campanha]);
	if (!$a->rowCount()) {
		$error = "Campanha não existe";
		return false;
	}
	$campanha = $a->fetch(2);
	if (!$campanha["status"]) {
		$error = "Campanha está desativada";
		return false;
	}
	
	return true;
}
