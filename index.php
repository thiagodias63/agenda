<?php
require("_app/config.inc.php");
require_once('bdd.php');
$sql = "SELECT id, color, start, end FROM events";
$read = new Read;
$read->ExeRead("events");
$events = $read->getResult();
//$req = $bdd->prepare($sql);
//$req->execute();
//$events = $req->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Agendamento</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<!-- FullCalendar -->
	<link href='css/fullcalendar.css' rel='stylesheet' />
    <!-- Custom CSS -->
    <style>
	#calendar {
		width: 60%;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div id="calendar" class="col-centered">
                </div>
            </div>
        </div>
        <!-- /.row -->
		<!-- Modal -->
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="addEvent.php">
			
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Event</h4>
			  </div>
			  <div class="modal-body">
				
				  <!--<div class="form-group">
					<label for="title" class="col-sm-2 control-label">Title</label>
					<div class="col-sm-10">
					  <input type="text" name="title" class="form-control" id="title" placeholder="Title">
					</div>
				  </div> -->
				  
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Cliente</label>
					<div class="col-sm-10">
					<select name="id_cliente" class="form-control" id="id_cliente">
					  <?php 
					  		$read = new Read;
					  		$read->ExeRead("cliente");
					  		$clientes = $read->getResult();
					  		foreach($clientes as $cliente){?>
					  			<option value="<?= $cliente['id_cliente'] ?>"> <?= $cliente['nome'] ?></option>
					  		<?php }
					  	?>
					</select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Serviço</label>
					
					<table>
					  <tr>
					  	<div class="col-sm-6"><select name="id_servico" class="form-control" id="id_servico">
					  	<?php 
					  		$read = new Read;
					  		$read->ExeRead("servicos");
					  		$servicos = $read->getResult();
					  		foreach($servicos as $servico){?>
					  			<option value="<?= $servico['id_servico'] ?>"> <?= $servico['nome'] ?></option> 
					  		<?php }
					  	?>
					  	</select></div>
					  	<td><div class="col-sm-12"><input type="number" class="form-control" name="preco_servico"></div></td>
					  </tr>
					</table>
				  </div>
				  
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Tipo</label>
					<div class="col-sm-10">
					  <input type="radio" name="tipo" id="id_servico" value="P.O">Pedido Orçamentos 
					  <input type="radio" name="tipo" id="id_servico" value="S.S" checked>Solicitação de Serviço
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Funcionarios</label>
					<div class="col-sm-10">
					  	<?php 
					  		$read = new Read;
					  		$read->ExeRead("funcionarios");
					  		$funcionarios = $read->getResult();
					  		foreach($funcionarios as $funcionario){?>
					  			<input type="checkbox"  name="<?= $funcionario['nome'] ?>" value="<?= $funcionario['id_funcionario'] ?>"> <?= $funcionario['nome'] ?>
					  		<?php }
					  	?>
					  </div>
				  </div>
				  
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Horario Inicio</label>
					<div class="col-sm-10">
					  <input type="datetime-local" name="start" class="form-control" id="start">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="end" class="col-sm-2 control-label">Horario Fim</label>
					<div class="col-sm-10">
					  <input type="datetime-local" name="end" class="form-control" id="end">
					</div>
				  </div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="editEventTitle.php">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit Event</h4>
			  </div>
			  <div class="modal-body">
					<div class="form-group">
						<label for="start" class="col-sm-2 control-label">Cliente</label>
					<div class="col-sm-10">
					<select name="id_cliente" class="form-control" id="id_cliente">
					</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Serviço</label>
					<table>
					  <tr>
					  	<div class="col-sm-6"><select name="id_servico" class="form-control" id="id_servico"></div>
					  	<td><div class="col-sm-12"><input type="number" class="form-control" name="preco_servico"></div></td>
					  </tr>
					</table>
				  </div>
				  
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Tipo</label>
					<div class="col-sm-10">
					  <input type="radio" name="tipo" id="id_servico" value="P.O">Pedido Orçamentos 
					  <input type="radio" name="tipo" id="id_servico" value="S.S" checked>Solicitação de Serviço
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Funcionarios</label>
					<div class="col-sm-10">
					  </div>
				  </div>
				  
				  <div class="form-group">
					<label for="start" class="col-sm-2 control-label">Horario Inicio</label>
					<div class="col-sm-10">
					  <input type="datetime-local" name="start" class="form-control" id="start">
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="end" class="col-sm-2 control-label">Horario Fim</label>
					<div class="col-sm-10">
					  <input type="datetime-local" name="end" class="form-control" id="end">
					</div>
				  </div>
				  <div class="form-group"> 
						<div class="col-sm-offset-2 col-sm-10">
						  <div class="checkbox">
							<label class="text-danger"><input type="checkbox"  name="delete"> Delete event</label>
						  </div>
						</div>
					</div>
				  <input type="hidden" name="id" class="form-control" id="id">
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>
	</div>
    <!-- /.container -->
    
    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<!-- FullCalendar -->
	<script src='js/moment.min.js'></script>
	<script src='js/fullcalendar.min.js'></script>
	   <!-- script de tradução -->
	<script src='lang/pt-br.js'></script>
	<script>
	$(document).ready(function() {
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			allDaySlot: false,
			defaultView: 'agendaWeek',
			defaultDate: '2017-09-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			nowIndicator:true,
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					//$('#ModalEdit #title').val(event.title);
					$('#ModalEdit').modal('show');
				});
			},
			eventDrop: function(event, delta, revertFunc) { // si changement de position
				edit(event);
			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur
				edit(event);
			},
			events: [
			<?php foreach($events as $event): 
				$start = explode(" ", $event['start']);
				$end = explode(" ", $event['end']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['start'];//.format('YYYY-MM-DD HH:mm:ss');
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['end'];//.format('YYYY-MM-DD HH:mm:ss');
				}
			?>
				{
					id: '<?php echo $event['id']; ?>',
					title: '<?php
								require_once('bdd.php');
								$tsql = "SELECT nome FROM cliente c JOIN events e ON c.id_cliente = e.id_cliente WHERE e.id = {$event['id']}";
								$req = $bdd->prepare($tsql);
								$req->execute();
								$titles = $req->fetchAll();
								foreach($titles as $title){
									echo $title['nome'];
								}
								$tsql = "SELECT nome FROM servicos s JOIN servicos_ss ss ON ss.id_servico = s.id_servico WHERE ss.id_agendamento = {$event['id']}";
								$req = $bdd->prepare($tsql);
								$req->execute();
								$titles = $req->fetchAll();
								foreach($titles as $title){
									echo " " . $title['nome'];
								}
								
								$tsql = "SELECT SUM(preco_servico) AS'total' FROM servicos s JOIN servicos_ss ss ON ss.id_servico = s.id_servico WHERE ss.id_agendamento = {$event['id']}";
								$req = $bdd->prepare($tsql);
								$req->execute();
								$titles = $req->fetchAll();
								foreach($titles as $title){
									echo " RS" . $title['total'] . ",00";
								}
					?>',
					color: '<?php echo $event['color']; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
				},
			<?php endforeach; ?>
			]
		});
		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}
			id =  event.id;
			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;
			$.ajax({
			 url: 'editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Saved');
					}else{
						alert('Could not be saved. try again.'); 
					}
				}
			});
		}
	});
</script>
</body>
</html>