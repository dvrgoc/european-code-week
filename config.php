<?php
//@TODO: create readme file
$config = array(
	'default_timezone' => 'Europe/Zagreb'
);


date_default_timezone_set($config['default_timezone']);


function connect2db($credentials) {
	$connection = mysqli_connect(
		$credentials['mysql']['host'],
		$credentials['mysql']['username'],
		$credentials['mysql']['password'],
		$credentials['mysql']['db']
	);

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	mysqli_select_db($connection, $credentials['mysql']['db']);

	return $connection;
}

function disconnectFromDb($connection) {
	mysqli_close($connection);
}

function getAllProducts($connection) {
	$results = $connection->query('SELECT id, title FROM products ORDER BY title ASC ');

	if($results->num_rows) {
		/*var_dump("true");*/
		return mysqli_fetch_all($results, MYSQLI_ASSOC);
	}

	return false;
}