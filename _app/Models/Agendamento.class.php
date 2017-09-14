<?php
/**
 * Responsavel por autenticar, validar e checar usuários do sistema de login
 * @copyright (c) 2017, Thiago Dias
 */
class Agendamento{
	private $Id;
	private $Color;
	private $Start;
	private $End;
	private $Cliente;
	private $Error;
	private $Result;

	public function CriarEvento(array $Evento){
		$create = new Create;
		try{
			$create->ExeCreate("events",$Evento);
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
