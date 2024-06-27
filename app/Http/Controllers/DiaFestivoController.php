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
                        ->orWhere('fecha', 'like', "%$search%");
                });
            })
            ->orderBy($sort, $direction)
            ->paginate(10);
    
        return view('diasfestivos', compact('dias', 'sort', 'direction', 'search'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'color' => 'required',
            'fecha' => 'required|date',
        ]);

        $diaFestivo = new DiaFestivo();
        $diaFestivo->nombre = $request->input('nombre');
        $diaFestivo->color = $request->input('color');
        $diaFestivo->fecha = $request->input('fecha');
        $diaFestivo->recurrente = $request->has('recurrente');
        $diaFestivo->save();

        return back();
    }

    public function update(Request $request, DiaFestivo $diaFestivo)
    {
        $request->validate([
            'nombre' => 'required',
            'color' => 'required',
            'fecha' => 'required|date',
        ]);

        $diaFestivo->nombre = $request->input('nombre');
        $diaFestivo->color = $request->input('color');
        $diaFestivo->fecha = $request->input('fecha');
        $diaFestivo->recurrente = $request->has('recurrente');
        $diaFestivo->update();

        return back();
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiaFestivo $diaFestivo)
    {
        $diaFestivo->delete();

        return back();
    }
}
