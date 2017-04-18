<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery.form.min.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
	var options = { 
			target: '#output',   // target element(s) to be updated with server response 
			beforeSubmit: beforeSubmit,  // pre-submit callback 
			success: afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
}); 

function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#imageInput').val()) //check empty input filed
		{
			$("#output").html("Are you kidding me?");
			return false
		}
		
		var fsize = $('#imageInput')[0].files[0].size; //get file size
		var ftype = $('#imageInput')[0].files[0].type; // get file type
		

		//allow only valid image file types 
		switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 1 MB (1048576)
		if(fsize>1048576) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older browsers that do not support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}
</script>
</head>

<?php

function displayNewIndividualForm($personToEdit) {

	switch ($personToEdit){

		// ADDING SOMEONE NEW
	case 0:

		echo "<div class=\"formbubble\">\n";
		echo "<div class=\"logo\"><img src=\"images\logocolumn.png\"></div>\n";
		echo "<form class=\"indivSearch\" name=\"searchIndividual\" method=\"post\" action=\"index.php\">";
		echo "<input name=\"indiv\" type=\"search\" placeholder=\"search - busqueda\" results=\"0\">";
		echo "</form>\n";

		echo "<form name = \"addPersonForm\" class=\"bubble\" action=\"index.php\" method=\"post\">\n";
		echo "<div class=\"form-heading\">Add someone<br>Añadir a alguien</div>\n";
		echo "<input class=\"bubble\" type=\"hidden\" name=\"update\" value=\"0\">\n";
		echo "<input class=\"bubble\" type=\"text\" name=\"fname\"    placeholder=\"name/nombre\"> <br>\n";
		echo "<input class=\"bubble\" type=\"text\" name=\"mname\"    placeholder=\"middle name/2do nombre\"> <br>\n";
		echo "<input class=\"bubble\" type=\"text\" name=\"nickname\" placeholder=\"nickname/apodo\"><br>\n";
		echo "<input class=\"bubble\" type=\"text\" name=\"lname\"    placeholder=\"last name/apellido\"><br>\n";
		echo "<input class=\"bubble\" type=\"text\" name=\"mmname\"   placeholder=\"mother's/2do apellido\"><br>\n";
		echo "<input class=\"bubble\" type=\"date\" name=\"dob\"      value=\"1950-01-01\"><br>\n";
		echo "<input class=\"bubble\" type=\"submit\" name=\"submit\">\n";
		echo "</form>\n";
		echo "</div>";
	break;

		// EDITING AN EXISTING INDIVIDUAL
	default:

		echo "<div class=\"formbubble\">\n";
		echo "<div class=\"logo\"><img src=\"images\logocolumn.png\"></div>\n";
		echo "<form class=\"indivSearch\" name=\"searchIndividual\" method=\"post\" action=\"index.php\">";
		echo "<input name=\"indiv\" type=\"search\" placeholder=\"search - busqueda\" results=\"0\">";
		echo "</form>\n";

		echo "<form name=\"editPersonForm\" class=\"bubble\" action=\"index.php\" method=\"post\">\n";
		echo "Edit record $personToEdit<br>Editar archivo $personToEdit<br>\n";

			$hostname = "wdgenealogy.db.6033761.hostedresource.com";
			$username = "wdgenealogy";
			$dbname = "wdgenealogy";
			$password = "Verano2015!";
			$usertable = "indiv";
			//Connecting to your database
			mysql_connect($hostname, $username, $password) OR DIE ("Unable to
			connect to database! Please try again later.");
			$sql =  "SELECT iid, fname, mname, nickname, lname, mmname, dob " .
					"FROM indiv WHERE iid = $personToEdit";	
			mysql_select_db($dbname);
			//Entering new line into table.
			$currentInfoPerson = mysql_query($sql);
			$row = mysql_fetch_assoc($currentInfoPerson);
			$fname   =  $row['fname'];
			$mname   =  $row['mname'];
			$nickname = $row['nickname'];
			$lname   =  $row['lname'];
			$mmname  =  $row['mmname'];
			$dob     =  $row['dob'];
			$displayCompactor = $fname . " " . $mname . " " . $nickname . " " . $lname . " " . $mmname;

		echo "<input class=\"bubble\" type=\"hidden\" name=\"update\" value=\"1\">\n";
		echo "<input class=\"bubble\" type=\"hidden\" name=\"personToEdit\" value=\"$personToEdit\">\n";
		echo "<input class=\"bubble\" type=\"text\" name=\"fname\"    value=\"$fname\"><br>\n";
		echo "<input class=\"bubble\" type=\"text\" name=\"mname\"    value=\"$mname\"><br>\n";
		echo "<input class=\"bubble\" type=\"text\" name=\"nickname\" value=\"$nickname\"><br>\n";
		echo "<input class=\"bubble\" type=\"text\" name=\"lname\"    value=\"$lname\"><br>\n";
		echo "<input class=\"bubble\" type=\"text\" name=\"mmname\"   value=\"$mmname\"><br>\n";
		echo "<input class=\"bubble\" type=\"date\" name=\"dob\"    value=\"$dob\"><br>\n";
		echo "<select name = \"relation\">";
		echo "<option value = \"0\">Link relative</option>";
		echo "<option value = \"1\">Parent | Padre </option>";
		echo "<option value = \"3\">Sibling | Hermano</option>";
		echo "<option value = \"4\">Spouse | Conyuge</option>";
		echo "</select>";
		echo "<select name = \"relatedindiv\">";
		echo "<option value=\"0\">Person to link</option>";

			$hostname = "wdgenealogy.db.6033761.hostedresource.com";
			$username = "wdgenealogy";
			$dbname = "wdgenealogy";
			$password = "Verano2015!";
			$usertable = "indiv";

			//Connecting to your database
			mysql_connect($hostname, $username, $password) OR DIE ("Unable to
			connect to database! Please try again later.");
			$sql = 	"SELECT iid, fname, mname, nickname, lname, mmname, dob FROM indiv ORDER BY fname ASC";
			mysql_select_db($dbname);
			//Entering new line into table.
			$result = mysql_query($sql);

			$rownum = 0;
			if ($result) {
			
			    while($row = mysql_fetch_array($result)) {
			    	$iid = $row["iid"];
			        $firstname = $row["fname"];
			        $middlename = $row["mname"];
			        if ($middlename == "nmn") {
			        	$middlename = '';
			        }
			        $nickname = $row["nickname"];
			        $lastname = $row["lname"];
			        $mmaidenname = $row["mmname"];
			        if ($mmaidenname == "n/a") {
			        	$mmaidenname = '';
			        }
			        $superyear = $row["dob"];
			        $yearonly = date("Y", $row["dob"]);
			        $rownum++;
			        $fiftychar = $firstname . " " . $middlename . " " . $nickname . " " . $lastname . " " . $mmaidenname;
			        $fiftychar = substr($fiftychar, 0, 20);
			        echo "<option value = \"$iid\">";
			        echo "$fiftychar</option>";
			
					}
			}
		echo "</select>\n";
		echo "<input class=\"bubble\" type=\"submit\" name=\"submit\">\n";
		echo "</form>\n";
		echo "</div>\n";

		// -------------------------------
		// --                           --
		// -- IMAGE UPLOADER GOES HERE  --
		// --                           --
		// -------------------------------
	
		$displayCompact = preg_replace('!\s+!', ' ', $displayCompactor);
?>
		<div id="upload-wrapper">
		<div align="center">
		<h3><?php 
				echo "Add image for $displayCompact"; 
				?>
		</h3>
		<form action="processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
		<input name="image_file" id="imageInput" type="file" value="Choose" />
		<?php 
			echo "<input name=\"iidtransfer\" value=\"$personToEdit\" type=\"hidden\">\n";
			?>
		<input type="submit"  id="submit-btn" value="Upload" />
		<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
		</form>
		<div id="output"></div>
		</div>
		</div>
<?php

	}
}



function processNewIndividual($update, $personToEdit) {
	
	$hostname = "wdgenealogy.db.6033761.hostedresource.com";
	$username = "wdgenealogy";
	$dbname = "wdgenealogy";
	$password = "Verano2015!";
	$usertable = "indiv";
	$fname = $_POST['fname'];
	$mname = $_POST['mname'];
	$nickname = $_POST['nickname'];
	$lname = $_POST['lname'];
	$mmname = $_POST['mmname'];
	$dob = $_POST['dob'];
	$relation = $_POST['relation'];
	$relatedindiv = $_POST['relatedindiv'];

	switch ($update){
		case 0:
			echo "<p class=\"bubble messagefader\">Processing new individual ... $fname $lname</p>\n";
		break;

		default:
			echo "<p class=\"bubble messagefader\">Updating individual $personToEdit</p>\n";
		break;
	}

	//Connecting to your database
	mysql_connect($hostname, $username, $password) OR DIE ("Unable to
	connect to database! Please try again later.");

	//echo "<p class=\"lowbubble messagefader\"><b>Database activity monitor: $fname added to DB.</b>\n";
	//echo "SQL query as follows:\n";
	//echo "<span class = \"sqlfont\">INSERT INTO indiv " . 
	//		"(fname, lname, dob, place_birth, dod, place_death, mname, mmname, nickname) " .
	//		"VALUES ($fname, $lname, $dob, '', '', '', $mname, $mmname, $nickname) </span></p>";

	switch ($update){

		case 0:

			$sql = 	"INSERT INTO indiv " .
					"(fname, lname, dob, place_birth, dod, place_death, mname, mmname, nickname) " .
					"VALUES  ('$fname', '$lname', '$dob', '', '', '', '$mname', '$mmname', '$nickname')";

			mysql_select_db($dbname);
			//Entering new line into table.
			$retval = mysql_query($sql);
			if(! $retval ) {
				die('Could not enter data: ' . mysql_error());
			}
		break;

		case 1:

			$sql = 	"UPDATE indiv " .
					"SET fname = '$fname', lname = '$lname', dob = '$dob', " .
					"mname = '$mname', mmname = '$mmname', nickname = '$nickname' " .
					"WHERE iid = $personToEdit";

			mysql_select_db($dbname);
			//Entering new line into table.
			$retval = mysql_query($sql);
				if(! $retval ) {
					die('Could not enter data: ' . mysql_error());
				}

			if ($relation > 0){
			$sqlcheck = "SELECT COUNT(*) AS preexisting FROM relat " .
						"WHERE (oid = $personToEdit AND did = $relatedindiv)";
			$retvalcheck = mysql_query($sqlcheck);
				if(! $retvalcheck ) {
					die('Could not enter data: ' . mysql_error());
				}

				if ($retvalcheck) {
					while($row = mysql_fetch_array($retvalcheck)) {
					$preexisting = $row["preexisting"];
					}
					if ($preexisting < 1) {

						$generationSelfSQL = "SELECT generation FROM indiv WHERE oid = $personToEdit";
						$retGenSelf = mysql_query($generationSelfSQL);
							if(! $retGenSelf) {
								die('Could not enter data: ' . mysql_error());
							}

						$sqlrelationinsert =	"INSERT INTO relat " .
								"(oid, did, rtype) " . 
								"VALUES ($personToEdit, $relatedindiv, $relation)";
						$retval2 = mysql_query($sqlrelationinsert);
							if(! $retval2 ) {
								die('Could not enter data: ' . mysql_error());
							}

					} else {

						$sqlrelationupdate = "UPDATE relat " .
									"SET rtype = $relation " .
									"WHERE (oid = $personToEdit AND did = $relatedindiv)";
						$retvalrelationupdate = mysql_query($sqlrelationupdate);
							if(! $retvalrelationupdate ) {
								die('Could not enter data: ' . mysql_error());
							}
					}
				}
			}

		break;

		default:
			$sql = '';
		break;
	}




}


function printHeader() {
	echo "<html>";
	echo "<head>";
  	echo "<title>Genealogy - Genealogia</title>";
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"portal.css\" media=\"screen\" />";
	echo "<link href='http://fonts.googleapis.com/css?family=Francois+One' rel='stylesheet' type='text/css'>";
	echo "<link href='http://fonts.googleapis.com/css?family=Nunito:300' rel='stylesheet' type='text/css'>";
	echo "<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>";
	echo "</head>";
	echo "<body class=\"mainportal\">";
	echo "<p class=\"headline\">GENEALOGY PAGE | PAGINA DE GENEALOGIA</p>\n";
}

function displaySearchIndividualForm() {

}

function displayAllIndividuals() {
	echo "<div class=\"container\">\n";
    echo "<div class=\"listfull\">\n";

	$hostname = "wdgenealogy.db.6033761.hostedresource.com";
	$username = "wdgenealogy";
	$dbname = "wdgenealogy";
	$password = "Verano2015!";
	$usertable = "indiv";

	//Connecting to your database
	mysql_connect($hostname, $username, $password) OR DIE ("Unable to
	connect to database! Please try again later.");
	$sql = 	"SELECT iid, fname, mname, nickname, " .
			"lname, mmname, dob, generation  " .
			"FROM indiv ORDER BY fname ASC";
	mysql_select_db($dbname);
	//Entering new line into table.
	$result = mysql_query($sql);

	$rownum = 0;

	echo "<div class=\"infobox\">\n";
	echo "<p id=\"infoboxheader\">Select someone | Elige a alguien</p>\n";
	echo "<p id=\"infoboxcontent\">The family information in Cousins&#8482 is displayed as a series of cousin layers. ";
	echo "Rather than use the traditional architecture of genealogy family trees, here you will see a fresh ";
	echo "approach to the challenge of displaying an open ended number of related individuals, and a larger ";
	echo "degree of flexibility than that allowed by competing systems.</p>\n";
	echo "</div>\n";

	if ($result) {
	
	    echo "<table class=\"main\">";
	    echo "<tr><td><a href=\"index.php\">Clear</a></td> " .
	    		"<td colspan=\"2\">Name / nombre</td><td>Nickname/apodo</td> " .
	    		"<td colspan=\"2\">Last names/apellidos</td><td>Born</td></tr>";
	    while($row = mysql_fetch_array($result)) {
	    	$nickname = '';
	    	$iid = $row["iid"];
	        $firstname = $row["fname"];
	        $middlename = $row["mname"];
	        if ($middlename == "nmn") {
	        	$middlename = '';
	        }
	        if ($row["nickname"]) {
	        	$nickname = "(" . $row["nickname"] . ")";
	        }
	        $lastname = $row["lname"];
	        $mmaidenname = $row["mmname"];
	        if ($mmaidenname == "n/a") {
	        	$mmaidenname = '';
	        }
	        $superyear = $row["dob"];
	        $yearonly = date("Y", $row["dob"]);
	        $generation = $row["generation"];
	        $rownum++;
	        $displayCompactor = $firstname . " " . $middlename . " " . $nickname . " " . $lastname . " " . $mmaidenname;
	        $displayCompact = preg_replace('!\s+!', ' ', $displayCompactor);
	        $generationArray[$generation][]['displayName'] = $displayCompact;  
	        $generationArray[$generation][]['dob'] = $superyear;

	        echo "<tr class=\"listfull\"><td>";
	        echo "$rownum</td><td>$firstname</td><td>$middlename</td>" . 
	         "<td>$nickname</td>" . 
	         "<td>$lastname</td><td>$mmaidenname</td>" . 
	         "<td>$superyear</td>" .
	         "<td><a class=\"button\" " .
	         "href=\"http://www.wileydata.com/arbol/index.php?personToEdit=$iid\">Edit</a></td>" .
	         "</tr>\n"; 
		    }
		echo "</table>\n";
	echo "</div>";
	}



	echo "<div class=\"treeBlock\">\n";
	for ($i = 4997; $i < 5002; $i++) {	
		echo "<span class=\"treeBlock\">\n";
		if ($generationArray[$i]) {
			$counter = 0;
			foreach ($generationArray[$i] as $cousin) {
				$displayIt = $cousin['displayName'];
				$counter++;
				if ($counter < 100) {
					if ($displayIt) {
				  		echo "<img src=\"images\personblob.png\" title=\"$displayIt\">\n"; 
					} 
				} else {
				echo "<img src=\"images\person20pxmore3.png\" title=\"Click to view more cousins.\">\n";
				break;
				}
			}
		}
		echo "</span>\n";
	}
  	echo "</div>\n";

	if(! $result ) {
		die('Could not access data: ' . mysql_error());
	}



	echo "</div>\n"; // end-div for class=container
	
}

