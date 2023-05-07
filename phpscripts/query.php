<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");

$conn = oci_connect("boss", "boss", "xe") or die("<br>Could not connect");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$input = file_get_contents('php://input');
	$data = json_decode($input, true);

	$query = $data['query'];

	$response = array();
	
	
	// remove semicolon
	if (substr($query, -1) === ';') {
		$query = substr($query, 0, -1);
	}

	// fix quotes
	$query = str_replace('"', "'", $query);
	// check ddl words
	$ddl = array('alter', 'create', 'drop', 'insert', 'update', 'delete', 'truncate', 'rename', 'grant', 'revoke', 'comment', 'analyze', 'vacuum', 'commit', 'rollback', 'savepoint', 'set transaction');
	foreach ($ddl as $word) {
		if (stripos(strtolower($query), $word) !== false) {
			array_push($response, array("Invalid Query" => "Unable to execute DDL/DML commands!"));
			echo json_encode($response);
			exit;
		}
	}
	$sql = $query;
	$stmt = oci_parse($conn, $sql);


        oci_execute($stmt);

	$rows = oci_fetch_all($stmt, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);


	if ($rows > 0) {
		foreach ($results as $row) {
			array_push($response, $row);
		}
	}
	else {
		array_push($response, array('Results' => 'None'));
	}
	echo json_encode($response);

}
?>
