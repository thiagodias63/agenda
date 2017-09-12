<?php
class AlteracaoScript{
	public function AlteracaoB1($Campo){
		$read = new Read;
		//$read->FullRead("SELECT id_cliente FROM cliente WHERE id_cliente < 1000");
		$read->FullRead("SELECT cliente_id_cliente FROM estrutura_construcao WHERE cliente_id_cliente < 1000");
		$campo = new Read;
		$update = new Update;
		//$campo->FullRead("SELECT c.{$Campo} FROM cliente c JOIN cliente_empresa ce WHERE c.id_cliente = ce.id ");
		$campo->FullRead("SELECT c.{$Campo} FROM estrutura_construcao c JOIN cliente_empresa ce ON c.cliente_id_cliente = ce.id WHERE cliente_id_cliente < 1000");
		for($i=0; $i < $read->getRowCount(); $i++){
			var_dump($campo->getResult()[$i]);
			echo "<br>";
			$Dados = ["{$Campo}"=>implode($campo->getResult()[$i])];
			$Where_Clause =  implode($read->getResult()[$i]);
			$update->ExeUpdate("cliente_empresa",$Dados, "WHERE id = :id", "id=". $Where_Clause);
		}
	}
	public function AlteracaoB2($Campo){
		$read = new Read;
		//$read->FullRead("SELECT id_cliente FROM cliente WHERE id_cliente BETWEEN 1000 AND 1999");
		$read->FullRead("SELECT cliente_id_cliente FROM estrutura_construcao WHERE cliente_id_cliente BETWEEN 1000 AND 1999");
		$campo = new Read;
		$update = new Update;
		$campo->FullRead("SELECT c.{$Campo} FROM estrutura_construcao c JOIN cliente_empresa ce ON c.cliente_id_cliente = ce.id WHERE c.cliente_id_cliente BETWEEN 1000 AND 1999");
		
		//for($i=1000; $i < 2000; $i++){
		for($j=0; $j < 999; $j++){
			var_dump($campo->getResult()[$j]);
			echo "<br>";
			$Dados = ["{$Campo}"=>implode($campo->getResult()[$j])];
			$Where_Clause =  implode($read->getResult()[$j]);
			$update->ExeUpdate("cliente_empresa",$Dados, "WHERE id = :id", "id=". $Where_Clause);
		}
		//}
	}
	public function AlteracaoB3($Campo){
		$read = new Read;
		//$read->FullRead("SELECT id_cliente FROM cliente WHERE id_cliente BETWEEN 2000 AND 2999");
		$read->FullRead("SELECT cliente_id_cliente FROM estrutura_construcao WHERE cliente_id_cliente BETWEEN 2000 AND 2999");
		$campo = new Read;
		$update = new Update;
		//$campo->FullRead("SELECT c.{$Campo} FROM cliente c JOIN cliente_empresa ce ON c.id_cliente = ce.id WHERE c.id_cliente BETWEEN 2000 AND 2999");
		$campo->FullRead("SELECT c.{$Campo} FROM estrutura_construcao c JOIN cliente_empresa ce ON c.cliente_id_cliente = ce.id WHERE c.cliente_id_cliente BETWEEN 2000 AND 2999");
		//for($i=2000; $i < 3000; $i++){
		for($j=0; $j < 999; $j++){
			var_dump($campo->getResult()[$j]);
			echo "<br>";
			$Dados = ["{$Campo}"=>implode($campo->getResult()[$j])];
			$Where_Clause =  implode($read->getResult()[$j]);
			$update->ExeUpdate("cliente_empresa",$Dados, "WHERE id = :id", "id=". $Where_Clause);
		}
		//}
	}
	public function AlteracaoB4($Campo){
		$read = new Read;
		//$read->FullRead("SELECT id_cliente FROM cliente WHERE id_cliente BETWEEN 2999 AND 4124");
		$read->FullRead("SELECT cliente_id_cliente FROM estrutura_construcao WHERE cliente_id_cliente BETWEEN 2999 AND 4124");
		$campo = new Read;
		$update = new Update;
		//$campo->FullRead("SELECT c.{$Campo} FROM cliente c JOIN cliente_empresa ce ON c.id_cliente = ce.id WHERE c.id_cliente BETWEEN 2999 AND 4124");
		$campo->FullRead("SELECT c.{$Campo} FROM estrutura_construcao c JOIN cliente_empresa ce ON c.cliente_id_cliente = ce.id WHERE c.cliente_id_cliente BETWEEN 2999 AND 4124");
		//for($i=3000; $i < 4125; $i++){
		for($j=0; $j < 1025; $j++){
			var_dump($campo->getResult()[$j]);
			echo "<br>";
			$Dados = ["{$Campo}"=>implode($campo->getResult()[$j])];
			$Where_Clause =  implode($read->getResult()[$j]);
			$update->ExeUpdate("cliente_empresa",$Dados, "WHERE id = :id", "id=". $Where_Clause);
		}
		//}
	}
}
?>