import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import I18n from './vendor/I18n';
window.I18n = I18n;

const echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

Pusher.logToConsole = true;

let id = $('#user_id').val();
let translator = new I18n;

echo.private(`favorite_book.${id}`).notification((notification) => {
    let today = new Date();
    let date = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear() + ' '
        + today.getHours() + ':' + today.getMinutes();
    let currentNotiCount = $('.notification-count').text();

    var bookNotificationHtml = `
        <div class="dropdown-divider"></div>
        <a href="/favorites/?markRead=${notification.id}" class="dropdown-item">
            <i class="fas fa-book mr-2"> ` + 
                translator.trans('messages.favorite-books') + 
            `</i>
            <div>
                ${notification.book['title']}
            </div>
            <span class="float-right text-muted text-sm">` +
                translator.trans('messages.has-been-deleted') +
                ` ${date}
            </span>
        </a>
    `;
    $('.menu-notification').prepend(bookNotificationHtml);
    currentNotiCount++;
    $('.notification-count').text(currentNotiCount);
});
