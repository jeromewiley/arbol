<?php
	header('Content-type: text/html; charset=utf-8'); 
	require_once('function_library.php');

	$newIndividualToProcess = 'Fulano';
	if($_POST && isset($_POST['fname'])) {
		$newIndividualToProcess = $_POST['fname'];
		$update = $_POST['update'];
		// $newIndividualArray = array(
		//		'fname'  => "$_POST['fname']";
		//		'mname'  => "$_POST['mname']";
		//		'lname'  => "$_POST['lname']";
		//		'mmname' => "$_POST['mmname']";
		//		'bdate'    => "$_POST['bdate']";
	//		)
		
	}

	$personToEdit = '000';
	if ($_GET && isset($_GET['personToEdit'])) {
		$personToEdit = $_GET['personToEdit'];
	}

	if ($_POST && isset($_POST['personToEdit'])) {
		$personToEdit = $_POST['personToEdit'];
	}



	switch ($newIndividualToProcess) {

		case "Fulano":
			printHeader();
			displayNewIndividualForm($personToEdit);
			displaySearchIndividualForm();
			displayAllIndividuals();
			//displayTree();
			break;

		default:
			printHeader();
			processNewIndividual($update, $personToEdit);
			if ($update == 1) {
				displayNewIndividualForm(0);
			}
			if ($update == 0) {
				displayNewIndividualForm($personToEdit);
			}
			displaySearchIndividualForm();
			displayAllIndividuals();
			//displayTree();
			break;
	}



?>




