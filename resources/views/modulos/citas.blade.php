@extends('principal')

@section('title',"Citas | Cachorro PET")

@section ('contenido')
{{ Breadcrumbs::render('citas') }}

<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('registro.citas') }}">
        @csrf
        <div class="row">
            <div class="col-lg-6 mb-3">
                <label for="nombre_mascota" class="form-label">Nombre de la mascota:</label>
                <input type="text" class="form-control @error('nombre_mascota') is-invalid @enderror"
                    value="{{ old('nombre_mascota') }}" id="nombre_mascota" name="nombre_mascota">
                @error('nombre_mascota')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="raza_mascota" class="form-label">Raza de la mascota:</label>
                <input type="text" class="form-control @error('raza_mascota') is-invalid @enderror"
                    value="{{ old('raza_mascota') }}" id="raza_mascota" name="raza_mascota">
                @error('raza_mascota')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="nombre_propietario" class="form-label">Nombre del propietario:</label>
                <input type="text" class="form-control @error('nombre_propietario') is-invalid @enderror"
                    value="{{ old('nombre_propietario') }}" id="nombre_propietario" name="nombre_propietario">
                @error('nombre_propietario')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="telefono_propietario" class="form-label">Teléfono del propietario:</label>
                <input type="text" class="form-control @error('telefono_propietario') is-invalid @enderror"
                    value="{{ old('telefono_propietario') }}" id="telefono_propietario" name="telefono_propietario">
                @error('nombre_propietario')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="edad_mascota" class="form-label">Edad de la Mascota:</label>
                <input type="text" class="form-control @error('edad_mascota') is-invalid @enderror"
                    value="{{ old('edad_mascota') }}" id="edad_mascota" name="edad_mascota">
                @error('edad_mascota')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="sexo_mascota" class="form-label">Sexo de la Mascota:</label>
                <select class="form-select @error('sexo_mascota') is-invalid @enderror" id="sexo_mascota"
                    name="sexo_mascota">
                    <option value="">[Seleccionar]</option>
                    <option value="Macho" {{ old('sexo_mascota')=='Macho' ? 'selected' : '' }}>Macho</option>
                    <option value="Hembra" {{ old('sexo_mascota')=='Hembra' ? 'selected' : '' }}>Hembra</option>
                </select>
                @error('sexo_mascota')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-lg-6 mb-3">
                <label for="fecha_cita" class="form-label">Fecha de la cita:</label>
                <input type="date" class="form-control @error('fecha_cita') is-invalid @enderror"
                    value="{{ old('fecha_cita') }}" id="fecha_cita" name="fecha_cita">
                @error('fecha_cita')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="hora_cita" class="form-label">Hora de la cita:</label>
                <select class="form-select @error('hora_cita') is-invalid @enderror" id="hora_cita" name="hora_cita">
                    <option selected>[Seleccionar Hora]</option>
                    @foreach($horario as $horario_items)
                    <option value="{{ $horario_items->idhorario }}">{{ $horario_items->horario }}</option>
                    @endforeach
                </select>
                @error('hora_cita')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-6 mb-3">
                <label for="razon_cita" class="form-label">Tipo de Servicio:</label>
                <select class="form-select @error('razon_cita') is-invalid @enderror"
                    aria-label="Default select example" id="razon_cita" name="razon_cita">
                    <option selected>[Seleccionar servicio]</option>
                    @foreach($servicios as $servicio_item)
                    <option value="{{ $servicio_item->tipo }}" {{ $servicio && $servicio_item->idservicio ==
                        $servicio->idservicio ? 'selected' : '' }}>
                        {{ $servicio_item->tipo }}
                    </option>
                    @endforeach
                    <option value="otro" {{ old('razon_cita')=='otro' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('razon_cita')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="motivoOtroDiv" class="col-12 mb-3"
                style="display: {{ old('servicio') == 'otro' ? 'block' : 'none' }}">
                <label for="motivo_otro" class="form-label">Especifique el motivo de su cita:</label>
                <textarea class="form-control @error('motivo_otro') is-invalid @enderror" id="motivo_otro"
                    name="motivo_otro" rows="4">{{ old('motivo_otro') }}</textarea>
                @error('motivo_otro')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @if (session()->has('idusuario'))
        <button type="submit" class="btn btn-rojopet">Registrar cita</button>
        @else
        <a href="{{ route('iniciar') }}" class="btn btn-rojopet">Registrar cita</a>
        @endif
    </form>
</div> <br><br>


<!-- Agrega este código al final de tu vista de Blade, después del formulario -->
@if(session('mostrar_encuesta') || app('request')->input('mostrar_encuesta_prueba'))
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
            $('#encuestasatisfaccion').modal('show');
        });

        // Agrega un event listener al botón para mostrar la encuesta de satisfacción
        $('#btnMostrarEncuesta').click(function () {
            $('#encuestasatisfaccion').modal('show');
        });
