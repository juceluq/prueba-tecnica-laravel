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
                        <a href="#addEmployeeModal"
                            class="btn btn-outline-success d-flex align-items-center justify-content-center"
                            style="width: 36px; height: 36px; padding: 0; margin-right: 1rem;" data-toggle="modal">
                            <i class='bx bx-plus-medical' style="font-size: 1.5rem;"></i>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Formulario de búsqueda -->
            <form id="search-form" name="search-form" action="{{ route('usuarios.search') }}" method="POST"
                class="mb-3">
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
                        <th class="text-center">@sortablelink('id', 'Código')</th>
                        <th class="text-center">@sortablelink('username', 'Login')</th>
                        <th class="text-center">@sortablelink('name', 'Nombre')</th>
                        <th class="text-center">@sortablelink('surname', 'Apellidos')</th>
                        <th class="text-center">@sortablelink('email', 'Email')</th>
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
                                        data-target="#editEmployeeModal">
                                        <i class='bx bx-edit'></i>
                                    </button>

                                    <button type="button" value="{{ $user->id }}" data-toggle="modal"
                                        data-target="#exampleModalCenter"
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
            {{ $users->appends(request()->except('page'))->links('pagination::bootstrap-4') }}

            {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <!-- Modal para añadir usuario -->
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('usuario.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Añadir Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
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
        <div id="editEmployeeModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('usuario.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h4 class="modal-title">Editar Usuario</h4>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">&times;</button>
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalCenterTitle">Eliminar usuario</h4>
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
