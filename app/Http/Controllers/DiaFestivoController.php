<?php

namespace App\Http\Controllers;

use App\Models\DiaFestivo;
use Illuminate\Http\Request;

class DiaFestivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $diasQuery = DiaFestivo::query();

        // Ordenamiento por defecto
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        // Aplicar ordenamiento
        $dias = $diasQuery->orderBy($sort, $direction)->paginate(10);

        return view('diasfestivos', compact('dias', 'sort', 'direction'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'id'); 
        $direction = $request->input('direction', 'asc'); 
    
        $dias = DiaFestivo::query()
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                    ->orWhere('color', 'like', "%$search%")
                    ->orWhereRaw("CONCAT(dia, '-', mes, '-', anio) LIKE ?", ["%$search%"]);
            });
        })
        ->orderBy($sort, $direction)
        ->paginate(10);

    return view('diasfestivos', compact('dias', 'sort', 'direction', 'search'));
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'color' => 'required',
            'dia' => 'required|integer|min:1|max:31',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'nullable|integer|min:1900|max:2100',
        ]);

        $diaFestivo = new DiaFestivo();
        $diaFestivo->nombre = $request->input('nombre');
        $diaFestivo->color = $request->input('color');
        $diaFestivo->dia = $request->input('dia');
        $diaFestivo->mes = $request->input('mes');
        $diaFestivo->anio = $request->input('anio');
        $diaFestivo->recurrente = $request->has('recurrente');
        if($diaFestivo->recurrente){
            $diaFestivo->anio = null;
        }
        $diaFestivo->save();

        return back()->with('alert', [
            'type' => 'success',
            'message' => 'Día festivo creado con éxito.'
        ]);
    }

    public function update(Request $request, DiaFestivo $diaFestivo)
    {
        $request->validate([
            'nombre' => 'required',
            'color' => 'required',
            'dia' => 'required|integer|min:1|max:31',
            'mes' => 'required|integer|min:1|max:12',
            'anio' => 'nullable|integer|min:1900|max:2100',
        ]);

        $diaFestivo->nombre = $request->input('nombre');
        $diaFestivo->color = $request->input('color');
        $diaFestivo->dia = $request->input('dia');
        $diaFestivo->mes = $request->input('mes');
        $diaFestivo->anio = $request->input('anio');
        $diaFestivo->recurrente = $request->has('recurrente');
        $diaFestivo->update();

        return back()->with('alert', [
            'type' => 'success',
            'message' => 'Día festivo editado con éxito.'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DiaFestivo::where("id", $request->dia_delete_id)->first()->delete();
        return back()->with('alert', [
            'type' => 'success',
            'message' => 'Día eliminado correctamente.'
        ]);
    }
}