</script>
@endif




@endsection
<div class="modal" id="encuestasatisfaccion" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Encuesta de satisfacción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Cómo calificarías nuestros servicios?</p>
                <center>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio1">Excelente<br><i
                                class="fa-regular fa-face-laugh-wink"></i></label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2">Bueno<br><i
                                class="fa-regular fa-face-smile"></i></label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio3">Regular<br><i
                                class="fa-regular fa-face-meh"></i></label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio4">Malo<br><i
                                class="fa-regular fa-face-frown"></i></label>
                    </div>
                </center>
                <br><br>

                <!-- Textarea que se mostrará cuando se seleccione "Excelente" -->
                <div id="comentarioExcelente" style="display: none;">
                    <div class="form-floating"><br>
                        <label for="comentario" class="form-label">Cuentanos tu experiencia (opcional):</label><br>
                        <textarea class="form-control" id="floatingTextarea2" style="height: 100px"></textarea>
                    </div>
                </div>
                <div id="comentarioBuenoRegularMalo" style="display: none;">
                    <label for="comentario" class="form-label">En que podemos mejorar:</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Proporcionar información más clara sobre los servicios ofrecidos.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                            Reducir el tiempo de espera.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                            Mejorar la atención al cliente.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                            Mejorar las instalaciones para mayor comodidad.
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                            Simplificar el proceso de registro.
                        </label>
                    </div>
                    <div class="form-floating"><br>
                        <label for="comentario" class="form-label">Comentario (opcional):</label><br>
                        <textarea class="form-control" id="floatingTextarea2" style="height: 100px"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-rojopet">Enviar Encuesta</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Event listener para el cambio en los botones de radio
        $('input[name="btnradio"]').change(function () {
            // Oculta todos los comentarios
            $('[id^="comentario"]').hide();

            // Muestra el comentario correspondiente a la opción seleccionada
            if ($(this).attr('id') === 'btnradio1') { // Opción "Excelente"
                $('#comentarioExcelente').show();
            }
            else if($(this).attr('id') === 'btnradio2'){
                $('#comentarioBuenoRegularMalo').show();
            }
            else if($(this).attr('id') === 'btnradio3'){
                $('#comentarioBuenoRegularMalo').show();
            }
            else if($(this).attr('id') === 'btnradio4'){
                $('#comentarioBuenoRegularMalo').show();
            }
        });
    });
</script>

@if(session('mostrar_encuesta'))
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
            $('#encuestasatisfaccion').modal('show');
        });
</script>
@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Ocultar o mostrar el campo de texto según la opción seleccionada
        $('#razon_cita').change(function() {
            var selectedOption = $(this).val();
            if (selectedOption === 'otro') {
                $('#motivoOtroDiv').show();
            } else {
                $('#motivoOtroDiv').hide();
            }
        });

        // Cuando la página se carga, verificar el estado inicial del menú desplegable
        var initialOption = $('#razon_cita').val();
        if (initialOption === 'otro') {
            $('#motivoOtroDiv').show();
        } else {
            $('#motivoOtroDiv').hide();
        }
    });
</script>

