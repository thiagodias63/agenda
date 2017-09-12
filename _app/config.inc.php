<?php
//deifne('HOME','http://localhost/sistemmvc/modulo_helpers');
#################### Configurações do SITE ####################
define('HOST','localhost');
define('USER','root');
define('PASS','root');
define('DBSA','calendario');

#################### AUTO LOAD DE CLASSES #####################
	function __autoload($Class){
		$cDir = ['Conn','Helpers','Models']; //A lógica precisou ser mudada para atender também os deiretorios dentor de app, no caso o conn que trabalha o banco, helpers que são as classes auxiliares
		$iDir = null;
		
		foreach($cDir as $dirName):
			if(!$iDir && file_exists("./_app/{$dirName}/{$Class}.class.php") && !is_dir("./_app/{$dirName}/{$Class}.class.php")):
				
				include_once("./_app/{$dirName}/{$Class}.class.php");//
				//$iDir = true;
			endif;
		endforeach;
		if($iDir):
			trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
			die;
		endif;
	}
################## TRATAMENTO DE ERROS ######################

//Css constantes :: Mensagem de Erro
define('RC_ACCEPT','accept');
define('RC_INFOR','infor');
define('RC_ALERT','alert');
define('RC_ERROR','error');

//HTMLErro :: Exibe erros lançados :: Front
function RCErro($ErrMsg, $ErrNo, $ErrDie = null){
	$CssClass = ($ErrNo == E_USER_NOTICE ? RC_INFOR : ($ErrNo == E_USER_WARNING ? RC_ALERT : ($ErrNo == E_USER_ERROR ? RC_ERROR : $ErrNo)));
	echo "<p class=\"trigger {$CssClass}\">{$ErrMsg}";
	echo "<span class=\"ajax_close\"></span>";
	echo "</p>";
	if($ErrDie):
		die;
	endif;
}

//PHPErro :: personaliza o gatilho php
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine){
	$CssClass = ($ErrNo == E_USER_NOTICE ? RC_INFOR : ($ErrNo == E_USER_WARNING ? RC_ALERT : ($ErrNo == E_USER_ERROR ? RC_ERROR : $ErrNo)));
	echo "<p class=\"trigger {$CssClass}\">";
	echo "<b>Erro na linha: {$ErrLine} ::</b>  {$ErrMsg} <br>";
	echo "<small>{$ErrFile}</small>";
	echo "<span class=\"ajax_close\"></span>";
	echo "</p>";
	
	if($ErrNo == E_USER_ERROR):
		die;
	endif;
}
set_error_handler('PHPErro');