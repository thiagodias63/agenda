<?php
/**
 * Classe de inserção no banco, generica
 */
class Update extends Conn {

	private $Tabela;
	private $Dados;
	private $Termos;
	private $Places;
	private $Result;

	/** @var PDOStatement */
	private $Update;

	/** @var PDO */
	private $Conn;

 	/**
 	* <b> ExeCreate </b> Executa um update simplificado no banco de dados utilizando prepared statements
 	* @param String $tabela = infrome o nome da tabela no banco
 	* @param Array $Dados = informe um array atribuitivo (Nome da coluna => valor , )
 	*/
 	public function ExeUpdate($Table, array $Dados, $Terms, $ParseString){
 		$this->Tabela =  (string)$Table;
 		$this->Dados =$Dados;
 		$this->Termos = $Terms;

 		parse_str($ParseString, $this->Places);
 		$this->getSyntax();
 		$this->Execute();
 	}
 	public function getResult(){
 		return $this->Result;
 	}

 	public function getRowCount(){
 		return $this->Update->rowCount();//conta quantas linhas retornaram
 	}

 	public function setPlaces($ParseString){
 		parse_str($ParseString, $this->Places);
 		$this->getSyntax();
 		$this->Execute();
 	}
 	/**
 	* ****************************************
 	* *********** Private Methods ************
 	* ****************************************
 	*/
 	private function Connect() {
 		$this->Conn = parent::getConn();
 		$this->Update = $this->Conn->prepare($this->Update);
 	}

 	private function getSyntax() {
 		foreach($this->Dados as $Key => $Value):
 			$Places[] = $Key . ' = :' . $Key;
 		endforeach;

 		$Places = implode(', ', $Places);
 		$this->Update = "UPDATE {$this->Tabela} SET {$Places} {$this->Termos}";
 	}
 	private function Execute() {
 			$this->Connect();
 			try{
 				$this->Update->execute(array_merge($this->Dados, $this->Places));
 				$this->Result = true;
 				}
 				catch(PDOException $e){
 					$this->Result = null;
 					RCErro("<b>Erro ao Aualizar: </b> {$e->getMessage()}", $e->getCode());
 				}
 			}

 		}
?>