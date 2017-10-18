<?php
	date_default_timezone_set('America/Chicago');
	$conn = new mysqli('localhost','churchatt','hdaslkjdsflkhasdd&*8768','church');
	if($_GET["mode"] == "add"){
		$sql = "insert into attendance (attdate,individ) values (?,?)";
	}
	else{
		$sql = "delete from attendance where attdate = ? and individ = ?";
	}
	echo $sql;
	$r = $conn->prepare($sql);
	
	$r->bind_param("si",$_GET["dt"],$_GET["id"]);
	echo json_encode($r);
	$v = $r->execute();
	echo json_encode($v);
	$r->close();
	$conn->close();
?>