<!-- Modal de exclusão. Os botões de excluir precisam de data-id e data-nome. -->
<div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Excluir item</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                Deseja realmente excluir este item?
            </div>
            <div class="modal-footer">
                <a id="confirm" class="btn btn-dark" href="#">
                    <i class="fa-solid fa-circle-check"></i> Sim
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i> Não
                </button>
            </div>
        </div>
    </div>
</div>