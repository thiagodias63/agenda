<?php
/**
 * Classe de inserção no banco, generica
 */
class Read extends Conn {

	private $Select;
	private $Places;
	private $Result;

	/** @var PDOStatement */
	private $Read;

	/** @var PDO */
	private $Conn;

 	/**
 	* <b> ExeCreate </b> Executa um select simplificado no banco de dados utilizando prepared statements
 	* @param String $tabela = infrome o nome da tabela no banco
 	* @param Array $Dados = informe um array atribuitivo (Nome da coluna => valor , )
 	*/
 	public function ExeRead($Table, $Terms = null, $ParseString = null){
 		if(!empty($ParseString)):
 			$this->Places = $ParseString;
 		parse_str($ParseString, $this->Places);
 		endif;

 		$this->Select = "SELECT * FROM {$Table} {$Terms}";
 		$this->Execute();
 	}
 	public function getResult(){
 		return $this->Result;
 	}

 	public function getRowCount(){
 		return $this->Read->rowCount();//conta quantas linhas retornaram
 	}

 	public function FullRead($Query, $ParseString = null){
 		$this->Select = (string) $Query;
 		if(!empty($ParseString)):
 			$this->Places = $ParseString;
 		parse_str($ParseString, $this->Places);
 		endif; 	
 		$this->Execute();
 	}

 	public function setPlaces($ParseString){
 		parse_str($ParseString, $this->Places);
 		$this->Execute();
 	}
 	/**
 	* ****************************************
 	* *********** Private Methods ************
 	* ****************************************
 	*/
 	private function Connect() {
 		$this->Conn = parent::getConn();
 		$this->Read = $this->Conn->prepare($this->Select);
 		$this->Read->setFetchMode(PDO::FETCH_ASSOC);
 	}

 	private function getSyntax() {
 		if(!empty($this->Places)):
 			foreach($this->Places as $Vinculo => $Valor):
 				if($Vinculo == 'limit' || $Vinculo == 'offset'):
 					$Valor = (int) $Valor;
 				endif;
 				$this->Read->bindValue(":{$Vinculo}", $Valor, (is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
 				endforeach;
 				endif;
 	}

 	private function Execute() {
 				$this->Connect();
 				try{
 					$this->getSyntax();
 					$this->Read->execute();
 					$this->Result = $this->Read->fetchAll();

 				}
 				catch(PDOException $e){
 					$this->Result = null;
 				RCErro("<b>Erro ao Ler: </b> {$e->getMessage()}", $e->getCode());
 			}
 		}
 	}

 		?>