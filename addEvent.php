<?php
/*
	$sql = "INSERT INTO events(title, start, end) values ('$title', '$start', '$end')";
	//$req = $bdd->prepare($sql);
	//$req->execute();
	$query = $bdd->prepare( $sql );
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Erreur execute');
	}

}
//header('Location: index.php');
*/
require("_app/config.inc.php");
$evento = new Agendamento;
$cliente = $_POST['id_cliente'];
$tipo = $_POST['tipo'];
$servicos = $_POST['id_servico'];
$preco = $_POST['preco_servico'];
$start = $_POST['start'];
$end = $_POST['end'];
$agendamento = 0;
$events['start'] = $start;
$events['end'] = $end;
$events['id_cliente'] = $cliente;
$evento->CriarEvento($events);
$agendamento = $evento->getResult();
/*foreach ($servicos as $servico){
	$listaServicoSS = new ServicoSS;
	$servico['id_agendamento'] = $agendamento;
	$listaServicoSS->ExeAdicionarServicoSS($servico);
	
	insert into servicos_ss(id_servico, preco_servico, id_agendamento) values(4,150,6);
}*/
$servico['id_servico'] = $servicos;
$servico['preco_servico'] = $preco;
$servico['id_agendamento'] = $agendamento;
$listaServicoSS = new ServicosSS;
$listaServicoSS->AdicionarServicoSS($servico);

$valmir=(isset($_POST['Valmir'])) ? $_POST['Valmir'] : false;
$samuel=(isset($_POST['Samuel']))? $_POST['Samuel']: false;
$ronalt=(isset($_POST['Ronalt'])) ? $_POST['Ronalt'] : false;
$cristiano=(isset($_POST['Cristiano']))? $_POST['Cristiano']: false;

if($valmir){
	$funcionariosSS = new FuncionariosSS;
	$funcionario['id_funcionario'] = $valmir;
	$funcionario['id_agendamento'] = $agendamento;
	$funcionariosSS->AdicionarFuncionarioSS($funcionario);
}
if($samuel){
	$funcionariosSS = new FuncionariosSS;
	$funcionario['id_funcionario'] = $samuel;
	$funcionario['id_agendamento'] = $agendamento;
	$funcionariosSS->AdicionarFuncionarioSS($funcionario);	
}
if($ronalt){
	$funcionariosSS = new FuncionariosSS;
	$funcionario['id_funcionario'] = $ronalt;
	$funcionario['id_agendamento'] = $agendamento;
	$funcionariosSS->AdicionarFuncionarioSS($funcionario);
}
if($cristiano){
	$funcionariosSS = new FuncionariosSS;
	$funcionario['id_funcionario'] = $cristiano;
	$funcionario['id_agendamento'] = $agendamento;
	$funcionariosSS->AdicionarFuncionarioSS($funcionario);
}
header("Location: index.php");