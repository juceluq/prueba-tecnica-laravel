<?php

namespace App\Http\Controllers;

use App\Models\DiaFestivo;
use Illuminate\Http\Request;

class DiaFestivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('diasfestivos');
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
            'dia' => 'required|integer|min:1|max:31',
            'mes' => 'required|integer|min:1|max:12',
        ]);
    
        $diaFestivo = new DiaFestivo();
        $diaFestivo->nombre = $request->input('nombre');
        $diaFestivo->color = $request->input('color');
        $diaFestivo->dia = $request->input('dia');
        $diaFestivo->mes = $request->input('mes');
        $diaFestivo->anio = $request->input('anio');
        $diaFestivo->recurrente = $request->has('recurrente');
        $diaFestivo->save();
    
        return redirect()->route('diasfestivos.index');
    }
    
    public function update(Request $request, DiaFestivo $diaFestivo)
    {
        $request->validate([
            'nombre' => 'required',
            'dia' => 'required|integer|min:1|max:31',
            'mes' => 'required|integer|min:1|max:12',
        ]);
    
        $diaFestivo->nombre = $request->input('nombre');
        $diaFestivo->color = $request->input('color');
        $diaFestivo->dia = $request->input('dia');
        $diaFestivo->mes = $request->input('mes');
        $diaFestivo->anio = $request->input('anio');
        $diaFestivo->recurrente = $request->has('recurrente');
        $diaFestivo->save();
    
        return redirect()->route('diasfestivos.index');
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
    
        return redirect()->route('diasfestivos.index');
    }
    
}
