<?

$idFormacion = $_POST['formacion'];

 header("Content-type: application/vnd.ms-excel");
 $dia = date('d/m/Y');
 header("Content-Disposition:  filename=\"Formación ".$idFormacion." - Fecha: ".$dia.".XLS\";");

$servername = "208.117.45.85";
$username = "smbrujul_somosma";
$password = "R;(z=fE!95Ss";
$database = "smbrujul_produccion";

// Create and connection
$db = mysql_connect($servername, $username, $password) or die("Could not connect database");
mysql_select_db($database, $db) or die("Could not select database Brújula");


$host = 'localhost';
$user = 'smaestro_joomla';
$password2 = 'S0m0sM43str0s#';
$database2 = 'smaestro_smjoomla';

// Create and connection
$db2 = mysql_connect($host, $user, $password2) or die("Could not connect database");
mysql_select_db($database2, $db2) or die("Could not select database Joomla");

$result2=mysql_query('SELECT `cedula`, `id`, `asistio` FROM `mpn7k_somosmaestros_asistentes_formacion` WHERE state = 1 AND `formacion` = '.$idFormacion.' ', $db2);


	echo "

	<table border='1'>
		<tr>
		<td align='center' style='font-size:14px' colspan='9'><strong>Usarios del dia ".$dia." - Formación: ".$idFormacion."</strong></td>
	   

	  </tr>
	   <tr>
	    <td align='center' style='font-size:14px'><strong>Asistio</strong></td>
	    <td align='center' style='font-size:14px'><strong>Cedula</strong></td>
	    <td align='center' style='font-size:14px'><strong>Correo</strong></td>
		<td align='center' style='font-size:14px'><strong>Nombre</strong></td>
	    <td align='center' style='font-size:14px'><strong>Telefono</strong></td>
		<td align='center' style='font-size:14px'><strong>Fecha de Nacimiento</strong></td>
		<td align='center' style='font-size:14px'><strong>Genero</strong></td>
		<td align='center' style='font-size:14px'><strong>Id Institucion</strong></td>
		<td align='center' style='font-size:14px'><strong>Institucion</strong></td>
		<td align='center' style='font-size:14px'><strong>Ciudad</strong></td>



	  </tr>
	";





	while( $row2 = @mysql_fetch_row($result2) ) 

	{

		//$result=mysql_query('SELECT informacioncomplementariapersonas.IcEmail AS correo, valorizacioninstituciones.VieTipoInstitucion, tipossector.TcNombre, institucioneseducativas.IeId AS id_institucion, institucioneseducativas.IeNombre AS institucion, ciudades.CiNombre, niveleseducativospais.NvNombre, asignaturas.AsNombre AS Area, agrupaciones.AcNombre, rolescontacto.RcNombre, gradosnivelpais.GnNombre AS grado, CONCAT_WS("",personas.PeNombres,personas.PePrimerApellido,personas.PeSegundoApellido) AS nombre, personas.PeIdentificacion AS cedula, regionales.ReNombre AS Delegacion, informacioncomplementariapersonas.IcTelefono, informacioncomplementariapersonas.IcNacimiento, informacioncomplementariapersonas.IcGenero FROM adopciones INNER JOIN institucioneseducativas ON adopciones.ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN asignaturasparalelo ON adopciones.ApAsignaturaParalelo = asignaturasparalelo.AuId INNER JOIN asignaturasgradosperiodoinstitucioneducativa ON asignaturasparalelo.AuAsignaturaGradoPeriodoInstitucionEducativa = asignaturasgradosperiodoinstitucioneducativa.AdId INNER JOIN gradosnivelperiodoinstitucioneducativa ON asignaturasgradosperiodoinstitucioneducativa.AdGradoNivelPeriodoInstitucionEducativa = gradosnivelperiodoinstitucioneducativa.GiId INNER JOIN gradosnivelpais ON gradosnivelperiodoinstitucioneducativa.GiGradoNivelPais = gradosnivelpais.GnId INNER JOIN adopcionproductos ON adopcionproductos.AoAdopcion = adopciones.ApId INNER JOIN productos ON adopcionproductos.AoProducto = productos.PcId INNER JOIN asignaturasgradopaisdefecto ON asignaturasgradosperiodoinstitucioneducativa.AdAsignaturaGradoPais = asignaturasgradopaisdefecto.AgId INNER JOIN asignaturas ON asignaturasgradopaisdefecto.AgAsignatura = asignaturas.AsId LEFT JOIN contactosadopcion ON adopciones.ApId = contactosadopcion.CpAdopcion LEFT JOIN contactosinstitucioneducativa ON contactosadopcion.CpContactoInstitucionEducativa = contactosinstitucioneducativa.CnId LEFT JOIN personas ON contactosinstitucioneducativa.CnPersona = personas.PeId INNER JOIN valorizacioninstituciones ON valorizacioninstituciones.VieInstitucionEducativa = institucioneseducativas.IeId AND adopciones.ApTemporadaNegocio = valorizacioninstituciones.VieTemporadaNegocio INNER JOIN tipossector ON institucioneseducativas.IeSector = tipossector.TcId INNER JOIN barrios ON institucioneseducativas.IeBarrio = barrios.BaId INNER JOIN localidades ON barrios.BaLocalidad = localidades.LoId INNER JOIN ciudades ON personas.PeCiudadResidencia = ciudades.CiId AND localidades.LoCiudad = ciudades.CiId INNER JOIN niveleseducativospais ON gradosnivelpais.GnNivelEducativo = niveleseducativospais.NvId INNER JOIN agrupaciones ON productos.PcAgrupacion = agrupaciones.AcId INNER JOIN rolescontacto ON contactosinstitucioneducativa.CnRolContacto = rolescontacto.RcId INNER JOIN tmp_resumenadopcionproducto ON tmp_resumenadopcionproducto.rap_ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN regionales ON tmp_resumenadopcionproducto.rap_Distrito = regionales.ReId INNER JOIN informacioncomplementariapersonas ON informacioncomplementariapersonas.IcPersona = personas.PeId WHERE adopciones.ApTemporadaNegocio = 10 AND adopcionproductos.AoEstatus <> "P" AND personas.PeIdentificacion = "'.$row2[0].'" GROUP BY productos.PcId', $db);
		$result = mysql_query('SELECT informacioncomplementariapersonas.IcEmail AS correo, CONCAT_WS(" ",personas.PeNombres,personas.PePrimerApellido,personas.PeSegundoApellido) AS contacto, informacioncomplementariapersonas.IcTelefono, informacioncomplementariapersonas.IcNacimiento, informacioncomplementariapersonas.IcGenero, institucioneseducativas.IeId AS id_institucion, institucioneseducativas.IeNombre AS institucion, ciudades.CiNombre FROM adopciones INNER JOIN institucioneseducativas ON adopciones.ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN asignaturasparalelo ON adopciones.ApAsignaturaParalelo = asignaturasparalelo.AuId INNER JOIN asignaturasgradosperiodoinstitucioneducativa ON asignaturasparalelo.AuAsignaturaGradoPeriodoInstitucionEducativa = asignaturasgradosperiodoinstitucioneducativa.AdId INNER JOIN gradosnivelperiodoinstitucioneducativa ON asignaturasgradosperiodoinstitucioneducativa.AdGradoNivelPeriodoInstitucionEducativa = gradosnivelperiodoinstitucioneducativa.GiId INNER JOIN adopcionproductos ON adopcionproductos.AoAdopcion = adopciones.ApId INNER JOIN productos ON adopcionproductos.AoProducto = productos.PcId INNER JOIN asignaturasgradopaisdefecto ON asignaturasgradosperiodoinstitucioneducativa.AdAsignaturaGradoPais = asignaturasgradopaisdefecto.AgId LEFT JOIN contactosadopcion ON adopciones.ApId = contactosadopcion.CpAdopcion LEFT JOIN contactosinstitucioneducativa ON contactosadopcion.CpContactoInstitucionEducativa = contactosinstitucioneducativa.CnId LEFT JOIN personas ON contactosinstitucioneducativa.CnPersona = personas.PeId INNER JOIN barrios ON institucioneseducativas.IeBarrio = barrios.BaId INNER JOIN localidades ON barrios.BaLocalidad = localidades.LoId INNER JOIN ciudades ON personas.PeCiudadResidencia = ciudades.CiId AND localidades.LoCiudad = ciudades.CiId INNER JOIN tmp_resumenadopcionproducto ON tmp_resumenadopcionproducto.rap_ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN informacioncomplementariapersonas ON informacioncomplementariapersonas.IcPersona = personas.PeId WHERE adopciones.ApTemporadaNegocio = 10 AND adopcionproductos.AoEstatus <> "P" AND personas.PeIdentificacion = "'.$row2[0].'" GROUP BY productos.PcId', $db);
		
		$row = @mysql_fetch_row($result);

			echo " 


			    <td align='center'>$row2[2]</td>
				<td align='center'>$row2[0]</td>
			    <td align='center'>$row[0]</td>
				<td align='center'>$row[1]</td>
				<td align='center'>$row[2]</td>
				<td align='center'>$row[3]</td>
				<td align='center'>$row[4]</td>
				<td align='center'>$row[5]</td>
				<td align='center'>$row[6]</td>
				<td align='center'>$row[7]</td>
				

			  </tr>
			  

			  ";

	}		 

echo "</table>";



?>