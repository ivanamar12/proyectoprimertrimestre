<?php

namespace App\Http\Controllers;

use App\Models\Secretaria;
use App\Models\Direccion;
use App\Models\Genero;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Parroquia;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class SecretariaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $secretarias = DB::select('SELECT * FROM secretarias');
            return DataTables::of($secretarias)
                ->addColumn('action', function($secretaria) { 
                    $acciones = '<a href="javascript:void(0)" onclick="editsecretaria('.$secretaria->id.')" class="btn btn-success btn-raised btn-xs"><i class="zmdi zmdi-refresh"></i></a>';
                    $acciones .= '<button type="button" name="delete" id="'.$secretaria->id.'" class="delete btn btn-danger btn-raised btn-xs"><i class="zmdi zmdi-delete"></i></button>'; 
                    return $acciones;
                })
                ->rawColumns(['action'])
                ->make(true); 
        }
    
        $secretarias = Secretaria::all();
        $generos = Genero::all();
        $estados = Estado::all();
        $municipios = Municipio::all();
        $parroquias = Parroquia::all();
        return view('secretaria.index', [
            'secretarias' => $secretarias, 
            'generos' => $generos,
            'estados' => $estados, 
            'municipios' => $municipios, 
            'parroquias' => $parroquias
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|max:255',
            'fecha_nac' => 'required|date|max:10',
            'grado' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:secretarias,email',
            'genero_id' => 'required|exists:generos,id',
            'estado_id' => 'required|exists:estados,id',
            'municipio_id' => 'required|exists:municipios,id',
            'parroquia_id' => 'required|exists:parroquias,id',
            'sector' => 'required|string|max:255',
        ]);

        \DB::transaction(function () use ($validatedData) {
            $direccion = Direccion::create([
                'estado_id' => $validatedData['estado_id'],
                'municipio_id' => $validatedData['municipio_id'],
                'parroquia_id' => $validatedData['parroquia_id'],
                'sector' => $validatedData['sector'],
            ]);

            Secretaria::create([
                'nombre' => $validatedData['nombre'],
                'apellido' => $validatedData['apellido'],
                'ci' => $validatedData['ci'],
                'fecha_nac' => $validatedData['fecha_nac'],
                'grado' => $validatedData['grado'],
                'telefono' => $validatedData['telefono'],
                'email' => $validatedData['email'],
                'genero_id' => $validatedData['genero_id'],
                'direccion_id' => $direccion->id,
            ]);
        });

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $secretaria = Secretaria::with('direccion')->find($id); 
        if (!$secretaria) {
            return response()->json(['message' => 'secretaria no encontrado'], 404);
        }
    
        $direccion = $secretaria->direccion; 
        if (!$direccion) {
            return response()->json(['message' => 'Dirección no encontrada'], 404);
        }
    
        \DB::transaction(function () use ($secretaria, $direccion) {
            $secretaria->delete();
            $direccion->delete();
        });
    
        return response()->json(['success' => true]);
    }


    public function show($id)
    {
        //
    }

    public function edit($id) {
        try {
            $secretaria = Secretaria::with('direccion')->find($id);
            if (!$secretaria) {
                return response()->json(['error' => 'Secretaria no encontrado'], 404);
            }
            return response()->json($secretaria);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ci' => 'required|string|max:255',
            'fecha_nac' => 'required|date|max:10',
            'grado' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:especialistas,email,' . $id,
            'genero_id' => 'required|exists:generos,id',
            'estado_id' => 'required|exists:estados,id',
            'municipio_id' => 'required|exists:municipios,id',
            'parroquia_id' => 'required|exists:parroquias,id',
            'sector' => 'required|string|max:255',
        ]);
        
    
        $secretaria = Secretaria::with('direccion')->find($id); 
        if (!$secretaria) {
            return response()->json(['message' => 'Especialista no encontrado'], 404);
        }
    
        \DB::transaction(function () use ($validatedData, $secretaria) {
            $direccion = $secretaria->direccion; 
            if (!$direccion) {
                throw new \Exception('Dirección no encontrada'); 
            }
    
            $direccion->update([
                'estado_id' => $validatedData['estado_id'],
                'municipio_id' => $validatedData['municipio_id'],
                'parroquia_id' => $validatedData['parroquia_id'],
                'sector' => $validatedData['sector'],
            ]);
    
            $secretaria->update([
                'nombre' => $validatedData['nombre'],
                'apellido' => $validatedData['apellido'],
                'ci' => $validatedData['ci'],
                'fecha_nac' => $validatedData['fecha_nac'],
                'grado' => $validatedData['grado'],
                'telefono' => $validatedData['telefono'],
                'email' => $validatedData['email'],
                'genero_id' => $validatedData['genero_id'],
            ]);
        });
    
        return response()->json(['success' => true]);
    }
}
