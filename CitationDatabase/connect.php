<?php
function ConnectDB() {
	$hostname = '127.0.0.1';
	$username = 'melend53';
	$password = '';
	$dbname = 'melend53';

	try {
		$dbh = new PDO("mysql:$hostname;dbname=$dbname", 
                               $username, $password);
	}
	catch(PDOException $e) {
		die ('PDO error in "ConnectDB()": ' . $e->getMessage() );
	}
	
	return $dbh;
}

?>
