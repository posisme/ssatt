<html>
<head>
<title>Attendance Sheet</title>
<meta name='viewport' content='width=device-width, initial-scale=1' />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!-- <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script> -->
<link rel="stylesheet" href="/font-awesome-4.7.0/css/font-awesome.min.css">
<style>
table td{
	border:1px solid black;
	text-align:center;
}
table td:first-child{
	text-align:left;
}
table th{
	border:1px solid black;
	text-align:left;
}
</style>
</head>
<body>
<h1>Attendance Report</h1>
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
<table class='calendar'>
<tr><th>Name</th>
<?php
	$att = $conn->query("select distinct attdate from attendance");
	$dts = array();
	while($a = $att->fetch_assoc()){
		echo "<th>".$a["attdate"]."</th>";
		$dts[] = $a["attdate"];
	}
?>
</tr>
<tr><th>Totals</th>
<?php
$att = $conn->query("select count(individ) as attdatect from attendance group by attdate");

	while($a = $att->fetch_assoc()){
		echo "<th>".$a["attdatect"]."</th>";
		
	}
?>
</tr>
<?php
	$classes = $conn->query("select * from ssclass");
	while($c = $classes->fetch_assoc()){
		echo "<tr><th colspan='".(count($dts)+1)."'>".$c["classname"]."</th></tr>";
		$r = $conn->prepare("select fname,lname,individ from classlistatt where ssid = ?");
		$r->bind_param("i",$c["ssid"]);
		$r->execute();
		$r->bind_result($fname,$lname,$individ);
		
		while($r->fetch()){
			echo "<tr><td id='p-".$individ."'>".$fname." ".$lname."</td>";
			foreach($dts as $d){
				echo "<td id='".$individ."-".$d."'></td>";
			}
			echo "</tr>";
		}
		
	}
	
?>
</table>
<script>
	for(i=0;i<att.length;i++){
		$("#"+att[i].individ+"-"+att[i].attdate).css("background-color","black");
		$("#"+att[i].individ+"-"+att[i].attdate).css("color","white");
		$("#"+att[i].individ+"-"+att[i].attdate).text("P");
	}
</script>
<body>
</html>