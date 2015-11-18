<?php 

 header("Content-type: application/vnd.ms-excel");
 $dia = date('d/m/Y');
 header("Content-Disposition:  filename=\"Logs - Fecha: ".$dia.".XLS\";");

$servername = "208.117.45.85";
$username = "smbrujul_somosma";
$password = "R;(z=fE!95Ss";
$database = "smbrujul_produccion";

// Create and connection
$db = mysql_connect($servername, $username, $password) or die("Could not connect database");
mysql_select_db($database, $db) or die("Could not select database");




$usuario = $_POST['usuario'];
$tipo =  $_POST['tipo'];
$id =  $_POST['id'];

if($tipo == 'PR'){
	$result=mysql_query('SELECT valorizacioninstituciones.VieTipoInstitucion, tipossector.TcNombre, institucioneseducativas.IeId AS id_institucion, institucioneseducativas.IeNombre AS institucion, ciudades.CiNombre, niveleseducativospais.NvNombre, asignaturas.AsNombre AS Area, agrupaciones.AcNombre, rolescontacto.RcNombre, gradosnivelpais.GnNombre AS grado, personas.PeNombres AS nombres, personas.PePrimerApellido AS primerApellido, personas.PeSegundoApellido AS segundoApellido, personas.PeIdentificacion AS cedula, regionales.ReNombre AS Delegacion, informacioncomplementariapersonas.IcTelefono, informacioncomplementariapersonas.IcNacimiento, informacioncomplementariapersonas.IcGenero FROM adopciones INNER JOIN institucioneseducativas ON adopciones.ApInstitucionEducativa = institucioneseducativas.IeId INNER JOIN asignaturasparalelo ON adopciones.ApAsignaturaParalelo = asignaturasparalelo.AuId INNER JOIN asignaturasgradosperiodoinstitucioneducativa ON asignaturasparalelo.AuAsignaturaGradoPeriodoInstitucionEducativa = asignaturasgradosperiodoinstitucioneducativa.AdId INNER JOIN gradosnivelperiodoinstitucioneducativa ON asignaturasgradosperiodoinstitucioneducativa.AdGradoNivelPeriodoInstitucionEducativa = gradosnivelperiodoinstitucioneducativa.GiId INNER JOIN gradosnivelpais ON gradosnivelperiodoinstitucioneducativa.GiGradoNivelPais = gradosnivelpais.GnId INNER JOIN adopcionproductos ON adopcionproductos.AoAdopcion = adopciones.ApId INNER JOIN productos ON adopcionproductos.AoProducto = productos.PcId INNER JOIN asignaturasgradopaisdefecto ON asignaturasgradosperiodoinstitucioneducativa.AdAsignaturaGradoPais = asignaturasgradopaisdefecto.AgId INNER JOIN asignaturas ON asignaturasgradopaisdefecto.AgAsignatura = asignaturas.AsId LEFT JOIN contactosadopcion ON adopciones.ApId = contactosadopcion.CpAdopcion LEFT JOIN contactosinstitucioneducativa ON contactosadopcion.CpContactoInstitucionEducativa = contactosinstitucioneducativa.CnId LEFT JOIN personas ON contactosinstitucioneducativa.CnPersona = personas.PeId INNER JOIN valorizacioninstituciones ON valorizacioninstituciones.VieInstitucionEducativa = institucioneseducativas.IeId AND adopciones.ApTemporadaNegocio = valorizacioninstituciones.VieTemporadaNegocio INNER JOIN tipossector ON institucioneseducativas.IeSector = tipossector.TcId INNER JOIN barrios ON institucioneseducativas.IeBarrio = barrios.BaId INNER JOIN localidades ON barrios.BaLocalidad = localidades.LoId INNER JOIN ciudades ON personas.PeCiudadResidencia = ciudades.CiId AND localidades.LoCiudad = ciudades.CiId INNER JOIN niveleseducativospais ON gradosnivelpais.GnNivelEducativo = niveleseducativospais.NvId INNER JOIN agrupaciones ON productos.PcAgrupacion = agrupaciones.AcId INNER JOIN rolescontacto ON contactosinstitucioneducativa.CnRolContacto = rolescontacto.RcId INNER JOIN tmp_resumenadopcionproducto ON tmp_resumenadopcionproducto.rap_ApInstitucionEducativa = institucioneseducativas.IeId AND adopciones.ApId = tmp_resumenadopcionproducto.rap_ApId INNER JOIN regionales ON tmp_resumenadopcionproducto.rap_Distrito = regionales.ReId INNER JOIN informacioncomplementariapersonas ON informacioncomplementariapersonas.IcPersona = personas.PeId WHERE adopciones.ApTemporadaNegocio = 10 AND tmp_resumenadopcionproducto.rap_TdNombre = "Propia" AND tmp_resumenadopcionproducto.rap_ApUsuario = "'.$id.'" AND rolescontacto.RcNombre = "DOCENTE" GROUP BY productos.PcId', $db);
}else if($tipo == 'CO'){
	$result=mysql_query('SELECT institucioneseducativas.IeId AS IdInterno, institucioneseducativas.IeNombre AS Institucion, usuarios.UsIdentificacion AS cedula, institucioneseducativas.IeTipoCalendario AS Calendario, institucioneseducativas.IeIdentificacion AS Dane, ciudades.CiNombre AS Ciudad, departamentos.DeNombre AS Departamento, CONCAT(Usu1.UsNombres," ",Usu1.UsApellidos) AS Asesor, CONCAT(Usu2.UsNombres," ",Usu2.UsApellidos) AS Coordinador, regionales.ReNombre AS Regional FROM institucioneseducativas INNER JOIN usuarios INNER JOIN territoriosinstitucioneducativa ON institucioneseducativas.IeId = territoriosinstitucioneducativa.ToInstitucionEducativa INNER JOIN territorios ON territoriosinstitucioneducativa.ToTerritorio = territorios.TsId INNER JOIN barrios ON institucioneseducativas.IeBarrio = barrios.BaId INNER JOIN localidades ON barrios.BaLocalidad = localidades.LoId INNER JOIN ciudades ON localidades.LoCiudad = ciudades.CiId INNER JOIN departamentos ON ciudades.CiDepartamento = departamentos.DeId INNER JOIN usuarios AS Usu1 ON territorios.TsUsuarioResponsable = Usu1.UsId INNER JOIN coordinaciones ON territorios.TsCoordinacion = coordinaciones.CoId INNER JOIN usuarios AS Usu2 ON coordinaciones.CoResponsable = Usu2.UsId INNER JOIN regionales ON coordinaciones.CoRegional = regionales.ReId WHERE Usu2.UsId = "'.$id.'" ORDER BY Asesor ASC, Coordinador ASC, Institucion ASC',$db);
} else if($tipo == 'RE'){
	$result=mysql_query('SELECT Usu1.UsId AS IDCoordinador, CONCAT(Usu1.UsNombres," ",Usu1.UsApellidos) AS Coordinador, Usu1.UsIdentificacion AS cedula, ciudades.CiNombre AS Ciudad, departamentos.DeNombre, CONCAT(usuarios.UsNombres," ",usuarios.UsApellidos) AS Gerente, regionales.ReNombre, regionales.ReGerenteResponsable AS IDGerente FROM usuarios AS Usu1 LEFT JOIN territorios ON Usu1.UsId = territorios.TsUsuarioResponsable LEFT JOIN ciudades ON Usu1.UsCiudad = ciudades.CiId LEFT JOIN coordinaciones ON territorios.TsCoordinacion = coordinaciones.CoId LEFT JOIN usuarios ON coordinaciones.CoResponsable = usuarios.UsId LEFT JOIN regionales ON coordinaciones.CoRegional = regionales.ReId INNER JOIN departamentos ON ciudades.CiDepartamento = departamentos.DeId WHERE Usu1.UsTipo = "PR" AND Usu1.UsEstado ="A" AND usuarios.UsTipo = "CO" AND usuarios.UsEstado = "A" AND regionales.ReGerenteResponsable = "'.$id.'" ORDER BY Coordinador ASC, Ciudad ASC',$db);
} else if($tipo == 'GN'){
	$result=mysql_query('SELECT Usu1.UsId AS IDGerente, CONCAT(Usu1.UsNombres," ",Usu1.UsApellidos) AS GerenteReg, Usu1.UsIdentificacion AS cedula, ciudades.CiNombre AS Ciudad, departamentos.DeNombre FROM usuarios AS Usu1 LEFT JOIN territorios ON Usu1.UsId = territorios.TsUsuarioResponsable LEFT JOIN ciudades ON Usu1.UsCiudad = ciudades.CiId LEFT JOIN coordinaciones ON territorios.TsCoordinacion = coordinaciones.CoId LEFT JOIN usuarios ON coordinaciones.CoResponsable = usuarios.UsId LEFT JOIN regionales ON coordinaciones.CoRegional = regionales.ReId INNER JOIN departamentos ON ciudades.CiDepartamento = departamentos.DeId WHERE Usu1.UsTipo = "RE" AND Usu1.UsEstado ="A" ORDER BY GerenteReg ASC', $db);
}


