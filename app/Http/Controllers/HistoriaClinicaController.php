<?php

namespace App\Http\Controllers;

use App\Models\AntecedenteMedico;
use App\Models\HistoriaClinica;
use App\Models\HistoriaDesarrollo;
use App\Models\HistoriaEscolar;
use App\Models\Parentesco;
use App\Models\Paciente;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use PDF; 

class HistoriaClinicaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $historias = DB::select('SELECT pacientes.nombre as nombre, 
                pacientes.apellido as apellido, 
                historia_clinicas.* FROM historia_clinicas 
                JOIN pacientes ON historia_clinicas.paciente_id = pacientes.id');
    
            return DataTables::of($historias)
                ->addColumn('action', function($historia) { 
                    $acciones = '<a href="javascript:void(0)" onclick="editsecretaria('.$historia->id.')" class="btn btn-success btn-raised btn-xs"><i class="zmdi zmdi-refresh"></i></a>';
                    $acciones .= '<button type="button" name="delete" id="'.$historia->id.'" class="delete btn btn-danger btn-raised btn-xs"><i class="zmdi zmdi-delete"></i></button>';
                    $acciones .= '<button type="button" class="btn btn-info btn-raised btn-xs ver-secretaria" data-id="'.$historia->id.'"><i class="zmdi zmdi-eye"></i></button>'; 
                    return $acciones;
                })
                ->rawColumns(['action'])
                ->make(true); 
        }
    
        $antecedentesMedicos = AntecedenteMedico::all();
        $historiaClinicas = HistoriaClinica::all();
        $historiaDesarrollos = HistoriaDesarrollo::all();
        $historiaEscolares = HistoriaEscolar::all();
        $parentescos = Parentesco::all();
        $pacientes = Paciente::all();
        return view('historias.index', [
            'antecedentesMedicos' => $antecedentesMedicos, 
            'historiaClinicas' => $historiaClinicas,
            'historiaDesarrollos' => $historiaDesarrollos, 
            'historiaEscolares' => $historiaEscolares, 
            'parentescos' => $parentescos,
            'pacientes' => $pacientes
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'medicamento_embarazo' => 'required|string', 
            'tipo_medicamento' => 'required|string|max:800', 
            'fumo_embarazo' => 'required|string', 
            'cantidad' => 'required|string', 
            'alcohol_embarazo' => 'required|string', 
            'tipo_alcohol' => 'required|string', 
            'cantidad_consumia_alcohol' => 'required|string', 
            'droga_embarazo' => 'required|string', 
            'tipo_droga' => 'required|string', 
            'forceps_parto' => 'required|string', 
            'cesarea' => 'required|string', 
            'razon_cesarea' => 'required|string|max:900', 
            'niño_prematuro' => 'required|string', 
            'meses_prematuro' => 'required|string', 
            'peso_nacer_niño' => 'required|string', 
            'complicaciones_nacer' => 'required|string', 
            'tipo_complicacion' => 'required|string|max:900', 
            'problema_alimentacion' => 'required|string', 
            'tipo_problema_alimenticio' => 'required|string|max:900', 
            'problema_dormir' => 'required|string', 
            'tipo_problema_dormir' => 'required|string|max:900', 
            'tranquilo_recien_nacido' => 'required|string', 
            'gustaba_cargaran_recien_nacido' => 'required|string', 
            'alerta_recien_nacido' => 'required|string', 
            'problemas_desarrollo_primeros_años' => 'required|string', 
            'cuales_problemas' => 'required|string|max:1000',
            'enfermedad_infecciosa' => 'required|string',
            'tipo_enfermedad_infecciosa' => 'required|string',
            'enfermedad_no_infecciosa' => 'required|string', 
            'tipo_enfermedad_no_infecciosa' => 'required|string', 
            'enfermedad_cronica' => 'required|string', 
            'tipo_enfermedad_cronica' => 'required|string',
            'discapacidad' => 'required|string', 
            'tipo_discapacidad' => 'required|string', 
            'otros' => 'required|string', 
            'escolarizado' => 'required|string', 
            'tipo_educaion' => 'required|string', 
            'tutoria_terapias' => 'required|string',
            'tutoria_terapias_cuales' => 'required|string',  
            'dificultad_lectura' => 'required|string',   
            'dificultad_aritmetica' => 'required|string',  
            'dificultad_escribir' => 'required|string',  
            'agrada_escuela' => 'required|string',  
            'paciente_id' => 'required|exists:pacientes,id',
            'codigo' => 'required|string', 
            'referencia' => 'required|string', 
            'especialista_refirio' => 'required|string', 
            'motivo' => 'required|string', 
        ]);

        DB::transaction(function () use ($validatedData) {
            $historiaDesarrollo = HistoriaDesarrollo::create([
                'medicamento_embarazo' => $validatedData['medicamento_embarazo'],
                'tipo_medicamento' => $validatedData['tipo_medicamento'],
                'fumo_embarazo' => $validatedData['fumo_embarazo'],
                'cantidad' => $validatedData['cantidad'],
                'alcohol_embarazo' => $validatedData['alcohol_embarazo'],
                'tipo_alcohol' => $validatedData['tipo_alcohol'],
                'cantidad_consumia_alcohol' => $validatedData['cantidad_consumia_alcohol'],
                'droga_embarazo' => $validatedData['droga_embarazo'],
                'tipo_droga' => $validatedData['tipo_droga'],
                'forceps_parto' => $validatedData['forceps_parto'],
                'cesarea' => $validatedData['cesarea'],
                'razon_cesarea' => $validatedData['razon_cesarea'],
                'niño_prematuro' => $validatedData['niño_prematuro'],
                'meses_prematuro' => $validatedData['meses_prematuro'],
                'peso_nacer_niño' => $validatedData['peso_nacer_niño'],
                'complicaciones_nacer' => $validatedData['complicaciones_nacer'],
                'tipo_complicacion' => $validatedData['tipo_complicacion'],
                'problema_alimentacion' => $validatedData['problema_alimentacion'],
                'tipo_problema_alimenticio' => $validatedData['tipo_problema_alimenticio'],
                'problema_dormir' => $validatedData['problema_dormir'],
                'tipo_problema_dormir' => $validatedData['tipo_problema_dormir'],
                'tranquilo_recien_nacido' => $validatedData['tranquilo_recien_nacido'],
                'gustaba_cargaran_recien_nacido' => $validatedData['gustaba_cargaran_recien_nacido'],
                'alerta_recien_nacido' => $validatedData['alerta_recien_nacido'],
                'problemas_desarrollo_primeros_años' => $validatedData['problemas_desarrollo_primeros_años'],
                'cuales_problemas' => $validatedData['cuales_problemas'],
            ]);

            $antecedenteMedico = AntecedenteMedico::create([
                'enfermedad_infecciosa' => $validatedData['enfermedad_infecciosa'],
                'tipo_enfermedad_infecciosa' => $validatedData['tipo_enfermedad_infecciosa'],
                'enfermedad_no_infecciosa' => $validatedData['enfermedad_no_infecciosa'],
                'tipo_enfermedad_no_infecciosa' => $validatedData['tipo_enfermedad_no_infecciosa'],
                'enfermedad_cronica' => $validatedData['enfermedad_cronica'],
                'tipo_enfermedad_cronica' => $validatedData['tipo_enfermedad_cronica'],
                'discapacidad' => $validatedData['discapacidad'],
                'tipo_discapacidad' => $validatedData['tipo_discapacidad'],
                'otros' => $validatedData['otros'],
            ]);

            $historiaEscolar = HistoriaEscolar::create([
                'escolarizado' => $validatedData['escolarizado'],
                'tipo_educaion' => $validatedData['tipo_educaion'],
                'tutoria_terapias' => $validatedData['tutoria_terapias'],
                'tutoria_terapias_cuales' => $validatedData['tutoria_terapias_cuales'],
                'dificultad_lectura' => $validatedData['dificultad_lectura'],
                'dificultad_aritmetica' => $validatedData['dificultad_aritmetica'],
                'dificultad_escribir' => $validatedData['dificultad_escribir'],
                'agrada_escuela' => $validatedData['agrada_escuela'],
            ]);

            HistoriaClinica::create([
                'paciente_id' => $validatedData['paciente_id'],
                'historia_desarrollo_id' => $historiaDesarrollo->id,
                'antecedente_medico_id' => $antecedenteMedico->id,
                'historia_escolar_id' => $historiaEscolar->id,
                'codigo' => $validatedData['codigo'],
                'referencia' => $validatedData['referencia'],
                'especialista_refirio' => $validatedData['especialista_refirio'],
                'motivo' => $validatedData['motivo'],
            ]);
        });

        return response()->json(['message' => 'Registro creado exitosamente.'], 201);
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
