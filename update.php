<?php
date_default_timezone_set('America/Chicago');
	$config = parse_ini_file('/var/www/ssattconfig.ini');
	
	$conn = new mysqli($config["mysqlhost"],$config["mysqluser"],$config["mysqlpassword"],$config["mysqldbname"]);
	
	if($_GET["mode"] == "addperson"){
		$sql = "insert into indiv (fname,lname,gender,bdate) values (?,?,?,?)";
		$r = $conn->prepare($sql);
		$r->bind_param("ssss",$_POST["addfname"],$_POST["addlname"],$_POST["gender"],$_POST["addbdate"]);
		$r->execute();
		$id = mysqli_insert_id($conn);
		$sql = "insert into children (individ,gradyear) values (?,?)";
		$r = $conn->prepare($sql);
		$r->bind_param("ii",$id,$_POST["addgrade"]);
		$r->execute();
		$sql = "insert into classlist (ssid,atttype,individ) values (?,'student',?)";
		$r = $conn->prepare($sql);
		$r->bind_param('ii',$_POST["addclass"],$id);
		$r->execute();
		echo "added ".$id;
	}
?>