<?php 
/*
* @name article tool 1.0
* Created By Guarneri Iacopo
* http://www.the-html-tool.com/
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

$txt_to_rend="test";
require_once("../dompdf_config.inc.php");
if ( isset( $txt_to_rend ) ) {

  if ( get_magic_quotes_gpc() )
    $txt_to_rend = stripslashes($txt_to_rend);

  $old_limit = ini_set("memory_limit", "16M");

  $dompdf = new DOMPDF();
  $dompdf->load_html($txt_to_rend);
  $dompdf->set_paper("portrait","letter");
  $dompdf->render();

  //ho modificato la classe, ora di default non forza il download del file ma lo fa vedere nel browser
  $dompdf->stream("dompdf_out.pdf");
}

?>