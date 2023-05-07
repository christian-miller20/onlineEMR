<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
$conn = oci_connect("boss", "boss", "xe") or die("<br>Could not connect");

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    
    $sql = "SELECT patient_id_seq.nextval FROM dual";
    $stmt = oci_parse($conn, $sql);

   oci_execute($stmt);

    // $sql = "SELECT patient_id_seq.currval FROM dual";
    // $stmt = oci_parse($conn, $sql);

    // oci_execute($stmt);

    $row = oci_fetch_array($stmt);

    $response = $row['NEXTVAL'];

    echo json_encode($response);

}
?>
