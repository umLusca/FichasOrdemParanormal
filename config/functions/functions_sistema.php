<?php

function minmax($int, $min = 0, $max = 99)
{
	return min(max(intval($int), $min), $max);
}
function test_input($data, $limit = 1000): string
{
	return substr(htmlspecialchars(stripslashes(trim($data))),0,$limit);
}


function getUserIpAddr(){
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		//ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		//ip pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
function generate_tokens(): array
{
	$selector = bin2hex(random_bytes(16));
	$validator = bin2hex(random_bytes(32));
	return [$selector, $validator, $selector . ':' . $validator];
}
function parse_token(string $token): ?array
{
	$parts = explode(':', $token);

	if ($parts && count($parts) == 2) {
		return [$parts[0], $parts[1]];
	}
	return null;
}
function find_user_token_by_selector(string $selector): bool|array|null
{
	$con = con();
	$ip = getUserIpAddr();
	$a = $con->prepare("SELECT id, selector, hashed_validator, user_id, expiry FROM user_tokens WHERE selector = ? AND expiry >= now() AND `ip` = ? LIMIT 1;");
	$a->bind_param("ss", $selector, $ip);
	$a->execute();
	$ra = $a->get_result();
	return mysqli_fetch_assoc($ra);
}
function delete_user_token(int $user_id): bool
{
	$con = con();
	$q = $con->prepare("DELETE FROM user_tokens WHERE user_id = ?");
	$q->bind_param("i", $user_id);
	return $q->execute();
}
function find_user_by_token(string $token): bool|array|null
{
	$tokens = parse_token($token);

	if (!$tokens) {
		return null;
	}
	$con = con();
	$a = $con->prepare('SELECT usuarios.id, login
            FROM usuarios
            INNER JOIN user_tokens ON user_id = usuarios.id
            WHERE selector = ? AND
                expiry > now()
            LIMIT 1');
	$a->bind_param("s", $tokens[0]);
	$a->execute();
	$ra = $a->get_result();
	return mysqli_fetch_assoc($ra);
}
function insert_user_token(int $user_id, string $selector, string $hashed_validator, string $expiry): bool
{
	$con = con();
	$ip = getUserIpAddr();
	$q = $con->prepare("INSERT INTO `user_tokens` (`id`, `selector`, `hashed_validator`, `user_id`, `expiry`,`ip`) VALUES ('', ? , ? , ? , ? , ? );");
	$q->bind_param("ssiss", $selector, $hashed_validator, $user_id, $expiry, $ip);
	return $q->execute();
}
function remember_me(int $user_id, int $day = 7): void
{
	[$selector, $validator, $token] = generate_tokens();

	// remove all existing token associated with the user id
	delete_user_token($user_id);

	// set expiration date
	$expired_seconds = time() + 60 * 60 * 24 * $day;

	// insert a token to the database
	$hash_validator = password_hash($validator, PASSWORD_DEFAULT);
	$expiry = date('Y-m-d H:i:s', $expired_seconds);
	if (insert_user_token($user_id, $selector, $hash_validator, $expiry)) {
		setcookie('remember_me', $token, $expired_seconds);
	}
}
function is_user_logged_in(): bool
{
	// check the session
	if (isset($_SESSION['UserLogin'])) {
		return true;
	}

	// check the remember_me in cookie
	$token = filter_input(INPUT_COOKIE, 'remember_me');

	if ($token && token_is_valid($token)) {

		$user = find_user_by_token($token);

		if ($user) {
			return logar($user['login']);
		}
	}
	return false;
}
function token_is_valid($token): bool
{
	$e = explode(':', $token);
	$selector = $e[0];
	$validator = $e[1];

	$tokens = find_user_token_by_selector($selector);
	if (!$tokens) {
		return false;
	}

	return password_verify($validator, $tokens['hashed_validator']);
}
function logout(): void
{
	if (is_user_logged_in()) {

		// delete the user token
		delete_user_token($_SESSION['UserID']);

		// delete session
		unset($_SESSION['username'], $_SESSION['user_id`']);

		// remove the remember_me cookie
		if (isset($_COOKIE['remember_me'])) {
			unset($_COOKIE['remember_me']);
			setcookie('remember_user', null, -1);
		}

		// remove all session data
		session_unset();
		session_destroy();

		// redirect to the login page
	}
}