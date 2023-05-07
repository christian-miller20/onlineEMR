<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

putenv("ORACLE_HOME=/u01/app/oracle/product/11.2.0/xe/");
$conn = oci_connect("boss", "boss", "xe") or die("<br>Could not connect");

$sql = "alter session set NLS_DATE_FORMAT='YYYY-MM-DD'";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

if (isset($_GET['endpoint'])){
        switch($_GET['endpoint']){
                case 'get_all_visits':
			$patient_id = $_GET['patient_id'];

			$sql = "select * from visits where patient_id = $patient_id";
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

			break;
                case 'get_visit_info':
			$patient_id = $_GET['patient_id'];
			$visit_id = $_GET['visit_id'];
			
			$sql = "select * from visits where patient_id = $patient_id and visit_id = $visit_id";
			$stmt = oci_parse($conn, $sql);

        		oci_execute($stmt);

			$rows = oci_fetch_all($stmt, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
		
			// Select from treatments table
			$sql = "SELECT * FROM treatments WHERE patient_id = $patient_id AND visit_id = $visit_id";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt);
			$treatment_rows = oci_fetch_all($stmt, $treatment_results, null, null, OCI_FETCHSTATEMENT_BY_ROW);

			$sql = "select * from patients where patient_id = $patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt);
			$patient_rows = oci_fetch_all($stmt, $patient_results, null, null, OCI_FETCHSTATEMENT_BY_ROW);

			$sql = "select * from familyhistory where patient_id = $patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt);
			$family_history_rows = oci_fetch_all($stmt, $family_results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			
			$sql = "select * from immunizations where patient_id = $patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt);
			$immune_rows = oci_fetch_all($stmt, $immune_results, null, null, OCI_FETCHSTATEMENT_BY_ROW);

			$sql = "select * from medications where patient_id = $patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt);
			$med_rows = oci_fetch_all($stmt, $med_results, null, null, OCI_FETCHSTATEMENT_BY_ROW);

			$sql = "select * from OBSTETRICHISTORY where patient_id = $patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt);
			$obs_hist = oci_fetch_all($stmt, $obs_results, null, null, OCI_FETCHSTATEMENT_BY_ROW);

			$sql = "select * from preexistingconditions where patient_id = $patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt);
			$preexisting = oci_fetch_all($stmt, $existing_results, null, null, OCI_FETCHSTATEMENT_BY_ROW);

			$sql = "select * from allergies where patient_id = $patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt);
			$allergies = oci_fetch_all($stmt, $allergies_results, null, null, OCI_FETCHSTATEMENT_BY_ROW);

			$sql = "select * from socialhistory where patient_id = $patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt);
			$social = oci_fetch_all($stmt, $social_results, null, null, OCI_FETCHSTATEMENT_BY_ROW);


			$response = array();
			if ($rows > 0) {
				foreach ($results as $row) {
					// Append visit data
					array_push($response, $row);
				} 
				
				array_push($response, $patient_results[0]);
				array_push($response, $family_results);
				array_push($response, $immune_results);
				array_push($response, $med_results);
				array_push($response, $obs_results);
				array_push($response, $existing_results);
				array_push($response, $allergies_results);
				array_push($response, $social_results[0]);

				if ($treatment_rows > 0) {
					foreach ($treatment_results as $treatment_row) {
						// Append treatment data
						array_push($response, $treatment_row);
					}
				}
			}


			echo json_encode($response);
                        break;
                default:
                        http_response_code(404);
                        echo json_encode(array('message'=>'Unknown API request'));
                        break;
        }
}
else{
        http_response_code(400);
        echo json_encode(array('message' => 'No endpoint specified'));
}

?>
