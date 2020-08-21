<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
				margin-top: 90px;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
		
		<!-- Bootstrap CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
		
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content mt-4">
				<div class="row mt-4">
					<div class="col-12" id="visualizan">
						<h1>Se visualizan todos</h1>
					</div>
					<div class="col-12">
						<input type="hidden" name="filtro" id="filtro" value="{{ old('filtro','todos') }}">
						<button type="button" onclick="status('todos')" class="btn btn-primary">Todos</button>
						<button type="button" onclick="status('activos')" class="btn btn-success">Activos</button>
						<button type="button" onclick="status('eliminados')" class="btn btn-danger">Eliminados</button>
						
						<table class="table table-bordered" id="users-table">
							<thead>
								<tr>
									<th>Id</th>
									<th>Nombre</th>
									<th>Correo</th>
									<th>Fecha de Creacion</th>
									<th>Eliminado</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
            </div>
        </div>
		<!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
		<script>
			$(function() {
				$('#users-table').DataTable({
					language: {
						"sProcessing":     "Procesando...",
						"sLengthMenu":     "Mostrar _MENU_ registros",
						"sZeroRecords":    "No se encontraron resultados",
						"sEmptyTable":     "Ningún dato disponible en esta tabla",
						"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
						"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
						"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
						"sInfoPostFix":    "",
						"sSearch":         "Buscar:",
						"sUrl":            "",
						"sInfoThousands":  ",",
						"sLoadingRecords": "Cargando...",
						"oPaginate": {
							"sFirst":    "Primero",
							"sLast":     "Último",
							"sNext":     "Siguiente",
							"sPrevious": "Anterior"
						},
						"oAria": {
							"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
							"sSortDescending": ": Activar para ordenar la columna de manera descendente"
						},
						"buttons": {
							"copy": "Copiar",
							"colvis": "Visibilidad"
						}
					},
					processing: true,
					serverSide: true,
					ajax: {
						url: '{!! route('user.data') !!}',
						data: function (d) {
							d.filtro = $('input[name=filtro]').val();
						}
					},
					columns: [
						{ data: 'id', name: 'id' },
						{ data: 'name', name: 'name' },
						{ data: 'email', name: 'email' },
						{ data: 'created_at', name: 'created_at' },
						{ data: 'deleted_at', name: 'deleted_at' }
					],
				});
			});
			
			function status(tipo){
				$('#filtro').val(tipo);
				$('#visualizan').html('<h1>Se visualizan '+tipo+'</h1>');
				var table = $('#users-table').DataTable();
				table.draw();
			}
			
			var defaultStatus = "{!! route('user.change_status',":id") !!}";
		
			function cambiar(id){
				
				var url = defaultStatus.replace(':id', id);
				
				$.ajax({
					type: 'GET',
					url: url,
					contentType: false,
					cache: false,
					processData: true,
					beforeSend: function(){
						//antes de mandar ajax
					},
					success: function(data){
						var table = $('#users-table').DataTable();
						table.draw();
					}
				});
			}
		</script>
	</body>
</html>
