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

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	$input = file_get_contents('php://input');
	$data = json_decode($input, true);

	$updateVisit = $data['updateVisit'];
	$updatePatient = $data['updatePatient'];
	$updatePreExisting = $data['updatePreExisting'];
	$updateTreatments = $data['updateTreatments'];
	$updateImmunizations = $data['updateImmunizations'];
	$updateObstetric = $data['updateObstetric'];
	$updateAllergies = $data['updateAllergies'];
	$updateMeds = $data['updateMeds'];
	$updateFamily = $data['updateFamily'];
	$updateSocial = $data['updateSocial'];

	$patientData = $data['patientData'];
	$patient_id = $patientData['PATIENT_ID'];

	$response = array();
	if ($updatePatient){
		$first_name = $patientData['FIRST_NAME'];
		$last_name = $patientData['LAST_NAME'];
		$dob = date('Y-m-d', strtotime($patientData['DOB']));
		$gender = $patientData['GENDER'];
		$race = $patientData['RACE'];
		$pref_language = $patientData['PREF_LANGUAGE'];
		$phone = $patientData['PHONE'];
		$street1 = $patientData['STREET1'];
		$street2 = $patientData['STREET2'];
		$city = $patientData['CITY'];
		$state = $patientData['STATE'];
		$zip = $patientData['ZIP'];

		$sql = "SELECT * from patients where patient_id=:patient_id";
		$stmt = oci_parse($conn, $sql);

		oci_bind_by_name($stmt, ':patient_id', $patient_id);

		oci_execute($stmt);
		$rows = oci_fetch_all($stmt, $res);

		if ($rows > 0){
			$sql = "UPDATE patients SET FIRST_NAME = :first_name,
			LAST_NAME = :last_name,
			DOB = :dob,
			GENDER = :gender,
			RACE = :race,
			PREF_LANGUAGE = :pref_language,
			PHONE = :phone,
			STREET1 = :street1,
			STREET2 = :street2,
			CITY = :city,
			STATE = :state,
			ZIP = :zip
			WHERE PATIENT_ID = :patient_id";
			$stmt = oci_parse($conn, $sql);

			oci_bind_by_name($stmt, ':first_name', $first_name);
			oci_bind_by_name($stmt, ':last_name', $last_name);
			oci_bind_by_name($stmt, ':dob', $dob);
			oci_bind_by_name($stmt, ':gender', $gender);
			oci_bind_by_name($stmt, ':race', $race);
			oci_bind_by_name($stmt, ':pref_language', $pref_language);
			oci_bind_by_name($stmt, ':phone', $phone);
			oci_bind_by_name($stmt, ':street1', $street1);
			oci_bind_by_name($stmt, ':street2', $street2);
			oci_bind_by_name($stmt, ':city', $city);
			oci_bind_by_name($stmt, ':state', $state);
			oci_bind_by_name($stmt, ':zip', $zip);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);

			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updatePatient Success');
			}
			else{
				array_push($response, 'updatePatient Failure');
			}
		}
		else{
			$sql = "INSERT INTO patients (PATIENT_ID, FIRST_NAME, LAST_NAME, DOB, GENDER, RACE, PREF_LANGUAGE, PHONE, STREET1, STREET2, CITY, STATE, ZIP)
        			VALUES (:patient_id, :first_name, :last_name, :dob, :gender, :race, :pref_language, :phone, :street1, :street2, :city, :state, :zip)";
			$stmt = oci_parse($conn, $sql);

			oci_bind_by_name($stmt, ':first_name', $first_name);
			oci_bind_by_name($stmt, ':last_name', $last_name);
			oci_bind_by_name($stmt, ':dob', $dob);
			oci_bind_by_name($stmt, ':gender', $gender);
			oci_bind_by_name($stmt, ':race', $race);
			oci_bind_by_name($stmt, ':pref_language', $pref_language);
			oci_bind_by_name($stmt, ':phone', $phone);
			oci_bind_by_name($stmt, ':street1', $street1);
			oci_bind_by_name($stmt, ':street2', $street2);
			oci_bind_by_name($stmt, ':city', $city);
			oci_bind_by_name($stmt, ':state', $state);
			oci_bind_by_name($stmt, ':zip', $zip);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updatePatient Success');
			}
			else{
				array_push($response, 'updatePatient Failure');
			}
		}
	}

	if ($updateVisit){
		$visitData = $data['visitData'];
		$patient_id = $visitData['PATIENT_ID'];
		$visitID = $visitData['VISIT_ID'];
		$visitDate = date('Y-m-d', strtotime($visitData['VISIT_DATE']));
		$chiefComplaint = $visitData['CHIEF_COMPLAINT'];
		$visitType = $visitData['VISIT_TYPE'];
		$diagnosis = $visitData['DIAGNOSIS'];
		$refPatientID = $visitData['REF_PATIENT_ID'];
		$refVisitID = $visitData['REF_VISIT_ID'];
		$doctorName = $visitData['DOCTOR_NAME'];
		$height = $visitData['HEIGHT'];
		$weight = $visitData['WEIGHT'];
		$notes = $visitData['NOTES'];

		$sql = "SELECT * from visits where patient_id = :patient_id and visit_id = :visitID";
		$stmt = oci_parse($conn, $sql);

		oci_bind_by_name($stmt, ':patient_id', $patient_id);
		oci_bind_by_name($stmt, ':visitID', $visitID);

		oci_execute($stmt);
		$rows = oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

		if ($rows > 0){
			$sql = "UPDATE visits SET
						VISIT_DATE = :visitDate,
						CHIEF_COMPLAINT = :chiefComplaint,
						VISIT_TYPE = :visitType,
						DIAGNOSIS = :diagnosis,
						REF_PATIENT_ID = :refPatientID,
						REF_VISIT_ID = :refVisitID,
						DOCTOR_NAME = :doctorName,
						HEIGHT = :height,
						WEIGHT = :weight,
						NOTES = :notes
						WHERE PATIENT_ID = :patient_id AND VISIT_ID = :visitID";

			$stmt = oci_parse($conn, $sql);

			oci_bind_by_name($stmt, ':visitDate', $visitDate);
			oci_bind_by_name($stmt, ':chiefComplaint', $chiefComplaint);
			oci_bind_by_name($stmt, ':visitType', $visitType);
			oci_bind_by_name($stmt, ':diagnosis', $diagnosis);
			oci_bind_by_name($stmt, ':refPatientID', $refPatientID);
			oci_bind_by_name($stmt, ':refVisitID', $refVisitID);
			oci_bind_by_name($stmt, ':doctorName', $doctorName);
			oci_bind_by_name($stmt, ':height', $height);
			oci_bind_by_name($stmt, ':weight', $weight);
			oci_bind_by_name($stmt, ':notes', $notes);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			oci_bind_by_name($stmt, ':visitID', $visitID);

			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateVisit Success');
			}
			else{
				array_push($response, 'updateVisit Failure');
			}
		}
		else{
			// row doesn't exist, insert a new row instead
			$sql_insert = "INSERT INTO visits (PATIENT_ID, VISIT_ID, VISIT_DATE, CHIEF_COMPLAINT, VISIT_TYPE, DIAGNOSIS, REF_PATIENT_ID, REF_VISIT_ID, DOCTOR_NAME, HEIGHT, WEIGHT, NOTES) 
							VALUES (:patient_id, :visitID, :visitDate, :chiefComplaint, :visitType, :diagnosis, :refPatientID, :refVisitID, :doctorName, :height, :weight, :notes)";
			$stmt = oci_parse($conn, $sql_insert);

			oci_bind_by_name($stmt, ':visitDate', $visitDate);
			oci_bind_by_name($stmt, ':chiefComplaint', $chiefComplaint);
			oci_bind_by_name($stmt, ':visitType', $visitType);
			oci_bind_by_name($stmt, ':diagnosis', $diagnosis);
			oci_bind_by_name($stmt, ':refPatientID', $refPatientID);
			oci_bind_by_name($stmt, ':refVisitID', $refVisitID);
			oci_bind_by_name($stmt, ':doctorName', $doctorName);
			oci_bind_by_name($stmt, ':height', $height);
			oci_bind_by_name($stmt, ':weight', $weight);
			oci_bind_by_name($stmt, ':notes', $notes);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			oci_bind_by_name($stmt, ':visitID', $visitID);

			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateVisit Success');
			}
			else{
				array_push($response, 'updateVisit Failure');
			}
		}
	}

	if ($updatePreExisting){
		$preExistingList = $data['preExistingData'];

		$sql = "SELECT * from preexistingconditions where patient_id=:patient_id";
		$stmt = oci_parse($conn, $sql);

		oci_bind_by_name($stmt, ':patient_id', $patient_id);

		oci_execute($stmt);
		$rows = oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

		if ($rows > 0){
			$sql = "DELETE FROM preexistingconditions WHERE patient_id = :patient_id";


			$stmt = oci_parse($conn, $sql);

			oci_bind_by_name($stmt, ':patient_id', $patient_id);

			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updatePreExisting Success');
			}
			else{
				array_push($response, 'updatePreExisting Failure');
			}
		}
		// // Assuming $preExistingList contains an array of conditions
		foreach ($preExistingList as $row_val) {
			$condition = $row_val['CONDITION'];
			$sql = "INSERT INTO preexistingconditions (PATIENT_ID, CONDITION) VALUES (:patient_id, :condition)";
			$stmt = oci_parse($conn, $sql);

			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			oci_bind_by_name($stmt, ':condition', $condition);

			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updatePreExisting Success');
			}
			else{
				array_push($response, 'updatePreExisting Failure');
			}
		}
	}

	if ($updateImmunizations){
		$immunizationList = $data['immunizationList'];

		$sql = "select * from immunizations where patient_id=:patient_id";
		$stmt = oci_parse($conn, $sql);

		oci_bind_by_name($stmt, ':patient_id', $patient_id);

		oci_execute($stmt);
		$rows = oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

		if ($rows > 0){
			$sql = "DELETE FROM immunizations WHERE patient_id = :patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateImmunizations Success');
			}
			else{
				array_push($response, 'updateImmunizations Failure');
			}
		}
		foreach ($immunizationList as $row_val) {
			$immunization = $row_val['IMMUNIZATION'];
			$sql = "INSERT INTO immunizations (PATIENT_ID, IMMUNIZATION) VALUES (:patient_id, :immunization)";
			$stmt = oci_parse($conn, $sql);

			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			oci_bind_by_name($stmt, ':immunization', $immunization);

			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateImmunizations Success');
			}
			else{
				array_push($response, 'updateImmunizations Failure');
			}
		}
	}

	if ($updateFamily){
		$familyData = $data['familyData'];
		$sql = "select * from familyhistory where patient_id=:patient_id";
		$stmt = oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':patient_id', $patient_id);
		oci_execute($stmt);
		$rows = oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	
		if ($rows > 0){
			$sql = "DELETE FROM familyhistory WHERE patient_id = :patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateFamily Success');
			}
			else{
				array_push($response, 'updateFamily Failure');
			}
		}
	
		foreach ($familyData as $row_val) {
			$relative = $row_val['RELATIVE1'];
			$affliction = $row_val['AFFLICTION'];
			$sql = "INSERT INTO familyhistory (PATIENT_ID, AFFLICTION, RELATIVE1) VALUES (:patient_id, :affliction, :relative)";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			oci_bind_by_name($stmt, ':affliction', $affliction);
			oci_bind_by_name($stmt, ':relative', $relative);
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateFamily Success');
			}
			else{
				array_push($response, 'updateFamily Failure');
			}
		}
	}
	
	if ($updateMeds){
		$medData = $data['medData'];
		$sql_select = "SELECT * FROM medications WHERE patient_id=:patient_id";
		$stmt_select = oci_parse($conn, $sql_select);
		oci_bind_by_name($stmt_select, ':patient_id', $patient_id);
		oci_execute($stmt_select);
		$rows = oci_fetch_all($stmt_select, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	
		if ($rows > 0){
			$sql_delete = "DELETE FROM medications WHERE patient_id=:patient_id";
			$stmt_delete = oci_parse($conn, $sql_delete);
			oci_bind_by_name($stmt_delete, ':patient_id', $patient_id);
			$result = oci_execute($stmt_delete);
			if ($result){
				array_push($response, 'updateMeds Success');
			}
			else{
				array_push($response, 'updateMeds Failure');
			}
		}
	
		foreach ($medData as $row_val) {
			$medication = $row_val['MEDICATION'];
			$activestatus = $row_val['ACTIVE'];
			$sql_insert = "INSERT INTO medications (PATIENT_ID, MEDICATION, ACTIVE) VALUES (:patient_id, :medication, :activestatus)";
			$stmt_insert = oci_parse($conn, $sql_insert);
			oci_bind_by_name($stmt_insert, ':patient_id', $patient_id);
			oci_bind_by_name($stmt_insert, ':medication', $medication);
			oci_bind_by_name($stmt_insert, ':activestatus', $activestatus);

			$result = oci_execute($stmt_insert);
			if ($result){
				array_push($response, 'updateMeds Success');
			}
			else{
				array_push($response, 'updateMeds Failure');
			}
		}
	}
	

	if ($updateAllergies){
		$allergyData = $data['allergiesData'];
	
		$sql = "select * from allergies where patient_id=:patient_id";
		$stmt = oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':patient_id', $patient_id);
		oci_execute($stmt);
		$rows = oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	
		if ($rows > 0){
			$sql = "DELETE FROM allergies WHERE patient_id = :patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateAllergies Success');
			}
			else{
				array_push($response, 'updateAllergies Failure');
			}
		}
		foreach ($allergyData as $row_val) {
			$allergy = $row_val['ALLERGY'];
			$sql = "INSERT INTO allergies (PATIENT_ID, ALLERGY) VALUES (:patient_id, :allergy)";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			oci_bind_by_name($stmt, ':allergy', $allergy);
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateAllergies Success');
			}
			else{
				array_push($response, 'updateAllergies Failure');
			}
		}
	}
	

	if ($updateObstetric){
		$obstetricData = $data['obstetricData'];
		$sql = "select * from obstetrichistory where patient_id=:patient_id";
		$stmt = oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':patient_id', $patient_id);
		oci_execute($stmt);
		$rows = oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	
		if ($rows > 0){
			$sql = "DELETE FROM obstetrichistory WHERE patient_id = :patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateObstetric Success');
			}
			else{
				array_push($response, 'updateObstetric Failure');
			}
		}
	
		foreach ($obstetricData as $row_val) {
			$start_date = date('Y-m-d', strtotime($row_val['STARTDATE']));
			$end_date = date('Y-m-d', strtotime($row_val['ENDDATE']));
			$sql = "INSERT INTO obstetrichistory (PATIENT_ID, STARTDATE, ENDDATE) VALUES (:patient_id, :start_date, :end_date)";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			oci_bind_by_name($stmt, ':start_date', $start_date);
			oci_bind_by_name($stmt, ':end_date', $end_date);
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateObstetric Success');
			}
			else{
				array_push($response, 'updateObstetric Failure');
			}
		}
	}
	

	if ($updateTreatments){
		$treatmentData = $data['treatmentData'];
		$deleted_treatments = $data['deleteTreatments'];
	
		foreach ($deleted_treatments as $id){
			$sql = "delete from treatments where treatment_id=:id";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':id', $id);
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateTreatments Success');
			}
			else{
				array_push($response, 'updateTreatments Failure');
			}
		}
	
		foreach ($treatmentData as $treatment){
			$treatmentID = $treatment['TREATMENT_ID'];
			$keywordDesc = $treatment['KEYWORD_DESC'];
			$treatmentType = $treatment['TREATMENT_TYPE'];
			$duration = $treatment['DURATION'];
			$success = $treatment['SUCCESS'];
			$visitID = $treatment['VISIT_ID'];
	
			$sql = "select * from treatments where treatment_id=:treatmentID";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':treatmentID', $treatmentID);
			oci_execute($stmt);
			$rows = oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
			
			if ($rows > 0){
				$sql = "UPDATE treatments SET
					KEYWORD_DESC = :keywordDesc,
					TREATMENT_TYPE = :treatmentType,
					DURATION = :duration,
					SUCCESS = :success
					WHERE TREATMENT_ID = :treatmentID";
				$stmt = oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':keywordDesc', $keywordDesc);
				oci_bind_by_name($stmt, ':treatmentType', $treatmentType);
				oci_bind_by_name($stmt, ':duration', $duration);
				oci_bind_by_name($stmt, ':success', $success);
				oci_bind_by_name($stmt, ':treatmentID', $treatmentID);
				$result = oci_execute($stmt);
				if ($result){
					array_push($response, 'updateTreatments Success');
				}
				else{
					array_push($response, 'updateTreatments Failure');
				}
			}
			else{
				$sql = "INSERT INTO treatments (PATIENT_ID, VISIT_ID, KEYWORD_DESC, TREATMENT_TYPE, DURATION, SUCCESS)
					VALUES (:patient_id, :visitID, :keywordDesc, :treatmentType, :duration, :success)";
				$stmt = oci_parse($conn, $sql);
				oci_bind_by_name($stmt, ':patient_id', $patient_id);
				oci_bind_by_name($stmt, ':visitID', $visitID);
				oci_bind_by_name($stmt, ':keywordDesc', $keywordDesc);
				oci_bind_by_name($stmt, ':treatmentType', $treatmentType);
				oci_bind_by_name($stmt, ':duration', $duration);
				oci_bind_by_name($stmt, ':success', $success);
				$result = oci_execute($stmt);
				if ($result){
					array_push($response, 'updateTreatments Success');
				}
				else{
					array_push($response, 'updateTreatments Failure');
				}
			}
		}
	}
	
	if ($updateSocial){
		$socialData = $data['socialData'];
	
		$marriage = $socialData['MARRIAGE'];
		$occupation = $socialData['OCCUPATION'];
		$exercise = $socialData['EXERCISE'];
		$alcohol = $socialData['ALCOHOL'];
		$smoking = $socialData['SMOKING'];
	
		$sql = "select * from socialhistory where patient_id=:patient_id";
		$stmt = oci_parse($conn, $sql);
		oci_bind_by_name($stmt, ':patient_id', $patient_id);
		oci_execute($stmt);
		$rows = oci_fetch_all($stmt, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);
	
		if ($rows > 0){
			$sql = "UPDATE socialhistory SET
				MARRIAGE = :marriage,
				OCCUPATION = :occupation,
				EXERCISE = :exercise,
				ALCOHOL = :alcohol,
				SMOKING = :smoking
				WHERE patient_id = :patient_id";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':marriage', $marriage);
			oci_bind_by_name($stmt, ':occupation', $occupation);
			oci_bind_by_name($stmt, ':exercise', $exercise);
			oci_bind_by_name($stmt, ':alcohol', $alcohol);
			oci_bind_by_name($stmt, ':smoking', $smoking);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateSocial Success');
			}
			else{
				array_push($response, 'updateSocial Failure');
			}
		}
		else{
			$sql = "insert into socialhistory (PATIENT_ID, MARRIAGE, OCCUPATION, EXERCISE, ALCOHOL, SMOKING)
					values (:patient_id, :marriage, :occupation, :exercise, :alcohol, :smoking)";
			$stmt = oci_parse($conn, $sql);
			oci_bind_by_name($stmt, ':patient_id', $patient_id);
			oci_bind_by_name($stmt, ':marriage', $marriage);
			oci_bind_by_name($stmt, ':occupation', $occupation);
			oci_bind_by_name($stmt, ':exercise', $exercise);
			oci_bind_by_name($stmt, ':alcohol', $alcohol);
			oci_bind_by_name($stmt, ':smoking', $smoking);
			$result = oci_execute($stmt);
			if ($result){
				array_push($response, 'updateSocial Success');
			}
			else{
				array_push($response, 'updateSocial Failure');
			}
		}
	}
	

	echo json_encode($response);

}

?>
