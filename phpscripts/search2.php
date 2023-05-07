<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");

$conn = oci_connect("boss", "boss", "xe") or die("<br>Could not connect");

$sql = "alter session set NLS_DATE_FORMAT='YYYY-MM-DD'";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	
	$query = strtolower($_GET['name']);
	$wildcard_query = $query . '%';

	// Modify to search for patient name and id
	$sql = "select * from patients where lower(first_name) like :query or lower(last_name) like :query";

	$stmt = oci_parse($conn, $sql);

	oci_bind_by_name($stmt, ':query', $wildcard_query);

        oci_execute($stmt);

	$rows = oci_fetch_all($stmt, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        //$row = oci_fetch_array($stmt, OCI_ASSOC);


	$response = array();

	if ($rows > 0) {
		foreach ($results as $row) {
			$id = $row['PATIENT_ID'];
			$first = $row['FIRST_NAME'];
			$last = $row['LAST_NAME'];
			$dob = $row['DOB'];
			array_push($response, array('id' => $id, 'name' => $last.','.$first, 'dob' => $dob));
		}
	}
	echo json_encode($response);

}
?>
