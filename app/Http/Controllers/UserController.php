<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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





    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->all());
        return redirect()->route('users.index');
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
