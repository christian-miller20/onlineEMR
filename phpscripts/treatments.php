<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");

$conn = oci_connect("boss", "boss", "xe") or die("<br>Could not connect");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

	$sql = "select treatment_type, count(*) as total from treatments natural join visits where extract(year from visit_date) = extract(year from sysdate)  group by treatment_type order by total desc";

        $stmt = oci_parse($conn, $sql);

        oci_execute($stmt);

        $rows = oci_fetch_all($stmt, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        $response = array();

        if ($rows > 0) {
                foreach ($results as $row) {
                        array_push($response, $row);
                }
        }
        echo json_encode($response);

}
?>
