import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import 'toastr/build/toastr.min.css';
import toastr from 'toastr';
import './bootstrap';
import './comments'; // importa nosso script de comentários


window.Pusher = Pusher;

const pusherKey = import.meta.env.VITE_PUSHER_APP_KEY;
const pusherCluster = import.meta.env.VITE_PUSHER_APP_CLUSTER;

if (!pusherKey || !pusherCluster) {
    console.warn('Pusher key ou cluster não estão definidos nas variáveis de ambiente.');
}

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: pusherKey,
    cluster: pusherCluster,
    forceTLS: false, // Para ambiente local, se necessário
    disableStats: true,
});

// Verifica se a meta tag "user-id" existe no <head>
const userMeta = document.head.querySelector('meta[name="user-id"]');
if (userMeta && userMeta.content) {
    const userId = userMeta.content;
    window.Echo.private(`App.Models.User.${userId}`)
        .notification((notification) => {
            console.log('Nova notificação:', notification);
            // Exibe o toast com a mensagem da notificação
            const msg = notification.message || 'Você recebeu uma notificação';
            toastr.info(msg, 'Notificação');
        });
} else {
    console.warn('Meta tag user-id não encontrada ou vazia.');
}

// Teste Toastr diretamente (opcional, remova depois)

