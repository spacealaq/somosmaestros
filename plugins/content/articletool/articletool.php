<?php
/*
* @name article tool 1.0
* Created By Guarneri Iacopo
* http://www.the-html-tool.com/
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class Charset extends JFactory{
	function get(){
		$charset=$this->createDocument();
		return $charset->_charset;
	}
}
class plgContentarticletool extends JPlugin
{
	function onContentPrepare( $context, &$article, &$params, $page = 0)
	{ 
		$input = JFactory::getApplication()->input;
		$view = $input->get('view'); 

		if(strstr(@$_SERVER["HTTP_REFERER"],"view=form") && strstr(@$_SERVER["HTTP_REFERER"],"layout=edit")){return false;}
		$cosa_mostrare=$this->params->get("cosa_mostrare");
		if(!is_array($cosa_mostrare)){$cosa_mostrare=array($cosa_mostrare);}
		$cats=$this->params->get("category");
		if(!is_array($cats)){$cats=array($cats);}
		$counter=$this->params->get("counter","0");
		$position=$this->params->get("position","top");
		$css=$this->params->get("css","color:#000; font-family:Arial; font-size:14px; line-height:19px; padding:20px;");
		$memory_limit=$this->params->get("memory_limit","25");
		$visual_pdf=$this->params->get("visual_pdf","0");
		$show_in_blog=$this->params->get("show_in_blog","0");
		$icon_position=$this->params->get("icon_position","left");
		
		if($show_in_blog==0 && ($view=="featured" || $view=="category")){return false;}

		if($icon_position=="right"){
			$document = JFactory::getDocument();
			$style = '.stButton {
			    float: right !important;
			}';
			$document->addStyleDeclaration( $style );
		}

		if($visual_pdf==1){$visual_pdf=0;}else{$visual_pdf=1;}

		//se l'articolo non è della giusta categoria esce subito
		$categoria_presente=0;
		foreach($cats as $cat){if(@$article->catid==$cat){$categoria_presente=1;}}
		if($categoria_presente==0){return false;}
		else{
			echo '<link rel="stylesheet" href="'.JURI::base().'plugins/content/articletool/style/style.css" type="text/css" />';
			if(JRequest::getVar('print', 0, 'get')!=1 && JRequest::getVar('download', 0, 'get')!=1){	
				//inserisce gli script per far funzionare sharethis
				foreach($cosa_mostrare as $ico){
					if($ico!="stampa" && $ico!="scarica"){
						$http="";
						if($_SERVER["REQUEST_SCHEME"]=="https")
							$http="s";
						$article->text.='<script type="text/javascript">var switchTo5x=true;</script>
						<script type="text/javascript" src="http'.$http.'://w'.$http.'.sharethis.com/button/buttons.js"></script>
						<script type="text/javascript">stLight.options({publisher: "cf4e376e-1d9c-43b1-8df7-617e403ae918", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>';
						break;
					}
				}
				
				$icone="";
				$uri = JFactory::getURI();
				//mostro le icone dei social, invia per mail, stampa e scarica
				foreach($cosa_mostrare as $ico){
					if($ico=="stampa"){
						$uri->setVar('print', 1);
						$uri->setVar('download', 0);
						$uri->setVar('id', $article->id);
						if($counter==0){
							$icone.="
							<span class='stButton stButton_print'>
							<a id='article_tool_print' href='".$uri->toString()."' target='_blank'>
								<img src='".JURI::base()."plugins/content/articletool/images/print.png' />
							</a></span>";
						}else{
							$icone.="<a id='article_tool_print' href='".$uri->toString()."' target='_blank'>
							<span class='stButton'><span class='stButton_gradient'>
								<img src='".JURI::base()."plugins/content/articletool/images/print.png' />
							<span class='chicklets chicklets_article_tool_print'>Print</span></span></span></a>";
						}
						
					}else if($ico=="scarica"){
						$uri->setVar('print', 0);
						$uri->setVar('download', 1);
						$uri->setVar('id', $article->id);
						if($counter==0){
							$icone.="
							<span class='stButton stButton_pdf'>
							<a id='article_tool_pdf' href='".$uri->toString()."' target='_blank'>
								<img src='".JURI::base()."plugins/content/articletool/images/pdf.png' />
							</a></span>";
						}else{
							$icone.="<a id='article_tool_pdf' href='".$uri->toString()."' target='_blank'>
							<span class='stButton'><span class='stButton_gradient'>
								<img src='".JURI::base()."plugins/content/articletool/images/pdf.png' />
							<span class='chicklets chicklets_article_tool_pdf'>Download</span></span></span></a>";
						}
					}else{
						$url_corrente=substr(JURI::base(),0,-1).JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
						if($counter==0){$type="large";}else{$type="hcount";}
						$icone.='<span class="st_'.$ico.'_'.$type.'" st_url="'.$url_corrente.'" displayText="'.$ico.'"></span>';
					}
				}
				
				if($position=="top"){
					$article->text = "<div class='article_tool_container'>".$icone."</div><div class='article_tool_separator'></div>".$article->text;
				}
				if($position=="bottom"){
					$article->text.="<div class='article_tool_container'>".$icone."</div><div class='article_tool_separator'></div>";
				}
			}
			
			if(!function_exists('relative_to_absolute')) {
				function relative_to_absolute($article,$home){
					preg_match_all('/src="(.+?)"/', $article->text, $src);
					preg_match_all('/href="(.+?)"/', $article->text, $href);
					$urls=array_merge($src[1], $href[1]);
					foreach($urls as $url){
						if(!strstr($url,"http://") && !strstr($url,"https://")){
							$sepsl="/";
							if(substr($home,-1,1)=="/")
								$sepsl="";
							$article->text=str_replace('"'.$url.'"',$home.$sepsl.$url,$article->text);
						}
					}
					return $article->text;
				}
			}
			$article->text=relative_to_absolute($article,JURI::base());


			if(!function_exists('get_article_by_get')) {
				function get_article_by_get(){
					$db = JFactory::getDBO();
					$sql = "SELECT * FROM #__content WHERE id = ".JRequest::getVar('id', 0, 'get');
					$db->setQuery($sql);
					$fullArticle = $db->loadAssocList();
					return $fullArticle[0]["introtext"].$fullArticle[0]["fulltext"];
				}
			}
			
			$charset=new Charset();
			if(JRequest::getVar('print', 0, 'get')==1){
				$article->text=get_article_by_get();
				$article->text=relative_to_absolute($article,JURI::base());

				$article->text.='
					<script type="text/javascript">
						window.print();
						window.close();
					</script>
				';
				
				echo "<meta http-equiv='content-type' content='text/html; charset=".$charset->get()."' /><div style='".$css."'>".$article->text."</div>";
				JFactory::getApplication()->close();
				die("");
			}
			if(JRequest::getVar('download', 0, 'get')==1){
				$article->text=get_article_by_get(); 
				$article->text=relative_to_absolute($article,JURI::base());

				//$txt_to_rend=file_get_contents(JURI::current());
				$txt_to_rend="<meta http-equiv='content-type' content='text/html; charset=".$charset->get()."' /><div style='".$css."'>".$article->text."</div>";
				require_once("plugins/content/articletool/dompdf/dompdf_config.inc.php");

				if ( get_magic_quotes_gpc() )
					$txt_to_rend = stripslashes($txt_to_rend);

				$old_limit = ini_set("memory_limit", $memory_limit."M");

				$dompdf = new DOMPDF();
				$dompdf->load_html($txt_to_rend);
				$dompdf->set_paper("portrait","letter");
				$dompdf->render();

				/*i pdf possono essere messi in cache, vedere se nella jed ci sono componenti article to pdf*/
				$dompdf->stream($article->title.".pdf", array("Attachment" => $visual_pdf));
				
				JFactory::getApplication()->close();
				die("");
			}
			
			return true;
		}
	}
}
