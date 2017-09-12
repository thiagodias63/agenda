<?php
/** 
 * Login.Class [ MODEL ]
 * Responsavel por autenticar, validar e checar usuários do sistema de login
 * @copyright (c) 2017, Thiago Dias
 */
class Login{
	private $Level;
	private $Email;
	private $Senha;
	private $Error;
	private $Result;

	function __construct($Level){
		$this->Level = (int) $Level;
	}

	public function ExeLogin(array $UserData){
		$this->Email = (string) strip_tags(trim($UserData['user']));
		$this->Senha = (string) strip_tags(trim($UserData['pass']));
		$this->setLogin();
	}

	public function getResult(){
		return $this->Result;
	}

	public function getError(){
		return $this->Error;
	}

	public function CheckLogin(){
		if(empty($_SESSION['userlogin']) || $_SESSION['userlogin']['user_level'] < $this->Level):
			unset($_SESSION['userlogin']);
			return false;
		else:
			return true;
		endif;
	}
	/**
 	* ****************************************
 	* *********** Private Methods ************
 	* ****************************************
 	*/

 	//Verifica se os dados foram informados 
 	private function setLogin(){
 		if(!$this->Email || !$this->Senha || !Check::Email($this->Email)):
 			$this->Error = ['Informe seu e-mail e senha para efetuar login',RC_INFOR];
 			$this->Result = false;
 		elseif(!$this->getUser()):
			$this->Error = ['EMAIL OU SENHA INCORRETOS',RC_ALERT];
			$this->Result = false;
		elseif($this->Result['user_level'] < $this->Level):
			$this->Error = ["Desculpe {$this->Result['user_name']},você não tem acesso a essa área",RC_ALERT];
			$this->Result = false;
		else:
			$this->Execute();
 		endif;
 	}

 	//criar o recupera senha

 	private function getUser(){
	 	$this->Senha = md5($this->Senha);

 		$read = new Read;
 		$read->ExeRead('users','WHERE user_email= :email AND user_password = :pass',"email={$this->Email}&pass={$this->Senha}");
 		if($read->getResult()):
 			$this->Result = $read->getResult()[0];
 			return true;
 		else:
 			return false;
 		endif;
 	}

 	private function Execute(){
 		if(!session_id()):
 			session_start();
 		endif;
 		$_SESSION['userlogin'] = $this->Result;
 		$this->Error = ["Olá{$this->Result['user_name']}, seja bem-vindo(a), aguarde redirecinamento!", RC_ACCEPT];
 		$this->Result = true;
 	}
 }
?>