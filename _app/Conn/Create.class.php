<?php
/**
 * Classe de inserção no banco, generica
 */
 class Create extends Conn {

 	private $Tabela;
 	private $Dados;
 	private $Result;

 	/** @var PDOStatement */
 	private $Create;

 	/** @var PDO */
 	private $Conn;
 	
 	/**
 	* <b> ExeCreate </b> Executa um cadastro simplificado no banco de dados utilizando prepared statements
 	* @param String $tabela = infrome o nome da tabela no banco
 	* @param Array $Dados = informe um array atribuitivo (Nome da coluna => valor , )
 	*/
 	public function ExeCreate($Table, array $Dados){
 		$this->Tabela = (string) $Table;
 		$this->Dados = $Dados;

 		$this->getSyntax();
 		$this->Execute();
 	}
 	public function getResult(){
 		return $this->Result;
 	}

 	/**
 	* ****************************************
 	* *********** Private Methods ************
 	* ****************************************
 	*/

 	private function Connect() {
 		$this->Conn = parent::getConn();
 		$this->Create = $this->Conn->prepare($this->Create);
 	}

 	private function getSyntax() {
 		$Fileds = implode(', ', array_keys($this->Dados));
 		$Places = ':' . implode(', :', array_keys($this->Dados));
 		$this->Create = "INSERT INTO  {$this->Tabela} ({$Fileds}) VALUES ({$Places})";
 	}

 	private function Execute() {
 		$this->Connect();
 		try{
 			$this->Create->execute($this->Dados);
 			$this->Result = $this->Conn->lastInsertId();
 		}
 		catch(PDOException $e){
 			$this->Result = null;
 			RCErro("<b>Erro ao cadastrar: </b> {$e->getMessage()}", $e->getCode());
 		}
 	}

 }

?>