<?php
/**
* @copyright (c) 2017, Thiago Dias
*/
class ServicosSS{
	private $Id;
	private $Servico;
	private $Agendamento;
	private $Preco;
	private $Status;
	private $Error;
	private $Result;

	public function AdicionarServicoSS(array $ListaServico){
		$create = new Create;
		try{
			$create->ExeCreate("servicos_ss",$ListaServico);
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