if($tipo == 'PR'){
	echo "

	<table border='1'>
		<tr>
		<td align='center' style='font-size:14px' colspan='9'><strong>Usarios del dia ".$dia." - usuario: ".$usuario."</strong></td>
	   

	  </tr>
	   <tr>
		<td align='center' style='font-size:14px'><strong>Fecha Ingreso</strong></td>
		<td align='center' style='font-size:14px'><strong>Hora Ingreso</strong></td>
		<td align='center' style='font-size:14px'><strong>Vista</strong></td>
		<td align='center' style='font-size:14px'><strong>Calendario</strong></td>
		<td align='center' style='font-size:14px'><strong>Dane</strong></td>
		<td align='center' style='font-size:14px'><strong>Ciudad</strong></td>
		<td align='center' style='font-size:14px'><strong>Tipo Institución</strong></td>
	    <td align='center' style='font-size:14px'><strong>Segmento</strong></td>
		<td align='center' style='font-size:14px'><strong>Id Institución</strong></td>
		<td align='center' style='font-size:14px'><strong>Institución</strong></td>
		<td align='center' style='font-size:14px'><strong>Ciudad</strong></td>
	    <td align='center' style='font-size:14px'><strong>Nivel</strong></td>
	    <td align='center' style='font-size:14px'><strong>Área</strong></td>
	    <td align='center' style='font-size:14px'><strong>Proyecto</strong></td>
	    <td align='center' style='font-size:14px'><strong>Rol</strong></td>
	    <td align='center' style='font-size:14px'><strong>Grado</strong></td>
	    <td align='center' style='font-size:14px'><strong>Cedula</strong></td>
	    <td align='center' style='font-size:14px'><strong>Nombres</strong></td>
	    <td align='center' style='font-size:14px'><strong>Primer Apellido</strong></td>
	    <td align='center' style='font-size:14px'><strong>Segundo Apellido</strong></td>
	    <td align='center' style='font-size:14px'><strong>Delegación</strong></td>
	    <td align='center' style='font-size:14px'><strong>Teléfono</strong></td>
	    <td align='center' style='font-size:14px'><strong>Fecha de Nacimiento</strong></td>
	    <td align='center' style='font-size:14px'><strong>Género</strong></td>


	  </tr>
	";
}else if($tipo == 'CO'){
	echo "

	<table border='1'>
		<tr>
		<td align='center' style='font-size:14px' colspan='9'><strong>Usarios del dia ".$dia." - usuario: ".$usuario."</strong></td>
	   

	  </tr>
	   <tr>
		<td align='center' style='font-size:14px'><strong>Fecha Ingreso</strong></td>
		<td align='center' style='font-size:14px'><strong>Hora Ingreso</strong></td>
		<td align='center' style='font-size:14px'><strong>Vista</strong></td>
		<td align='center' style='font-size:14px'><strong>Calendario</strong></td>
		<td align='center' style='font-size:14px'><strong>Dane</strong></td>
		<td align='center' style='font-size:14px'><strong>Ciudad</strong></td>
	    <td align='center' style='font-size:14px'><strong>Departamento</strong></td>
	    <td align='center' style='font-size:14px'><strong>Asesor</strong></td>
	    <td align='center' style='font-size:14px'><strong>Coordinador</strong></td>
	    <td align='center' style='font-size:14px'><strong>Regional</strong></td>

	  </tr>
	";
} else if($tipo == 'RE'){
	echo "

	<table border='1'>
		<tr>
		<td align='center' style='font-size:14px' colspan='9'><strong>Usarios del dia ".$dia." - usuario: ".$usuario."</strong></td>
	   

	  </tr>
	   <tr>
		<td align='center' style='font-size:14px'><strong>Fecha Ingreso</strong></td>
		<td align='center' style='font-size:14px'><strong>Hora Ingreso</strong></td>
		<td align='center' style='font-size:14px'><strong>Vista</strong></td>
		<td align='center' style='font-size:14px'><strong>Id Coordinador</strong></td>
	    <td align='center' style='font-size:14px'><strong>Coordinador</strong></td>
	    <td align='center' style='font-size:14px'><strong>Cedula</strong></td>
		<td align='center' style='font-size:14px'><strong>Ciudad</strong></td>
		<td align='center' style='font-size:14px'><strong>Departamento</strong></td>
		<td align='center' style='font-size:14px'><strong>Gerente</strong></td>
	    <td align='center' style='font-size:14px'><strong>Delegación</strong></td>
	    <td align='center' style='font-size:14px'><strong>Id Gerente</strong></td>

	  </tr>
	";
} else if($tipo == 'GN'){
	echo "

	<table border='1'>
		<tr>
		<td align='center' style='font-size:14px' colspan='9'><strong>Logs generados el dia ".$dia." - usuario: ".$usuario."</strong></td>
	   

	  </tr>
	   <tr>
		<td align='center' style='font-size:14px'><strong>Fecha Ingreso</strong></td>
		<td align='center' style='font-size:14px'><strong>Hora Ingreso</strong></td>
		<td align='center' style='font-size:14px'><strong>Vista</strong></td>
		<td align='center' style='font-size:14px'><strong>Id Gerente</strong></td>
	    <td align='center' style='font-size:14px'><strong>Gerente Regional</strong></td>
		<td align='center' style='font-size:14px'><strong>Cedula</strong></td>
		<td align='center' style='font-size:14px'><strong>Ciudad</strong></td>
		<td align='center' style='font-size:14px'><strong>Departamento</strong></td>

	  </tr>
	";
}





	while( $row = @mysql_fetch_row($result) )

	

	{

		if($tipo == 'PR'){
			$result2=mysql_query('SELECT `date`, `time`, `vista` FROM `mpn7k_somosmaestros_logs` WHERE `cedula` = '.$row[7].' ', $db2);
			$row2= @mysql_fetch_row($result2);

			echo "

		<tr>

		    <td align='center'>$row2[0]</td>
		    <td align='center'>$row2[1]</td>
		    <td align='center'>$row2[2]</td>
		    <td align='center'>$row[0]</td>
			<td align='center'>$row[1]</td>
			<td align='center'>$row[2]</td>
			<td align='center'>$row[3]</td>
			<td align='center'>$row[4]</td>
			<td align='center'>$row[5]</td>
			<td align='center'>$row[6]</td>
			<td align='center'>$row[7]</td>
			<td align='center'>$row[8]</td>
		    <td align='center'>$row[9]</td>
			<td align='center'>$row[10]</td>
			<td align='center'>$row[11]</td>
			<td align='center'>$row[12]</td>
			<td align='center'>$row[13]</td>
			<td align='center'>$row[14]</td>
			<td align='center'>$row[15]</td>
			<td align='center'>$row[16]</td>
			<td align='center'>$row[17]</td>
			

		  </tr>
		  

		  ";
		}else if($tipo == 'CO'){
			$result2=mysql_query('SELECT `date`, `time`, `vista` FROM `mpn7k_somosmaestros_logs` WHERE `cedula` = '.$row[2].' ', $db2);
			$row2= @mysql_fetch_row($result2);

					echo "

				<tr>

				    <td align='center'>$row2[0]</td>
				    <td align='center'>$row2[1]</td>
				    <td align='center'>$row2[2]</td>
				    <td align='center'>$row[0]</td>
					<td align='center'>$row[1]</td>
					<td align='center'>$row[2]</td>
					<td align='center'>$row[3]</td>
					<td align='center'>$row[4]</td>
					<td align='center'>$row[5]</td>
					<td align='center'>$row[6]</td>
					<td align='center'>$row[7]</td>
					<td align='center'>$row[8]</td>
					<td align='center'>$row[9]</td>
					

				  </tr>
				  

				  ";

		} else if($tipo == 'RE'){
			$result2=mysql_query('SELECT `date`, `time`, `vista` FROM `mpn7k_somosmaestros_logs` WHERE `cedula` = '.$row[2].' ', $db2);

			$row2= @mysql_fetch_row($result2);


					echo "

				<tr>

				    <td align='center'>$row2[0]</td>
				    <td align='center'>$row2[1]</td>
				    <td align='center'>$row2[2]</td>
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
		} else if($tipo == 'GN'){
			
			$result2=mysql_query('SELECT `date`, `time`, `vista` FROM `mpn7k_somosmaestros_logs` WHERE `cedula` = '.$row[2].' ', $db2);
			$row2= @mysql_fetch_row($result2);

			echo "

		<tr>

		    <td align='center'>$row2[0]</td>
		    <td align='center'>$row2[1]</td>
		    <td align='center'>$row2[2]</td>
		    <td align='center'>$row[0]</td>
			<td align='center'>$row[1]</td>
			<td align='center'>$row[2]</td>
			<td align='center'>$row[3]</td>
			<td align='center'>$row[4]</td>
			

		  </tr>
		  

		  ";

		}

	}			 

echo "</table>";



?>