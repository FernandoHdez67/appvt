@extends('adminlte::page')

@section('title', 'Editar Cita')

@section('content_header')
<h1>Editar Cita</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title"></h5>
    </div>
    <div class="card-body">
        <div class="container">
            <div>
                <form method="POST" action="{{ route('update.cita', ['id' => $cita->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nombre_mascota">Nombre de la mascota:</label>
                        <input type="text" class="form-control @error('nombre_mascota') is-invalid @enderror"
                            id="nombre_mascota" name="nombre_mascota" value="{{ $cita->nombre_mascota }}">
                        <div class="invalid-feedback" id="nombre-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="raza_mascota">Raza de la mascota:</label>
                        <input type="text" class="form-control @error('raza_mascota') is-invalid @enderror"
                            id="raza_mascota" name="raza_mascota" value="{{ $cita->raza_mascota }}">
                        <div class="invalid-feedback" id="raza-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="nombre_propietario">Nombre del propietario:</label>
                        <input type="text" class="form-control @error('nombre_propietario') is-invalid @enderror"
                            id="nombre_propietario" name="nombre_propietario" value="{{ $cita->nombre_propietario }}">
                        <div class="invalid-feedback" id="nombre_propietario-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="telefono_propietario">Teléfono del propietario:</label>
                        <input type="text" class="form-control @error('telefono_propietario') is-invalid @enderror"
                            id="telefono_propietario" name="telefono_propietario"
                            value="{{ $cita->telefono_propietario }}">
                        <div class="invalid-feedback" id="telefono_propietario-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="edad_mascota">Edad de la mascota:</label>
                        <input type="text" class="form-control @error('edad_mascota') is-invalid @enderror"
                            id="edad_mascota" name="edad_mascota" value="{{ $cita->edad_mascota }}">
                        <div class="invalid-feedback" id="edad_mascota-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="sexo_mascota">Sexo de la mascota:</label>
                        <select class="form-control @error('sexo_mascota') is-invalid @enderror" id="sexo_mascota"
                            name="sexo_mascota">
                            <option value="">[Seleccionar]</option>
                            <option value="Macho" {{ $cita->sexo_mascota == 'Macho' ? 'selected' : '' }}>Macho</option>
                            <option value="Hembra" {{ $cita->sexo_mascota == 'Hembra' ? 'selected' : '' }}>Hembra
                            </option>
                        </select>
                        <div class="invalid-feedback" id="sexo_mascota-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="fecha_cita">Fecha de la cita:</label>
                        <input type="date" class="form-control @error('fecha_cita') is-invalid @enderror"
                            id="fecha_cita" name="fecha_cita" value="{{ $cita->fecha_cita }}">
                        <div class="invalid-feedback" id="fecha_cita-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="hora_cita">Hora de la cita:</label>
                        <select class="form-control @error('hora_cita') is-invalid @enderror" id="hora_cita"
                            name="hora_cita">
                            <option value="">[Seleccionar Hora]</option>
                            @foreach($horario as $horario_item)
                            <option value="{{ $horario_item->idhorario }}" {{ $cita->hora_cita ==
                                $horario_item->idhorario ? 'selected' : '' }}>{{ $horario_item->horario }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="hora_cita-error"></div>
                    </div>

                    <div class="form-group">
                        <label for="razon_cita">Tipo de Servicio:</label>
                        <input type="text" class="form-control @error('razon_cita') is-invalid @enderror"
                            id="razon_cita" name="razon_cita" value="{{ $cita->razon_cita }}">
                        <div class="invalid-feedback" id="razon_cita-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="estado_cita">Estado de la cita:</label>
                        <select class="form-control @error('estado_cita') is-invalid @enderror" id="estado_cita"
                            name="estado_cita">
                            <option value="">[Seleccionar]</option>
                            <option value="En espera" {{ $cita->estado_cita == 'En espera' ? 'selected' : '' }}>En
                                espera</option>
                            <option value="Cancelada" {{ $cita->estado_cita == 'Cancelada' ? 'selected' : ''
                                }}>Cancelada</option>
                            <option value="No asistió" {{ $cita->estado_cita == 'No asistió' ? 'selected' : '' }}>No
                                asistió</option>
                            <option value="Finalizada" {{ $cita->estado_cita == 'Finalizada' ? 'selected' : ''
                                }}>Finalizada</option>
                        </select>
                        <div class="invalid-feedback" id="razon_cita-error"></div>
                    </div>
                    <!-- Campo oculto para enviar el método PUT correctamente -->
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="idusuario" value="{{ $cita->idusuario }}">
                    <!-- Botón para enviar el formulario de actualización -->
                    <button type="submit" class="btn btn-primary">Actualizar cita</button>
                    <a href="{{ route('citass') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    @stop

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
