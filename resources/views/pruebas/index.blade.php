@extends('layouts.app')

@section('title', 'Pruebas')

@section('content')
<section class="full-box dashboard-contentPage">
    <nav class="full-box dashboard-Navbar">
		<ul class="full-box list-unstyled text-right">
			<li class="pull-left">
				<a href="#!" class="btn-menu-dashboard"><i class="zmdi zmdi-more-vert"></i></a>
			</li>
			<li>
				<a href="#!" class="btn-Notifications-area">
					<i class="zmdi zmdi-notifications-none"></i>
					<span class="badge">7</span>
				</a>
			</li>
			<li>
				<a href="#!" class="btn-search">
					<i class="zmdi zmdi-search"></i>
				</a>
			</li>
			<li>
				<a href="#!" class="btn-modal-help">
					<i class="zmdi zmdi-help-outline"></i>
				</a>
			</li>
		</ul>
	</nav>
	<div class="container-fluid">
		<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i>Pruebas</h1>
		</div>
		<p class="lead">
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12">
				<ul class="nav nav-tabs" style="margin-bottom: 15px;">
					<li class="active"><a href="#list" data-toggle="tab">Lista</a></li>
					<li><a href="#new" data-toggle="tab">Nuevo</a></li>
				</ul>
				<div id="myTabContent" class="tab-content">
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="list">
                            <div class="table-responsive">
                                <table class="table table-hover text-center" id="tab-pruebas">
                                    <thead>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary" id="btnAreaDesarrollo">
                                                Área de Desarrollo
                                            </button>
                                            <button type="button" class="btn btn-primary" id="btnTipoPrueba">
                                                Tipos de Pruebas
                                            </button>
                                            <button type="button" class="btn btn-primary" id="btnRangoEdad">
                                                Rangos de Edades
                                            </button>
                                        </div>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Área de Desarrollo</th>
                                            <th class="text-center">Tipo de Prueba</th>
                                            <th class="text-center">Rango de Edad</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                </table>    
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="new">
                        <div class="row">
							<div class="col-xs-12 col-md-10 col-md-offset-1">
                                <form id="registro-prueba">@csrf
                                    <div id="paso1">
                                        <h3>Datos de la Prueba</h3>
                                        <div class="fila-formulario">
                                            <div class="form-group label-floating col-md-6">
												<label class="control-label">Nombre</label>
												<input class="form-control" id="nombre" name="nombre" type="text">
											</div>
                                            <div class="form-group label-floating col-md-6">
                                                <label class="control-label">Descripción</label>
                                                <input class="form-control" id="descripcion" name="descripcion" type="text" required>
                                            </div>
                                            <div class="form-grup col-md-6">
                                                <select class="form-control select2" required style="width: 100%;" id="area_desarrollo_id" name="area_desarrollo_id">
                                                    <option selected disabled>Seleccione el area de desarrollo</option>
                                                        @foreach ($areaDesarrollos as $areaDesarrollo)
                                                    <option value="{{ $areaDesarrollo->id }}">{{ $areaDesarrollo->area_desarrollo }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="form-grup col-md-6">
                                                <select class="form-control select2" required style="width: 100%;" id="tipo_prueba_id" name="tipo_prueba_id">
                                                    <option selected disabled>Seleccione el tipo de prueba</option>
                                                        @foreach ($tipoPruebas as $tipoPrueba)
                                                    <option value="{{ $tipoPrueba->id }}">{{ $tipoPrueba->tipo }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="form-grup col-md-6">
                                                <select class="form-control select2" required style="width: 100%;" id="rango_edad_id" name="rango_edad_id">
                                                    <option selected disabled>Seleccione el rango de edad</option>
                                                        @foreach ($rangoPruebas as $rangoPrueba)
                                                    <option value="{{ $rangoPrueba->id }}">{{ $rangoPrueba->rango_edad }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <p class="centro-texto">
                                            <button type="button" id="siguiente" class="btn btn-primary">Siguiente</button>
                                        </p>
                                    </div>
                                    <div id="paso2">
                                        <h3>Items de la Prueba</h3>
                                        <div id="itemsContainer">
                                            <div class="fila-formulario" id="formulario-item-0">
                                                <div class="form-group label-floating col-md-6">
                                                    <label class="control-label">Item</label>
                                                    <input class="form-control" name="items[0][nombre]" type="text" required>
                                                </div>
                                                <div class="form-group label-floating col-md-6">
                                                    <h5>¿El item tiene algún valor?</h5>
                                                    <div class="d-flex align-items-center">
                                                        <label><input type="radio" name="items[0][valorI]" value="si" required onclick="toggleValorInput(0)"> Sí</label>
                                                        <label><input type="radio" name="items[0][valorI]" value="no" onclick="toggleValorInput(0)"> No</label>
                                                        <input class="form-control valor" name="items[0][valor]" type="text" placeholder="Especificar el valor" style="display: none;">
                                                        <input class="form-control interpretacion" name="items[0][interpretacion]" type="text" placeholder="Especificar interpretación" style="display: none;">
                                                    </div>
                                                </div>
                                                <button type="button" class="eliminar btn btn-danger" onclick="eliminarItem(this)">Eliminar</button>
                                            </div>
                                        </div>
                                        <p class="centro-texto">
                                            <button type="button" id="addItem" class="btn btn-primary">Agregar Item</button>
                                            <button type="button" id="regresar" class="btn btn-primary">Regresar</button>
                                            <button type="submit" name="registrar" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i>Registrar</button>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal Área de Desarrollo -->
<div class="modal fade" id="modalAreaDesarrollo" tabindex="-1" role="dialog" aria-labelledby="modalAreaDesarrolloLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAreaDesarrolloLabel">Áreas de Desarrollo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="areaDesarrolloForm">
                    <div class="form-group label-floating ">
                        <label for="areaDesarrollo" class="control-label">Área de Desarrollo</label>
                        <input type="text" class="form-control" id="area_desarrollo" name="area_desarrollo" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tipos de Pruebas -->
<div class="modal fade" id="modalTipoPrueba" tabindex="-1" role="dialog" aria-labelledby="modalTipoPruebaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTipoPruebaLabel">Tipos de Pruebas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="tipoPruebaForm">
                    <div class="form-group label-floating ">
                        <label for="tipoPrueba" class="control-label">Tipo de Prueba</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Rangos de Edades -->
<div class="modal fade" id="modalRangoEdad" tabindex="-1" role="dialog" aria-labelledby="modalRangoEdadLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRangoEdadLabel">Rangos de Edades</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rangoEdadForm">
                    <div class="form-group label-floating ">
                        <label for="rangoEdad" class="control-label">Rango de Edad</label>
                        <input type="text" class="form-control" id="rango_edad" name="rango_edad" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
$(document).ready(function() {
    $("#paso1").show();
    $("#paso2").hide();

    $("#siguiente").click(function() {
        $("#paso1").hide();
        $("#paso2").show();
    });

    $("#regresar").click(function() {
        $("#paso2").hide();
        $("#paso1").show();
    });

  

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#btnAreaDesarrollo').click(function() {
        $('#modalAreaDesarrollo').modal('show');
    });
    $('#areaDesarrolloForm').on('submit', function(e) {
        e.preventDefault(); 

        $.ajax({
            type: 'POST',
            url: '{{ route('pruebas.storeAreaDesarrollo') }}', 
            data: $(this).serialize(), 
            success: function(response) {
                toastr.success(response.message, 'Éxito', { timeOut: 5000 }); 
                $('#modalAreaDesarrollo').modal('hide');
                location.reload(); 
            },
            error: function(xhr) {
                toastr.error('Error al registrar el área de desarrollo: ' + xhr.responseText, 'Error', { timeOut: 5000 });
            }
        });
    });
    $('#btnTipoPrueba').click(function() {
        $('#modalTipoPrueba').modal('show');
    });
    $('#tipoPruebaForm').on('submit', function(e) {
        e.preventDefault(); 

        $.ajax({
            type: 'POST',
            url: '{{ route('pruebas.storeTipoPrueba') }}', 
            data: $(this).serialize(), 
            success: function(response) {
                toastr.success(response.message, 'Éxito', { timeOut: 5000 }); 
                $('#modalTipoPrueba').modal('hide');
                location.reload(); 
            },
            error: function(xhr) {
                toastr.error('Error al registrar el tipo de prueba: ' + xhr.responseText, 'Error', { timeOut: 5000 });
            }
        });
    });
    $('#btnRangoEdad').click(function() {
        $('#modalRangoEdad').modal('show');
    });
    $('#rangoEdadForm').on('submit', function(e) {
        e.preventDefault(); 

        $.ajax({
            type: 'POST',
            url: '{{ route('pruebas.storeRangoPrueba') }}', 
            data: $(this).serialize(), 
            success: function(response) {
                toastr.success(response.message, 'Éxito', { timeOut: 5000 });
                $('#modalRangoEdad').modal('hide');
                location.reload(); 
            },
            error: function(xhr) {
                toastr.error('Error al registrar el tipo de prueba: ' + xhr.responseText, 'Error', { timeOut: 5000 });
            }
        });
    });

    $("#registro-prueba").on("submit", function(event) {
        event.preventDefault(); 
        const formData = $(this).serialize(); 
        console.log(formData); 
        $.ajax({
            url: "{{ route('pruebas.storePrueba') }}", 
            type: 'POST', 
            data: formData, 
            success: function(response) {
                console.log(response); 
                toastr.success("Prueba registrada exitosamente."); 
                $("#registro-prueba")[0].reset(); 
                location.reload(); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
                toastr.error("Error al registrar la prueba: " + xhr.responseText); 
            }
        });
    });

    let contadorItems = 1;

    $("#addItem").click(function () {
        const nuevoItemFormulario = `
            <div class="fila-formulario" id="formulario-item-${contadorItems}">
                <div class="form-group label-floating col-md-6">
                    <label class="control-label">Item</label>
                    <input class="form-control" name="items[${contadorItems}][nombre]" type="text" required>
                </div>
                <div class="form-group label-floating col-md-6">
                    <h5>¿El item tiene algún valor?</h5>
                    <div class="d-flex align-items-center">
                        <label><input type="radio" name="items[${contadorItems}][valorI]" value="si" required onclick="toggleValorInput(${contadorItems})"> Sí</label>
                        <label><input type="radio" name="items[${contadorItems}][valorI]" value="no" onclick="toggleValorInput(${contadorItems})"> No</label>
                        <input class="form-control valor" name="items[${contadorItems}][valor]" type="text" placeholder="Especificar el valor" style="display: none;">
                        <input class="form-control interpretacion" name="items[${contadorItems}][interpretacion]" type="text" placeholder="Especificar interpretación" style="display: none;">
                    </div>
                </div>
                <button type="button" class="eliminar btn btn-danger" onclick="eliminarItem(this)">Eliminar</button>
            </div>`;
        $("#itemsContainer").append(nuevoItemFormulario);
        contadorItems++;
    });
});

function toggleValorInput(index) {
    const valorInputs = document.querySelectorAll(`input[name="items[${index}][valorI]"]`);
    const mostrarValor = valorInputs[0].checked;
    const valorField = document.querySelector(`input[name="items[${index}][valor]"]`);
    const interpretacionField = document.querySelector(`input[name="items[${index}][interpretacion]"]`);

    if (mostrarValor) {
        valorField.style.display = "block";
        interpretacionField.style.display = "block";
    } else {
        valorField.style.display = "none";
        interpretacionField.style.display = "none";
        valorField.value = "no aplica";
        interpretacionField.value = "no aplica";
    }
}

function eliminarItem(elemento) {
    elemento.closest(".fila-formulario").remove();
}
</script>
<script>
$(document).ready(function(){
    var tablaPruebas = $('#tab-pruebas').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('pruebas.index') }}", // Asegúrate de que esta ruta sea correcta
            type: 'GET', 
        },
        columns: [
            { data: 'id' }, // Asegúrate de que 'id' esté en tu consulta
            { data: 'nombre' },
            { data: 'descripcion' },
            { data: 'areaDesarrollo' }, // Columna para el área de desarrollo
            { data: 'tipo' }, // Columna para el tipo de prueba
            { data: 'rangoEdad' }, // Columna para el rango de edad
            { data: 'status' }, // Columna para el estado
            { data: 'action', orderable: false, searchable: false } // Desactivar orden y búsqueda en la columna de acciones
        ]
    });
});
</script>

@endsection