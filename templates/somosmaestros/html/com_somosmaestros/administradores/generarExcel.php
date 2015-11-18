<?

$idCampana = $_POST['campana'];
$tipo = $_POST['tipo'];
$publicacion = $_POST['publicacion'];


 header("Content-type: application/vnd.ms-excel");
 $dia = date('d/m/Y');
 header("Content-Disposition:  filename=\"Campana ".$publicacion."- Tipo: ".$tipo." - Fecha: ".$dia.".XLS\";");


$host = 'localhost';
$user = 'smaestro_joomla';
$password = 'S0m0sM43str0s#';
$database = 'smaestro_smjoomla';

// Create and connection
$db = mysql_connect($host, $user, $password) or die("Could not connect database");
mysql_select_db($database, $db) or die("Could not select database Joomla");


$servername = "208.117.45.85";
$username = "smbrujul_somosma";
$password2 = "R;(z=fE!95Ss";
$database2 = "smbrujul_produccion";

// Create and connection
$db2 = mysql_connect($servername, $username, $password2) or die("Could not connect database");
mysql_select_db($database2, $db2) or die("Could not select database Brújula");


if($tipo == 'Formación'){
	$result2=mysql_query('SELECT `cedula`, `asistio` FROM `mpn7k_somosmaestros_asistentes_formacion` WHERE `formacion` = '.$publicacion.' ', $db);
} else if($tipo == 'Blog'){
	$result2=mysql_query('SELECT `cedula`, `blog` FROM `mpn7k_somosmaestros_campana_blog` WHERE `campana` = '.$id.' AND `blog` = '.$publicacion.' ', $db);
} else if($tipo == 'Perfil'){
	$result2=mysql_query('SELECT `cedula`, FROM `mpn7k_somosmaestros_campana_perfil` WHERE `campana` = '.$id.'', $db);
}



if($tipo == 'Formación'){
	echo "

	<table border='1'>
		<tr>
		<td align='center' style='font-size:14px' colspan='9'><strong>Dia ".$dia." - ".$tipo.": ".$Publicación."</strong></td>
	   

	  </tr>
	   <tr>
	    <td align='center' style='font-size:14px'><strong>Asistio</strong></td>
	    <td align='center' style='font-size:14px'><strong>Cedula</strong></td>
	    <td align='center' style='font-size:14px'><strong>Nombre</strong></td>
	    <td align='center' style='font-size:14px'><strong>Primer Apellido</strong></td>
	    <td align='center' style='font-size:14px'><strong>Segundo Apellido</strong></td>


	  </tr>
	";
} else if($tipo == 'Blog'){
	echo "

	<table border='1'>
		<tr>
		<td align='center' style='font-size:14px' colspan='9'><strong>Dia ".$dia." - ".$tipo.": ".$Publicación."</strong></td>
	   

	  </tr>
	   <tr>
	    <td align='center' style='font-size:14px'><strong>Blog</strong></td>
	    <td align='center' style='font-size:14px'><strong>Cedula</strong></td>
	    <td align='center' style='font-size:14px'><strong>Nombre</strong></td>
	    <td align='center' style='font-size:14px'><strong>Primer Apellido</strong></td>
	    <td align='center' style='font-size:14px'><strong>Segundo Apellido</strong></td>


	  </tr>
	";
} if($tipo == 'Perfil'){
	echo "

	<table border='1'>
		<tr>
		<td align='center' style='font-size:14px' colspan='9'><strong>Dia ".$dia." - ".$tipo."</strong></td>
	   

	  </tr>
	   <tr>
	    <td align='center' style='font-size:14px'><strong>Cedula</strong></td>
	    <td align='center' style='font-size:14px'><strong>Nombre</strong></td>
	    <td align='center' style='font-size:14px'><strong>Primer Apellido</strong></td>
	    <td align='center' style='font-size:14px'><strong>Segundo Apellido</strong></td>


	  </tr>
	";
}

if($tipo == 'Formación'){
	while( $row2 = @mysql_fetch_row($result2) ) 

		{
			$result=mysql_query('SELECT `PeIdentificacion`, `PeNombres`, `PePrimerApellido`, `PeSegundoApellido` FROM `personas` WHERE `PeIdentificacion` ="'.$row2[0].'"',$db2);
			$row = @mysql_fetch_row($result);

				echo " 


					<td align='center'>$row2[1]</td>
				    <td align='center'>$row2[0]</td>
				    <td align='center'>$row[1]</td>
					<td align='center'>$row[2]</td>
					<td align='center'>$row[3]</td>
					

				  </tr>
				  

				  ";

		}		 
} else if($tipo == 'Blog'){
	while( $row2 = @mysql_fetch_row($result2) ) 

		{
			$result=mysql_query('SELECT `PeIdentificacion`, `PeNombres`, `PePrimerApellido`, `PeSegundoApellido` FROM `personas` WHERE `PeIdentificacion` ="'.$row2[0].'"',$db2);
			$row = @mysql_fetch_row($result);

				echo " 


					<td align='center'>$row2[1]</td>
				    <td align='center'>$row2[0]</td>
				    <td align='center'>$row[1]</td>
					<td align='center'>$row[2]</td>
					<td align='center'>$row[3]</td>
					

				  </tr>
				  

				  ";

		}		 
} else if ($tipo == 'Perfil'){
	while( $row2 = @mysql_fetch_row($result2) ) 

		{
			$result=mysql_query('SELECT `PeIdentificacion`, `PeNombres`, `PePrimerApellido`, `PeSegundoApellido` FROM `personas` WHERE `PeIdentificacion` ="'.$row2[0].'"',$db2);
			$row = @mysql_fetch_row($result);

				echo " 


					<td align='center'>$row2[1]</td>
				    <td align='center'>$row2[0]</td>
				    <td align='center'>$row[1]</td>
					<td align='center'>$row[2]</td>
					<td align='center'>$row[3]</td>
					

				  </tr>
				  

				  ";

		}

}

echo "</table>";



?>
