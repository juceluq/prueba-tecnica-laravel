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
            @csrf
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">Código</th>
                        <th class="text-center">Login</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Apellidos</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $user->id }}</td>
                            <td class="text-center">{{ $user->username }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->surname }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="#"
                                        class="edit-btn btn btn-primary d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px; margin-right: 0.5rem;"
                                        data-id="{{ $user->id }}" data-toggle="modal"
                                        data-target="#editEmployeeModal">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <button type="button" value="{{ $user->id }}" data-toggle="modal"
                                        data-target="#exampleModalCenter"
                                        class="delete-btn btn btn-danger d-flex align-items-center justify-content-center user-delete-btn"
                                        style="width: 36px; height: 36px; padding: 0 6px; margin-left: 5px;">
                                        <i class='bx bx-minus'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input id="edit_name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input id="edit_surname" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input id="edit_email" type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nueva Contraseña</label>
                            <input id="edit_password" type="password" class="form-control">
                            <small class="text-muted">Deja este campo en blanco si no deseas cambiar la
                                contraseña.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-info">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar usuario -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Eliminar usuario</h5>
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
                        <button type="submit" class="btn btn-primary">Borrar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app>
