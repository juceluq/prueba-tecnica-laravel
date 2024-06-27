<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Kyslik\ColumnSortable\Sortable;


class UserController extends Controller
{
    use Sortable;

    public function index()
    {
        $users = User::sortable()->paginate(10);

        return view('usuarios', compact('users'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('surname', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            })
            ->paginate(10);

        return view('usuarios', compact('users'));
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
            return back()->with('alert', [
                'type' => 'success',
                'message' => 'Usuario creado correctamente.'
            ]);
        } else {
            return back()->with('alert', [
                'type' => 'error',
                'message' => 'Error al crear el usuario. Por favor, inténtalo de nuevo.'
            ]);
        }
    }
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
                'password' => 'nullable|string|min:8',
            ]);

            // Obtener el usuario actual
            $user = User::find($request->id);

            if (!$user) {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'Usuario no encontrado.'
                ]);
            }

            $userData = [
                'username' => $validatedData['username'],
                'name' => $validatedData['name'],
                'surname' => $validatedData['surname'],
                'email' => $validatedData['email'],
            ];

            if (!empty($validatedData['password'])) {
                $userData['password'] = Hash::make($validatedData['password']);
            }

            if ($userData == $user->only(['username', 'name', 'surname', 'email'])) {
                return back()->with('alert', [
                    'type' => 'warning',
                    'message' => 'No se realizaron cambios.'
                ]);
            }



            $update = DB::table('users')
                ->where('id', $request->id)
                ->update($userData);

            if ($update) {
                return back()->with('alert', [
                    'type' => 'success',
                    'message' => 'Usuario modificado correctamente.'
                ]);
            } else {
                return back()->with('alert', [
                    'type' => 'danger',
                    'message' => 'Error al modificar el usuario. Por favor, inténtalo de nuevo.'
                ]);
            }
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (QueryException $e) {
            return back()->with('alert', [
                'type' => 'danger',
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
