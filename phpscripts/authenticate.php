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
	$password = $data['password'];


	# build up from bottom for testing purposes
	$query = "select pword from users where uname = :username";

	$stmt = oci_parse($conn, $query);
	#oci_define_by_name($stmt, "USER", $u);
	oci_bind_by_name($stmt, ':username', $username);

	oci_execute($stmt);

        $row = oci_fetch_array($stmt, OCI_ASSOC);


        if ($row && hashPassword($data['password']) == $row['PWORD']) {
		session_start();
		session_regenerate_id();
		$_SESSION["username"] = $username;
                echo json_encode(array('success' => true, 'username' => $username, 'password' => $password));
        }
	else {
		echo json_encode(array('success' => false, 'username' => $username, 'password' => $password));
        }
}
?>
