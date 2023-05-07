<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');


putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");

$conn = oci_connect("boss", "boss", "xe") or die("<br>Could not connect");


function hashPassword($input) {
    $hash = '';
    $inputLength = strlen($input);

    for ($i = 0; $i < $inputLength; $i++) {
        $char = $input[$i];
        $charAscii = ord($char);
        $hashedAscii = $charAscii + 1;
        $hashedChar = chr($hashedAscii);
        $hash .= $hashedChar;
    }

    return $hash;
}
 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        $username = $data['username'];
	$password = hashPassword($data['password']);

	$query = "insert into users (uname, pword) values ('$username', '$password')";

	$stmt = oci_parse($conn, $query);

	oci_execute($stmt);

        $num = oci_num_rows($stmt);


        if ($num > 0) {
                echo json_encode(array('success' => true));
        }
	else {
		echo json_encode(array('success' => false));
        }
}
?>
