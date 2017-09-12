<?php
/*Responsavel por estatistica, sessões e atualizações no tráfego do sistema*/
class Session{
	private $Date;
	private $Cache;
	private $Traffic;
	private $Browser;

	function __construct($Cache = null) {
		session_start();
		$this-> CheckSession($Cache);
	}
	//Verifica e executa todos os métodos da classe
	private function CheckSession($Cache=null){
		$this->Date = date('Y-m-d');
		$this->Cache = ( (int) $Cache ? $Cache : 20 );
		if(empty($_SESSION['useronline'])):
			$this->setTraffic();
		$this->setSession();
		$this->checkBrowser();
		$this->setUsuario();

		$this->BrowserUpdate();
		else:
			$this->TrafficUpdate();
		$this->sessionUpdate();
		$this->checkBrowser();
		$this->UsuarioUpdate();
		endif;
		$this->Date = null;
	}

 	/**
 	* ****************************************
 	* *********** SESSÃO DO USUÁRIO **********
 	* ****************************************
 	*/
	//Inicia a sessão do usuário
 	private function setSession(){
 		$_SESSION['useronline'] = [
 		'online_session' => session_id(),
 		'online_startview' => date('Y-m-d H:i:s'),
 		'online_endview' => date('Y-m-d H:i:s', strtotime("+{$this->Cache}minutes")),
 		'online_ip' => filter_input(INPUT_SERVER,'REMOTE_ADDR', FILTER_VALIDATE_IP),
 		'online_url' => filter_input(INPUT_SERVER,'REQUEST_URI' , FILTER_DEFAULT ),
 		'online_agent' => filter_input(INPUT_SERVER, 'HTTP_USER_AGENT' , FILTER_DEFAULT)
 		];
 	}

	//Atualiza a sessõa do usuário
 	private function sessionUpdate(){
 		$_SESSION['useronline']['online_endview'] = date('Y-m-d H:i:s',strtotime("+{$this->Cache}minutes"));
 		$_SESSION['useronline']['online_url'] = filter_input(INPUT_SERVER,'REQUEST_URI' , FILTER_DEFAULT );
 	}

 	/**
 	* ****************************************
 	* *** USUÁRIOS, VISITAS E ATUALIZAÇÕES ***
 	* ****************************************
 	*/
	//Verifica e insere trafico na tablea
 	private function setTraffic(){
 		$this->getTraffic();
 		if(!$this->Traffic):
 			$ArrSiteViews = [ 'siteviews_date' => $this->Date, 'siteviews_users' => 1, 'siteviews_views' => 1, 'siteviews_pages' => 1];
 		$createSiteViews = new Create;
 		$createSiteViews->ExeCreate('siteviews', $ArrSiteViews);
 		else:
			if(!$this->getCookie()): //se não existe usuário
		$ArrSiteViews = ['siteviews_user' => $this->Traffic['siteviews_users'] + 1,
		'siteviews_views' => $this->Traffic['siteviews_views'] + 1, 'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1];
		else:
			$ArrSiteViews = [ 'siteviews_views' => $this->Traffic['siteviews_views'] + 1, 
				'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1]; //caso o cookie exista não acrescenta usuário
				endif;

				$updatesiteviews = new Update;
				$updatesiteviews->ExeUpdate('siteviews', $ArrSiteViews, 'WHERE siteviews_date = :date', 'date={$this->Date}');
				endif;
			}

	//Verifica e atualiza os pageviews
			private function TrafficUpdate(){
				$this->getTraffic();
				$ArrSiteViews = [ 'siteviews_pages' => $this->Traffic['siteviews_pages'] + 1] ;
				$updatePageViews = new Update;
				$updatePageViews->ExeUpdate('siteviews', $ArrSiteViews, 'WHERE siteviews_date = :date', 'date={$this->Date}');

		$this->Traffic = null; // Remove o traffic da memoria do pc;
	}
	
	//Obtém dados da tabela [HELPER TRAFFIC]
	public function getTraffic(){
		$readSiteViews = new Read;
		$readSiteViews->ExeRead('siteviews',"WHERE siteviews_date = :date","date={$this->Date}");
		if($readSiteViews->getRowCount()):
			$this->Traffic = $readSiteViews->getResult()[0];
		endif;
	}

	//Verifica cira e atualiza o cookie do usuario
	private function getCookie(){
		$Cookie = filter_input(INPUT_COOKIE, 'useronline', FILTER_DEFAULT);
		setcookie("useronline",base64_encode('reidacaixa'),time()+86400);
		if(!$Cookie):
			return false;
		else:
			return false;
		endif;	
	}


 	/**
 	* ****************************************
 	* ***** NAVEGADORES DE ACESSO ************
 	* ****************************************
 	*/
 	//Indentifica o navegador do usuário.
 	private function checkBrowser(){
 		$this->Browser = $_SESSION['useronline']['online_agent'];
 		if(strpos($this->Browser,'Chrome')):
 			$this->Browser = 'Chrome';
 		elseif(strpos($this->Browser,'Firefox')):
 			$this->Browser = 'Mozila Firefox';
 		elseif(strpos($this->Browser,'MSIE' ) || strpos($this->Browser,'Trident/')):
 			$this->Browser = 'IE';
 		else:
 			$this->Browser = 'Outros';
 		endif;
 	}


 	//Atualiza tabela com dados de navegadores(){
 	private function BrowserUpdate(){
 		$readAgent = new Read;
 		$readAgent->ExeRead('siteviews_agent','WHERE agent_name = :agent','agent={$this->Browser}');
 		if(!$readAgent->getResult()):
 			$ArrAgent = ['agent_name' => $this->Browser, 'agent_views' => 1];
 			$createAgent = new Create;
 			$createAgent->ExeCreate('siteviews_agent',$ArrAgent);
 		else:
 			$ArrAgent = [ 'agent_views' => $readAgent->getResult()[0]['agent_views'] + 1];
 			$updateAgent = new Update;
 			$updateAgent->ExeUpdate('siteviews_agent',$ArrAgent,'WHERE agent_name = :agent',':agent={$this->Browser}');
 		endif;
 	}


 	/**
 	* ****************************************
 	* ***** USUÁRIOS ONLINE ******************
 	* ****************************************
 	*/

 	//Cadastra usuário Online na tabela
 	private function setUsuario(){
 		$sesOnline = $_SESSION['useronline'];
 		$sesOnline['agent_name'] = $this->Browser;
 		$userCreate = new Create;
 		$userCreate->ExeCreate('siteviews_online',$sesOnline);
 		var_dump($sesOnline);
 	}

 	//Atualiza naveção do usuário online
 	private function UsuarioUpdate(){
 		$ArrOnline = ['online_endview' => $_SESSION['useronline']['online_endview'],
 					'online_url' => $_SESSION['useronline']['online_url'],
 		];
 		$userUpdate = new Update;
 		$userUpdate->ExeUpdate('siteviews_online',$ArrOnline,'WHERE online_session = :ses',"ses={$_SESSION['useronline']['online_session']}");

 		if(!$userUpdate->getRowCount()):
 			$readSes = new Read;
 			$readSes->ExeRead('siteviews_online','WHERE online_session = :onses',"onses={$_SESSION['useronline']['online_session']}");;
 			if(!$readSes->getRowCount()):
 				$this->setUsuario();
 			endif;
 		endif;
 	}
 }

 ?>