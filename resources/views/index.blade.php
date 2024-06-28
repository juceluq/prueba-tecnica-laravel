<x-app>
    <div id="calendar"></div>


    <!-- Modal para añadir días -->
    <div id="modalAddDia" class="modal fade">
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
                            <input name="dia" type="number" class="form-control dia-input" required readonly>
                        </div>
                        <div class="form-group">
                            <label>Mes</label>
                            <input name="mes" type="number" class="form-control mes-input" required readonly>
                        </div>
                        <div class="form-group" id="anioGroup">
                            <label>Año</label>
                            <input name="anio" id="anio" type="number" class="form-control" required readonly>
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
    <div id="event-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('diasfestivos.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_id" id="edit_id">
                    <input type="hidden" name="edit_dia" id="edit_dia">
                    <input type="hidden" name="edit_mes" id="edit_mes">
                    <input type="hidden" name="edit_anio" id="edit_anio">
                    <input type="hidden" name="edit_recurrente" id="edit_recurrente">

                    <div class="modal-header">
                        <h4 class="modal-title">Editar registro</h4>
                        <button type="button" class="close" data-dismiss="event-modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input name="edit_nombre" id="edit_nombre" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Color</label>
                            <input name="edit_color" id="edit_color" type="color" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="event-modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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


    @vite('resources/js/calendar.js')
</x-app>
