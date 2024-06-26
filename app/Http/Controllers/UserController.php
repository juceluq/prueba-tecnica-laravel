<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return view('usuarios', ['users' => $users]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->surname = $validatedData['surname'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);

        if ($user->save()) {
            return redirect()->route('usuarios')->with('alert', [
                'type' => 'success',
                'message' => 'Usuario creado correctamente.'
            ]);
        } else {
            return redirect()->route('usuarios')->with('alert', [
                'type' => 'error',
                'message' => 'Error al crear el usuario. Por favor, inténtalo de nuevo.'
            ]);
        }
    }
    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
        ]);
        Log::info('Inicio del método update');

        // Log para registrar los datos recibidos del formulario
        Log::info('Datos recibidos del formulario:', $request->all());
    
        // Actualiza los campos del usuario con los datos del formulario
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->username = $request->username;
        $user->email = $request->email;
    
        // Actualiza la contraseña si se proporcionó una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        // Intenta guardar los cambios en el usuario
        if ($user->save()) {
            // Log para registro de éxito al modificar el usuario
            Log::info('Usuario modificado correctamente. ID: '.$user->id);
    
            return redirect()->route('usuarios')->with('alert', [
                'type' => 'success',
                'message' => 'Usuario modificado correctamente.'
            ]);
        } else {
            // Log para registro de error al modificar el usuario
            Log::error('Error al modificar el usuario. ID: '.$user->id);
    
            return redirect()->route('usuarios')->with('alert', [
                'type' => 'error',
                'message' => 'Error al modificar el usuario. Por favor, inténtalo de nuevo.'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        User::where("id", $request->user_id)->get()[0]->delete();
        return back()->with('alert', [
            'type' => 'success',
            'message' => 'Usuario eliminado correctamente.'
        ]);
    }
}
