<x-app>
    <div id="calendar"></div>

    <div id="event-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('diasfestivos.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar registro</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="context-menu"></div>

    @vite('resources/js/calendar.js')
</x-app>
