<x-app>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6 d-flex align-items-center">
                        <h2 class="d-flex align-items-center">
                            <i class='bx bx-calendar-week' style="margin-right: 10px;"></i>
                            <span style="margin-left: 10px;">Listado de Días festivos</span>
                        </h2>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <a href="#modalAdddia"
                            class="btn btn-outline-success d-flex align-items-center justify-content-center"
                            style="width: 36px; height: 36px; padding: 0; margin-right: 1rem;" data-toggle="modal">
                            <i class='bx bx-plus-medical' style="font-size: 1.5rem;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Formulario de búsqueda -->
            <form id="search-form" name="search-form" action="{{ route('dias.search') }}" method="GET" class="mb-3">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Buscar días"
                            value="{{ request()->input('search') }}">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                        <a id="limpiar" type="button" class="btn btn-secondary ml-2"
                            href="{{ route('diasfestivos') }}">Limpiar</a>
                    </div>
                </div>
            </form>

            <form id="sort-form" action="{{ route('diasfestivos') }}" method="GET">
                @csrf
                <input type="hidden" id="sortby" name="sortby" value="{{ request()->input('sortby', 'id') }}">
                <input type="hidden" id="direction" name="direction"
                    value="{{ request()->input('direction', 'asc') }}">
            </form>
            <table id="tabla-dias" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center sortable">
                            <a
                                href="{{ request()->fullUrlWithQuery(['sort' => 'id', 'direction' => $sort == 'id' && $direction == 'asc' ? 'desc' : 'asc']) }}">
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
                            <a
                                href="{{ request()->fullUrlWithQuery(['sort' => 'nombre', 'direction' => $sort == 'nombre' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                                Nombre
                                @if ($sort == 'nombre')
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
                            <a
                                href="{{ request()->fullUrlWithQuery(['sort' => 'color', 'direction' => $sort == 'color' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                                Color
                                @if ($sort == 'color')
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
                            <a
                                href="{{ request()->fullUrlWithQuery(['sort' => 'anio', 'direction' => $sort == 'anio' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                                Fecha
                                @if ($sort == 'anio')
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
                            <a
                                href="{{ request()->fullUrlWithQuery(['sort' => 'recurrente', 'direction' => $sort == 'recurrente' && $direction == 'asc' ? 'desc' : 'asc']) }}">
                                Recurrente
                                @if ($sort == 'recurrente')
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
                    @forelse ($dias as $dia)
                        <tr>
                            <td class="text-center codigo">{{ $dia->id }}</td>
                            <td class="text-center nombre">{{ $dia->nombre }}</td>
                            <td class="text-center color d-flex justify-content-center"><input type="color"
                                    value="{{ $dia->color }}" disabled class="form-control form-control-color"></td>
                            <td class="text-center fecha">
                                @if (!$dia->recurrente)
                                    {{ $dia->dia }}/{{ $dia->mes }}/{{ $dia->anio }}
                                @else
                                    {{ $dia->dia }}/{{ $dia->mes }}
                                @endif
                            </td>
                            <td class="text-center recurrente">
                                @if ($dia->recurrente)
                                    <i class='bx bx-check' style="font-size: 1.75rem;"></i>
                                @else
                                    <i class='bx bx-x' style="font-size: 1.75rem;"></i>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button
                                        class="edit-btn btn btn-primary d-flex align-items-center justify-content-center"
                                        style="width: 36px; height: 36px; margin-right: 0.5rem;"
                                        data-id="{{ $dia->id }}" data-toggle="modal" data-target="#modalEditdia">
                                        <i class='bx bx-edit'></i>
                                    </button>

                                    <button type="button" value="{{ $dia->id }}" data-toggle="modal"
                                        data-target="#modalDeletedia"
                                        class="delete-btn btn btn-danger d-flex align-items-center justify-content-center dia-delete-btn"
                                        style="width: 36px; height: 36px; padding: 0 6px; margin-left: 5px;">
                                        <i class='bx bx-minus'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay días festivos para mostrar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $dias->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <!-- Modal para añadir días -->
    <div id="modalAdddia" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('diasfestivos.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Añadir día festivo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input name="nombre" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <input name="color" type="color" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Día</label>
                            <input name="dia" type="number" class="form-control" required min="1"
                                max="31">
                        </div>
                        <div class="form-group">
                            <label>Mes</label>
                            <input name="mes" type="number" class="form-control" required min="1"
                                max="12">
                        </div>
                        <div class="form-group" id="anioGroup">
                            <label>Año</label>
                            <input name="anio" id="anio" type="number" class="form-control" required min="1900"
                                max="2100">
                        </div>
                        <div class="form-check">
                            <input name="recurrente" id="recurrente" type="checkbox" class="form-check-input">
                            <label class="form-check-label" for="recurrente">Recurrente</label>
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

    <!-- Modal para editar día festivo -->
    @if ($dias->isNotEmpty())
        <div id="modalEditdia" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('diasfestivos.update', $dia->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h4 class="modal-title">Editar día festivo</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Código</label>
                                <input name="edit_id" id="edit_id" type="text" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input name="edit_nombre" id="edit_nombre" type="text" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Color</label>
                                <input name="edit_color" id="edit_color" type="color" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Día</label>
                                <input name="edit_dia" id="edit_dia" type="number" class="form-control" required
                                    min="1" max="31">
                            </div>
                            <div class="form-group">
                                <label>Mes</label>
                                <input name="edit_mes" id="edit_mes" type="number" class="form-control" required
                                    min="1" max="12">
                            </div>
                            <div class="form-group" id="edit_anioGroup">
                                <label>Año</label>
                                <input name="edit_anio" id="edit_anio" type="number" class="form-control" required
                                    min="1900" max="2100">
                            </div>
                            <div class="form-check">
                                <input name="edit_recurrente" id="edit_recurrente" type="checkbox"
                                    class="form-check-input">
                                <label class="form-check-label" for="edit_recurrente">Recurrente</label>
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

    <!-- Modal para eliminar día festivo -->
    <div class="modal fade" id="modalDeletedia" tabindex="-1" role="dialog" aria-labelledby="modalDeletediaTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalDeletediaTitle">Eliminar día festivo
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar el día festivo?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('diasfestivos.destroy') }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="dia_delete_id" name="dia_delete_id">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/dias.js')
</x-app>
