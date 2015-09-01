<?php

print_r($_POST);

	$con = new PDO('mysql:host=crtreesorg.fatcowmysql.com;dbname=crtrees',"crtreesadmin","G0whalephants1!");
	$q = $con->prepare("INSERT INTO `trees` (`Species`, `Height`, `Lat`, `Long`, `Health`) VALUES (:Species, :Height, $_POST[lat], $_POST[longi], '$_POST[he]')");
	$q->bindParam(':Species', $_POST[s], PDO::PARAM_INT);
	$q->bindParam(':Height', $_POST[h], PDO::PARAM_INT);
	$q->execute();
	$con->errorInfo();
	$con = NULL;
?>