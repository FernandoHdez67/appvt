<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\sf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Citas;
use App\Models\Horario;
use DateTime;
use DateInterval;
use Illuminate\Validation\Rule;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;




class CitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function horario(Request $request)
    {
        $servicio_id = $request->input('idservicio');
        $servicio = Servicio::find($servicio_id);

        // Obtén otros datos necesarios, como los horarios
        $horario = Horario::all();

        // Obtén la lista completa de servicios para el select
        $servicios = Servicio::all();

        return view('modulos.citas', compact('servicio', 'horario', 'servicios'));
    }

    public function citas(Request $request)
    {
        $texto = trim($request->get('texto'));
        $citas = DB::table('tbl_citas')
            ->select('id', 'nombre_mascota', 'raza_mascota', 'nombre_propietario', 'telefono_propietario', 'edad_mascota', 'sexo_mascota', 'fecha_cita', 'tbl_horarios.horario as hora_cita', 'razon_cita', 'estado_cita')
            ->leftJoin('tbl_horarios', 'tbl_citas.hora_cita', '=', 'tbl_horarios.idhorario')
            ->where('nombre_mascota', 'LIKE', '%' . $texto . '%')
            ->orWhere('raza_mascota', 'LIKE', '%' . $texto . '%')
            ->orWhere('nombre_propietario', 'LIKE', '%' . $texto . '%')
            ->orWhere('telefono_propietario', 'LIKE', '%' . $texto . '%')
            ->orWhere('edad_mascota', 'LIKE', '%' . $texto . '%')
            ->orWhere('sexo_mascota', 'LIKE', '%' . $texto . '%')
            ->orWhere('fecha_cita', 'LIKE', '%' . $texto . '%')
            ->orWhere('tbl_horarios.horario', 'LIKE', '%' . $texto . '%')
            ->orWhere('razon_cita', 'LIKE', '%' . $texto . '%')
            ->orWhere('estado_cita', 'LIKE', '%' . $texto . '%')
            ->orderBy('nombre_mascota', 'asc')
            ->paginate(30);

        return view('admin.admin_citas', compact('citas', 'texto'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $messages = [
            'nombre_mascota.required' => 'El nombre de la mascota es obligatorio',
            'nombre_mascota.string' => 'El nombre de la mascota debe ser texto',
            'raza_mascota.required' => 'La raza de la mascota es obligatoria',
            'raza_mascota.string' => 'La raza de la mascota debe ser texto',
            'nombre_propietario.required' => 'El nombre del propietario es obligatorio',
            'nombre_propietario.string' => 'El nombre del propietario debe ser texto',
            'telefono_propietario.required' => 'El teléfono del propietario es obligatorio',
            'telefono_propietario.numeric' => 'El teléfono del propietario debe ser numerico',
            'edad_mascota.required' => 'La edad de la mascota es obligatoria',
            'edad_mascota.integer' => 'La edad de la mascota debe ser un número entero',
            'edad_mascota.min' => 'La edad de la mascota no debe ser negativa',
            'sexo_mascota.required' => 'El sexo de la mascota es obligatorio',
            'fecha_cita.required' => 'La fecha de la cita es obligatoria',
            'fecha_cita.date' => 'La fecha de la cita debe ser una fecha válida',
            'razon_cita.required' => 'La razón de la cita es obligatoria',
            // Agregar el mensaje personalizado para la regla de unicidad en 'hora_cita'
            'hora_cita.unique' => 'El horario seleccionado ya está ocupado. Por favor, elige otro horario.',
            'hora_cita.required' => 'La hora de la cita es obligatoria',
        ];

        $request->validate([
            'nombre_mascota' => 'required|string|max:255',
            'raza_mascota' => 'required|string|max:255',
            'nombre_propietario' => 'required|string|max:255',
            'telefono_propietario' => 'required|numeric|digits:10',
            'edad_mascota' => 'required|integer|min:0',
            'sexo_mascota' => 'required',
            'fecha_cita' => [
                'required', 'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime(date('Y-m-d'))) {
                        $fail('No puede agendar citas con fechas anteriores.');
                    }
                },
            ],
            'hora_cita' => [
                'required',
                // Verificar unicidad del horario para la fecha seleccionada
                Rule::unique('tbl_citas')->where(function ($query) use ($request) {
                    return $query->where('fecha_cita', $request->fecha_cita)
                        ->where('hora_cita', $request->hora_cita);
                }),
            ],
            'motivo_otro' => 'nullable|string|max:255',
        ], $messages);

        // Obtén el ID del usuario autenticado
        $idusuario = session('idusuario');

        $citaData = [
            'nombre_mascota' => $request->nombre_mascota,
            'raza_mascota' => $request->raza_mascota,
            'nombre_propietario' => $request->nombre_propietario,
            'telefono_propietario' => $request->telefono_propietario,
            'edad_mascota' => $request->edad_mascota,
            'sexo_mascota' => $request->sexo_mascota,
            'fecha_cita' => $request->fecha_cita,
            'hora_cita' => $request->hora_cita,
            'razon_cita' => $request->razon_cita,
            'idusuario' => $idusuario,
        ];

        // Si razon_cita es 'otro' y motivo_otro está presente, guárdalo en la base de datos
        if ($request->razon_cita === 'otro' && $request->has('motivo_otro') && !empty($request->motivo_otro)) {
            $citaData['razon_cita'] = $request->motivo_otro;
        }

        $cita = Citas::create($citaData);

        // Después de crear la cita
        return redirect()->route('citas')->with('success', 'Su cita ha sido registrada.')->with('mostrar_encuesta', true);
    }


    public function citasUsuario()
    {
        // Obtén el ID del usuario autenticado
        $idusuario = session('idusuario');

        // Obtén las citas en espera
        $citasEnEspera = Citas::where('idusuario', $idusuario)
            ->where('estado_cita', 'En espera')
            ->get();

        // Obtén las otras citas (Canceladas, No asistió, Finalizadas)
        $otrasCitas = Citas::where('idusuario', $idusuario)
            ->whereNotIn('estado_cita', ['En espera'])
            ->get();

        // Pasa los datos a la vista
        return view('modulos.citasusuario', compact('citasEnEspera', 'otrasCitas'));
    }



    public function obtener_citas()
    {
        $citas = Citas::all();

        $eventos = [];

        foreach ($citas as $cita) {

            $evento = [
                'title' => $cita->razon_cita,
                'start' => $cita->hora_cita,
                'nombre_mascota' => $cita->nombre_mascota,
                'raza_mascota' => $cita->raza_mascota,
                'nombre_propietario' => $cita->nombre_propietario,
                'telefono_propietario' => $cita->telefono_propietario,
                'edad_mascota' => $cita->edad_mascota,
                'sexo_mascota' => $cita->sexo_mascota,
                'razon_cita' => $cita->razon_cita,
            ];

            array_push($eventos, $evento);
        }

        return response()->json($eventos);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sf  $sf
     * @return \Illuminate\Http\Response
     */
    public function show(sf $sf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sf  $sf
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cita = Citas::findOrFail($id);
        // Obtén otros datos necesarios, como los horarios
        $horario = Horario::all();
        // Obtén la lista completa de servicios para el select
        $servicios = Servicio::all();

        return view('admin.editar_cita', compact('cita', 'horario', 'servicios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sf  $sf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'nombre_mascota.required' => 'El nombre de la mascota es obligatorio',
            'nombre_mascota.string' => 'El nombre de la mascota debe ser texto',
            'raza_mascota.required' => 'La raza de la mascota es obligatoria',
            'raza_mascota.string' => 'La raza de la mascota debe ser texto',
            'nombre_propietario.required' => 'El nombre del propietario es obligatorio',
            'nombre_propietario.string' => 'El nombre del propietario debe ser texto',
            'telefono_propietario.required' => 'El teléfono del propietario es obligatorio',
            'telefono_propietario.numeric' => 'El teléfono del propietario debe ser numerico',
            'edad_mascota.required' => 'La edad de la mascota es obligatoria',
            'edad_mascota.integer' => 'La edad de la mascota debe ser un número entero',
            'edad_mascota.min' => 'La edad de la mascota no debe ser negativa',
            'sexo_mascota.required' => 'El sexo de la mascota es obligatorio',
            'fecha_cita.required' => 'La fecha de la cita es obligatoria',
            'fecha_cita.date' => 'La fecha de la cita debe ser una fecha válida',
            'razon_cita.required' => 'La razón de la cita es obligatoria',
            // Agregar el mensaje personalizado para la regla de unicidad en 'hora_cita'
            'hora_cita.unique' => 'El horario seleccionado ya está ocupado. Por favor, elige otro horario.',
            'hora_cita.required' => 'La hora de la cita es obligatoria',
        ];

        $request->validate([
            'nombre_mascota' => 'required|string|max:255',
            'raza_mascota' => 'required|string|max:255',
            'nombre_propietario' => 'required|string|max:255',
            'telefono_propietario' => 'required|numeric|digits:10',
            'edad_mascota' => 'required|integer|min:0',
            'sexo_mascota' => 'required',
            'fecha_cita' => [
                'required', 'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) < strtotime(date('Y-m-d'))) {
                        $fail('No puede agendar citas con fechas anteriores.');
                    }
                },
            ],
            'hora_cita' => [
                'required',
                Rule::unique('tbl_citas')->where(function ($query) use ($request, $id) {
                    return $query->where('fecha_cita', $request->fecha_cita)
                        ->where('hora_cita', $request->hora_cita)
                        ->where('id', '!=', $id); // Excluir la cita actual de la validación de unicidad
                }),
            ],
            'motivo_otro' => 'nullable|string|max:255',
        ], $messages);


        $citaData = [
            'nombre_mascota' => $request->nombre_mascota,
            'raza_mascota' => $request->raza_mascota,
            'nombre_propietario' => $request->nombre_propietario,
            'telefono_propietario' => $request->telefono_propietario,
            'edad_mascota' => $request->edad_mascota,
            'sexo_mascota' => $request->sexo_mascota,
            'fecha_cita' => $request->fecha_cita,
            'hora_cita' => $request->hora_cita,
            'razon_cita' => $request->razon_cita,
            'estado_cita' => $request->estado_cita,
            'idusuario' => $request->idusuario,
        ];

        // Si razon_cita es 'otro' y motivo_otro está presente, guárdalo en la base de datos
        if ($request->razon_cita === 'otro' && $request->has('motivo_otro') && !empty($request->motivo_otro)) {
            $citaData['razon_cita'] = $request->motivo_otro;
        }

        // Actualizar la cita existente con los nuevos datos
        Citas::where('id', $id)->update($citaData);

        // Después de actualizar la cita
        return redirect()->route('citass')->with('success', 'La cita ha sido actualizada.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sf  $sf
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $citas = Citas::find($id);

        if (!$citas) {
            abort(404);
        }

        // Eliminar la cita
        $citas->delete();


        return redirect()->route('citass')->with('success', 'Cita eliminada correctamente.');
    }
}
