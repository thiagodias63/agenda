<?php
/**
 * Classe de exclusão no banco, generica
 */
class Delete extends Conn {

	private $Tabela;
	private $Termos;
	private $Places;
	private $Result;

	/** @var PDOStatement */
	private $Delete;

	/** @var PDO */
	private $Conn;

 	/**
 	* <b> ExeCreate </b> Executa um update simplificado no banco de dados utilizando prepared statements
 	* @param String $tabela = infrome o nome da tabela no banco
 	* @param Array $Dados = informe um array atribuitivo (Nome da coluna => valor , )
 	*/
 	public function ExeDelete($Table, $Terms, $ParseString){
 		$this->Tabela =  (string)$Table;
 		$this->Termos = $Terms;

 		parse_str($ParseString, $this->Places);
 		$this->getSyntax();
 		$this->Execute();
 	}
 	public function getResult(){
 		return $this->Result;
 	}

 	public function getRowCount(){
 		return $this->Delete->rowCount();//conta quantas linhas retornaram
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
 		$this->Delete = $this->Conn->prepare($this->Delete);/**/
 	}

 	private function getSyntax() {
 		$this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
 	}
 	private function Execute() {
 			$this->Connect();
 			try{
 					$this->Delete->execute($this->Places);
 					$this->Result = true;
 				}
 				catch(PDOException $e){
 					$this->Result = null;
 			RCErro("<b>Erro ao Deletar: </b> {$e->getMessage()}", $e->getCode());
 				}
 			}

 		}

 		?>