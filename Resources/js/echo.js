import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

console.log('5');
console.log(process.env.MIX_PUSHER_APP_KEY);

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_PUSHER_HOST,
    wsPort: process.env.MIX_PUSHER_PORT,
    wssPort: process.env.MIX_PUSHER_PORT,
   // forceTLS: false,
   // encrypted: true,
   // enableLogging: true,
    disableStats: true,
   // enabledTransports: ['ws', 'wss'],
});
