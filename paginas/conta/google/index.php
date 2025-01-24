<?php
require_once "./../../config/componentes.php";

session_start();
if (isset($_GET['code'])) {
	// Get Token
	$token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);
	
	// Check if fetching token did not return any errors
	if (!isset($token['error'])) {
		// Setting Access token
		$gclient->setAccessToken($token['access_token']);
		
		// store access token
		$_SESSION['access_token'] = $token['access_token'];
		
		// Get Account Profile using Google Service
		$gservice = new Google_Service_Oauth2($gclient);
		
		// Get User Data
		$udata = $gservice->userinfo->get();
		//email
		$email = cleanstring($udata->email);
		$nome = $udata->name;
		
		$t = $con->prepare("SELECT * FROM usuarios WHERE email = ? ");
		$t->bind_param("s", $email);
		$t->execute();
		$t = $t->get_result();
		if ($t->num_rows) {
			$user = mysqli_fetch_assoc($t);
			if ((int)$user["status"] !== 1 || (int)$user["google"] !== 1) {
				$a = $con->prepare("UPDATE usuarios SET status = 1,nome = ? , google = 1 WHERE id = ?");
				$a->execute([$nome, $user["id"]]);
			}
			logar($user["id"]);
			header('Location: /painel');
		} else {
			$senha = generateRandomString();
			$f = $con->prepare("INSERT INTO usuarios(token,email,nome,senha,created,verificado,status,google) VALUES (uuid(),?,?,?,NOW(),1,1,1);");
			$f->bind_param("sss",$email,$nome,$senha);
			$f->execute();
			
			logar($con->insert_id);
			header('Location: /painel');
		}
	} else {
		echo $token['error'];
		
	}
} else {
	$auth_url = $gclient->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}