/**
 * Modal de exclusão (usado por filmes e usuários).
 * O botão precisa ter data-id e data-nome.
 */
$('#delete-modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var nome = button.data('nome') || '';
    var modal = $(this);

    modal.find('.modal-title').text('Excluir #' + id);
    modal.find('.modal-body').text('Deseja realmente excluir ' + nome + '?');
    modal.find('#confirm').attr('href', 'delete.php?id=' + encodeURIComponent(id));
});