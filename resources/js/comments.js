import 'toastr/build/toastr.min.css';
import toastr from 'toastr';
document.addEventListener('DOMContentLoaded', function () {
    // Escuta o envio de formulários com a classe .comment-form dentro do container .ajax-comments
    document.querySelectorAll('.ajax-comments').forEach(container => {
        container.addEventListener('submit', function(e) {
            const form = e.target;
            if (!form.classList.contains('comment-form')) return;
            e.preventDefault();

            const taskId = container.getAttribute('data-task-id');
            const formData = new FormData(form);
            const actionUrl = form.getAttribute('action');

            axios.post(actionUrl, formData)
                .then(response => {
                    // Atualiza a lista de comentários do componente com o novo comentário
                    // Supondo que o back-end retorne JSON com 'comment' e 'user_name'
                    const newCommentHtml = `
                        <div class="comment">
                            <strong>${response.data.user_name}</strong>:
                            <span>${response.data.comment}</span>
                        </div>
                    `;
                    const commentsList = container.querySelector(`#comments-list-${taskId}`);
                    commentsList.insertAdjacentHTML('beforeend', newCommentHtml);
                    form.reset();
                    toastr.success('Comentário enviado com sucesso!', 'Sucesso');
                })
                .catch(error => {
                    console.error('Erro ao enviar comentário:', error);
                    toastr.error('Erro ao enviar comentário.', 'Erro');
                });
        });
    });
});
