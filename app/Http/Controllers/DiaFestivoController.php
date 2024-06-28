<?php

namespace App\Http\Controllers;

use App\Models\DiaFestivo;
use Dotenv\Exception\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DiaFestivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $diasQuery = DiaFestivo::query();

        if ($sort === 'anio') {
            $dias = $diasQuery->orderByRaw('CASE WHEN anio IS NULL THEN mes ELSE anio END ' . $direction)
                ->orderBy($sort, $direction)
                ->paginate(10);
        } else {
            $dias = $diasQuery->orderBy($sort, $direction)
                ->paginate(10);
        }

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
                        ->orWhereRaw("CONCAT(dia, '/', mes, '/', anio) LIKE ?", ["%$search%"]);
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
        if ($diaFestivo->recurrente) {
            $diaFestivo->anio = null;
        }
        $diaFestivo->save();

        return back()->with('alert', [
            'type' => 'success',
            'message' => 'Día festivo creado con éxito.'
        ]);
    }

    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'edit_nombre' => 'required',
                'edit_color' => 'required',
                'edit_dia' => 'required|integer|min:1|max:31',
                'edit_mes' => 'required|integer|min:1|max:12',
                'edit_anio' => 'nullable|integer|min:1900|max:2100',
            ]);

            $id = $request->input('edit_id');

            $diaFestivo = DiaFestivo::find($id);

            if (!$diaFestivo) {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'Día festivo no encontrado.'
                ]);
            }

            $diaFestivo->nombre = $validatedData['edit_nombre'];
            $diaFestivo->color = $validatedData['edit_color'];
            $diaFestivo->dia = $validatedData['edit_dia'];
            $diaFestivo->mes = $validatedData['edit_mes'];
            $diaFestivo->anio = $validatedData['edit_anio'];
            $diaFestivo->recurrente = $request->edit_recurrente;

            if ($request->edit_recurrente) {
                $diaFestivo->anio = null;
            }
            // Verificar si hubo cambios en el modelo
            if ($diaFestivo->isClean()) {
                return back()->with('alert', [
                    'type' => 'warning',
                    'message' => 'No se realizaron cambios.'
                ]);
            }

            // Actualizar el modelo DiaFestivo en la base de datos
            $diaFestivo->save();

            return back()->with('alert', [
                'type' => 'success',
                'message' => 'Día festivo editado con éxito.'
            ]);
        } catch (QueryException $e) {
            return back()->with('alert', [
                'type' => 'danger',
                'message' => 'Error al modificar el día festivo. Por favor, inténtalo de nuevo.'
            ]);
        }
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
