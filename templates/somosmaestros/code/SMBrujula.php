<?php

/*
$option = array(); //prevent problems
$option['driver']   = 'mysql';            // Database driver name
$option['host']     = '208.117.45.85';    // Database host name
$option['user']     = 'educasm_somosmae';       // User for database authentication
$option['password'] = 'R;(z=fE!95Ss';   // Password for database authentication
$option['database'] = 'educasm_sm_educativa';      // Database name
$option['prefix']   = '';             // Database prefix (may be empty)
*/
//print_r($option);
?>
<?php
class SMBrujula { 
	public function getConexion(){
		$option = array(); //prevent problems
		$option['driver']   = 'mysql';            // Database driver name
		$option['host']     = '208.117.45.85';    // Database host name
		$option['user']     = 'smbrujul_somosma';       // User for database authentication
		$option['password'] = 'R;(z=fE!95Ss';   // Password for database authentication
		$option['database'] = 'smbrujul_produccion';      // Database name
		$option['prefix']   = '';
		return $option;
	}
}