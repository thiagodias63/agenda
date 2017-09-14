<?php
/**
* @copyright (c) 2017, Thiago Dias
*/
class FuncionariosSS{
	private $Id;
	private $Funcionario;
	private $Agendamento;
	private $Error;
	private $Result;

	public function AdicionarFuncionarioSS(array $ListaFuncionario){
		$create = new Create;
		try{
			$create->ExeCreate("funcionarios_ss",$ListaFuncionario);
			$this->Result = $create->getResult();
		}
		catch (Exception $e){
			$this->Result = $e->Message;
		}

	}

	public function getResult(){
		return $this->Result;
	}

	public function getError(){
		return $this->Error;
	}
}