<script>
    // Obtenemos el formulario y agregamos un event listener para validar los campos antes de enviar
    const formulario = document.querySelector('form');
    formulario.addEventListener('submit', function(event) {
        // Prevenimos el envío del formulario para poder validar los campos
        event.preventDefault();

        // Validamos los campos del formulario
        let formValid = true;
        formValid = validarNombreMascota() && formValid;
        formValid = validarRazaMascota() && formValid;
        formValid = validarNombrePropietario() && formValid;
        formValid = validarTelefonoPropietario() && formValid;
        formValid = validarEdadMacota() && formValid;
        formValid = validarSexoMacota() && formValid;
        formValid = validarFechaCita() && formValid;
        formValid = validarHoraCita() && formValid;
        formValid = validarRazonCita() && formValid;

        // Verificamos si todos los campos son válidos
        if (formValid) {
            formulario.submit();
        } else {
            // Buscamos el primer campo que tenga un error de validación y mostramos el mensaje de error correspondiente
            let invalidField = formulario.querySelector('.is-invalid');
            invalidField.focus();
            mostrarError(invalidField, invalidField.nextElementSibling.innerHTML);
        }
    });


    // Obtenemos los elementos del formulario que necesitamos validar
    const nombre_mascota = document.getElementById('nombre_mascota');
    const raza_mascota = document.getElementById('nombre_propietario');
    const nombre_propietario = document.getElementById('nombre_propietario');
    const telefono_propietario = document.getElementById('telefono_propietario');
    const edad_mascota = document.getElementById('edad_mascota');
    const sexo_mascota = document.getElementById('sexo_mascota');
    const fecha_cita = document.getElementById('fecha_cita');
    const hora_cita = document.getElementById('hora_cita');
    const razon_cita = document.getElementById('razon_cita');

    // Agregamos event listeners para los campos que queremos validar
    nombre_mascota.addEventListener('input', validarNombreMascota);
    raza_mascota.addEventListener('input', validarRazaMascota);
    nombre_propietario.addEventListener('input', validarNombrePropietario);
    telefono_propietario.addEventListener('input', validarTelefonoPropietario);
    edad_mascota.addEventListener('input', validarEdadMacota);
    sexo_mascota.addEventListener('input', validarSexoMacota);
    fecha_cita.addEventListener('input', validarFechaCita);
    hora_cita.addEventListener('input', validarHoraCita);
    razon_cita.addEventListener('input', validarRazonCita);

    // Funciones de validación para cada campo
    function validarNombreMascota() {
        if (nombre_mascota.value.trim() === '') {
            mostrarError(nombre_mascota, 'El nombre de la mascota es obligatorio.');
        } else {
            mostrarExito(nombre_mascota);
        }
    }

    function validarRazaMascota() {
        if (raza_mascota.value.trim() === '') {
            mostrarError(raza_mascota, 'La raza de la mascota es obligatoria.');
        } else {
            mostrarExito(raza_mascota);
        }
    }

    function validarNombrePropietario() {
        if (nombre_propietario.value.trim() === '') {
            mostrarError(nombre_propietario, 'El nombre del propietario es obligatorio.');
        } else {
            mostrarExito(nombre_propietario);
        }
    }

    function validarTelefonoPropietario() {
        if (telefono_propietario.value.trim() === '') {
            mostrarError(telefono_propietario, 'El telefono del propietario es obligatorio.');
        } else {
            mostrarExito(telefono_propietario);
        }
    }

    function validarEdadMacota() {
        if (edad_mascota.value.trim() === '') {
            mostrarError(edad_mascota, 'La edad de la mascota es obligatoria.');
        } else {
            mostrarExito(edad_mascota);
        }
    }

    function validarSexoMacota() {
        if (sexo_mascota.value.trim() === '') {
            mostrarError(sexo_mascota, 'El sexo de la mascota es obligatoria.');
        } else {
            mostrarExito(sexo_mascota);
        }
    }

    function validarFechaCita() {
        if (fecha_cita.value.trim() === '') {
            mostrarError(fecha_cita, 'La fecha de la cita es obligatoria.');
        } else {
            mostrarExito(fecha_cita);
        }
    }

    function validarHoraCita() {
        if (hora_cita.value.trim() === '') {
            mostrarError(hora_cita, 'La hora de la cita es obligatoria.');
        } else {
            mostrarExito(hora_cita);
        }
    }

    function validarRazonCita() {
        if (razon_cita.value.trim() === '') {
            mostrarError(razon_cita, 'La razon de la cita es obligatoria.');
        } else {
            mostrarExito(razon_cita);
        }
    }

    // Función para mostrar un mensaje de error para un campo
    function mostrarError(campo, mensaje) {
        campo.classList.add('is-invalid');
        campo.nextElementSibling.innerHTML = mensaje;
        campo.nextElementSibling.style.display = 'block';
    }

    // Función para mostrar que un campo es válido
    function mostrarExito(campo) {
        campo.classList.remove('is-invalid');
        campo.nextElementSibling.innerHTML = '';
        campo.nextElementSibling.style.display = 'none';
    }

</script>
