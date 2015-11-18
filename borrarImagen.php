<?php

$fecha = $_POST["fecha"];
$tipo = $_POST["tipo"];
$output_dir = "images/".$tipo."/".$fecha."/";
if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
{
	$fileName =$_POST['name'];
	$filePath = $output_dir. $fileName;
	if (file_exists($fileName)) 
	{
        unlink($fileName);
    }
	echo "Deleted File ".$fileName."<br>";
}

?>