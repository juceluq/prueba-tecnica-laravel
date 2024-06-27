<x-app>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6 d-flex align-items-center">
                        <h2 class="d-flex align-items-center">
                            <i class='bx bxs-user-detail' style="margin-right: 10px;"></i>
                            <span style="margin-left: 10px;">Listado de Usuarios</span>
                        </h2>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <a href="#modalAddUser"
                            class="btn btn-outline-success d-flex align-items-center justify-content-center"
                            style="width: 36px; height: 36px; padding: 0; margin-right: 1rem;" data-toggle="modal">
                            <i class='bx bx-plus-medical' style="font-size: 1.5rem;"></i>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Formulario de búsqueda -->
            <form id="search-form" name="search-form" action="{{ route('usuarios.search') }}" method="GET" class="mb-3">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control"
                            placeholder="Buscar por nombre, apellidos, email..."
                            value="{{ request()->input('search') }}">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                        <button id="limpiar" type="button" class="btn btn-secondary ml-2"
                            onclick="resetForm()">Limpiar</button>
                    </div>
                </div>
            </form>
            


            <form id="sort-form" action="{{ route('usuarios') }}" method="GET">
                @csrf
                <input type="hidden" id="sortby" name="sortby" value="{{ request()->input('sortby', 'id') }}">
                <input type="hidden" id="direction" name="direction"
                    value="{{ request()->input('direction', 'asc') }}">
            </form>
            <table id="tabla-usuarios" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center sortable">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => $sort == 'id' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                                Código
                                @if ($sort == 'id')
                                    <span class="sort-icon">
                                        @if ($direction == 'asc')
                                            <i class='bx bx-chevron-up'></i>
                                        @else
                                            <i class='bx bx-chevron-down'></i>
                                        @endif
                                    </span>
                                @endif
                            </a>
                        </th>
                        <th class="text-center sortable">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'username', 'direction' => $sort == 'username' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                                Login
                                @if ($sort == 'username')
                                    <span class="sort-icon">
                                        @if ($direction == 'asc')
                                            <i class='bx bx-chevron-up'></i>
                                        @else
                                            <i class='bx bx-chevron-down'></i>
                                        @endif
                                    </span>
                                @endif
                            </a>
                        </th>
                        <th class="text-center sortable">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => $sort == 'name' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                                Nombre
                                @if ($sort == 'name')
                                    <span class="sort-icon">
                                        @if ($direction == 'asc')
                                            <i class='bx bx-chevron-up'></i>
                                        @else
                                            <i class='bx bx-chevron-down'></i>
                                        @endif
                                    </span>
                                @endif
                            </a>
                        </th>
                        <th class="text-center sortable">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'surname', 'direction' => $sort == 'surname' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                                Apellidos
                                @if ($sort == 'surname')
                                    <span class="sort-icon">
                                        @if ($direction == 'asc')
                                            <i class='bx bx-chevron-up'></i>
                                        @else
                                            <i class='bx bx-chevron-down'></i>
                                        @endif
                                    </span>
                                @endif
                            </a>
                        </th>
                        <th class="text-center sortable">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => $sort == 'email' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                                Email
                                @if ($sort == 'email')
                                    <span class="sort-icon">
                                        @if ($direction == 'asc')
                                            <i class='bx bx-chevron-up'></i>
                                        @else
                                            <i class='bx bx-chevron-down'></i>
                                        @endif
                                    </span>
                                @endif
                            </a>
                        </th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="text-center codigo">{{ $user->id }}</td>
                            <td class="text-center login">{{ $user->username }}</td>
                            <td class="text-center nombre">{{ $user->name }}</td>
                            <td class="text-center apellidos">{{ $user->surname }}</td>
                            <td class="text-center email">{{ $user->email }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button
                                        class="edit-btn btn btn-primary d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px; margin-right: 0.5rem;"
                                        data-id="{{ $user->id }}" data-toggle="modal"
                                        data-target="#modalEditUser">
                                        <i class='bx bx-edit'></i>
                                    </button>

                                    <button type="button" value="{{ $user->id }}" data-toggle="modal"
                                        data-target="#modalDeleteUser"
                                        class="delete-btn btn btn-danger d-flex align-items-center justify-content-center user-delete-btn"
                                        style="width: 36px; height: 36px; padding: 0 6px; margin-left: 5px;">
                                        <i class='bx bx-minus'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay usuarios para mostrar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <!-- Modal para añadir usuario -->
    <div id="modalAddUser" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('usuario.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Añadir Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input name="name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input name="surname" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input name="password" type="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Añadir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal para editar usuario -->
    @if ($users->isNotEmpty())
        <div id="modalEditUser" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('usuario.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h4 class="modal-title">Editar Usuario</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="edit_id" name="id" value="{{ $user->id }}">
                            <div class="form-group">
                                <label>Código</label>
                                <input name="id" id="edit_codigo" type="text" class="form-control"
                                    value="{{ old($user->id) }}" readonly>
                            </div>
                            <div class="form-group">
                                <label>Login</label>
                                <input name="username" id="edit_login" type="text" class="form-control"
                                    value="{{ old($user->username) }} "required>
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input name="name" id="edit_nombre" type="text" class="form-control"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Apellidos</label>
                                <input name="surname" id="edit_apellidos" type="text" class="form-control"
                                    value="{{ old($user->surname) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input name="email" id="edit_email" type="email" class="form-control"
                                    value="{{ old($user->email) }}" required>
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input name="password" id="edit_password" type="password" class="form-control">
                                <small>Si no desea cambiarlo, dejalo en blanco.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif



    <!-- Modal para eliminar usuario -->
    <div class="modal fade" id="modalDeleteUser" tabindex="-1" role="dialog"
        aria-labelledby="modalDeleteUserTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalDeleteUserTitle">Eliminar usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres borrar el usuario?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form action="/deleteUsuario" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="user-id" name="user_id">
                        <button type="submit" class="btn btn-danger">Borrar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app>
