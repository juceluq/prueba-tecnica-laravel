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
                        <a href="#addEmployeeModal" class="btn btn-success d-flex align-items-center"
                            style="margin-right: 1rem" data-toggle="modal">
                            <i class='bx bx-plus-medical mr-2' style="margin-right: 10px"></i>
                            <span>Añadir</span>
                        </a>
                        <a href="#editEmployeeModal" class="btn btn-primary d-flex align-items-center"
                            style="margin-right: 1rem" data-toggle="modal">
                            <i class='bx bx-edit' style="margin-right: 10px"></i>
                            <span>Editar</span>
                        </a>
                        <a href="#deleteEmployeeModal" class="btn btn-danger d-flex align-items-center"
                            data-toggle="modal">
                            <i class='bx bx-minus' style="margin-right: 5px"></i>
                            <span>Eliminar</span>
                        </a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>

                        <th>Código</th>
                        <th>Login</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>

                            <td>{{ $user->id }}</td>
                            <td>{{ $user->login }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->email }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
    </div>
    <!-- Modales para añadir y editar usuarios -->
    <!-- Edit Modal HTML -->
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Añadir Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <textarea class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-success" value="Añadir">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div id="editEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <textarea class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                        <input type="submit" class="btn btn-info" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app>
