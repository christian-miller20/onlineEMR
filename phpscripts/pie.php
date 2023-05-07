<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");

$conn = oci_connect("boss", "boss", "xe") or die("<br>Could not connect");

function randomColor() {
	$red = mt_rand(10, 100);
	$green = mt_rand(100, 150);
	$blue = mt_rand(150, 200);

	return sprintf("#%02x02%02x", $red, $green, $blue);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$input = file_get_contents('php://input');
        $data = json_decode($input, true);

	$mode = $data['mode'];

	$sql = "select $mode, count(*) as num, round(count(*) * 100 / sum(count(*)) over (), 2) as percentage from visits where $mode != 'None' and $mode != 'null' and $mode is not null group by $mode";

        $stmt = oci_parse($conn, $sql);

        oci_execute($stmt);

	$rows = oci_fetch_all($stmt, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);

	$response = array();

	if ($rows > 0) {
		foreach ($results as $row) {
			array_push($response, array('title' => $row[strtoupper($mode)], 'value' => intval($row['PERCENTAGE']), 'color' => randomColor()));
		}
	}
	echo json_encode($response);

}
?>
