<html>
<head>
<title>Attendance Sheet</title>
<meta name='viewport' content='width=device-width, initial-scale=1' />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script> -->
<script src='index.js'></script>
<link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel='stylesheet' type='text/css' href='index.css'>
</head>
<body>

<p class='datep'>Date: <input type='text' id='attdate' class='datepicker' /></p>
<script>
	var att = [
<?php
	date_default_timezone_set('America/Chicago');
	$conn = new mysqli('localhost','churchatt','hdaslkjdsflkhasdd&*8768','church');
	$att = $conn->query("select * from attendance");
	while($a = $att->fetch_assoc()){
		echo "{individ:".$a["individ"].",attdate:'".$a["attdate"]."'},\n";
	}

?>
	];
</script>
<?php
	$classes = $conn->query("select * from ssclass");
	while($c = $classes->fetch_assoc()){
		echo "<div class='classlist'><h1>".$c["classname"]."<span class='dtspan'></span></h1>";
		$r = $conn->prepare("select fname,lname,individ from classlistatt where ssid = ?");
		$r->bind_param("i",$c["ssid"]);
		$r->execute();
		$r->bind_result($fname,$lname,$individ);
		while($r->fetch()){
			echo "<p id='p-".$individ."'><label><span class='attcheck' id='checkatt-".$individ."'></span>".$fname." ".$lname."</label></p>";
		}
		echo "</div>";
	}
	
?>
<hr>
<div id='addform'>
<h1>Add a Student</h1>

<p>First Name: <input class='addme' type='text' id='addfname' name='addfname' /></p>
<p>Last Name: <input class='addme' type='text' id='addlname' name='addlname' /></p>
<p>Gender: <label><input type='radio' class='addme' value='f' id='genderf' name='gender' /> Female</label>
<label><input type='radio' class='addme' value='m' id='genderm' name='gender' /> Male</label></p>
<p>Birthdate: <input class='addme datepicker' type='text' id='addbdate' name='addbdate' /></p>
<p>Grade In School:
<select id='addgrade' class='addme' name='addgrage'>
<?php
	if(date('m') > 6 && date('m') <= 12){
		$year = date('Y')+1;
	}
	else{
		$year = date('Y');
	}
	$grades = ["Senior","Junior","Sophomore","Freshman","8th","7th","6th","5th","4th","3rd","2nd","1st","Kindergarten","Pre-K"];
	$ct = 0;
	for($i=$year;$i<$year+14;$i++){
		echo "<option value='".$i."'>".$grades[$ct]."</option>";
		$ct++;
	}
?>
</select></p>
<p>Sunday School Class: <select class='addme' id='addclass' name='addclass'>
<?php
$r = $conn->query("select * from ssclass where ssyear = ".$year);
while($j = $r->fetch_assoc()){
	echo "<option value='".$j["ssid"]."'>".$j["classname"]."</option>";
}
?>
</select></p>
<p><button id='addstudent'>Add Student</button></p>
</div>
</body>
</html>