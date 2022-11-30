//import Echo from 'laravel-echo';

//window.Pusher = require('pusher-js');

/*window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_PUSHER_HOST,
    //wsPath: '/socket',
    wsPort: process.env.MIX_PUSHER_PORT,
    wssPort: process.env.MIX_PUSHER_PORT,
    forceTLS: false,
    encrypted: true,
    enableLogging: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});*/

import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_LARAVEL_WEBSOCKET_ADDRESS,
    wsPort: process.env.MIX_PUSHER_PORT,
    wssPort: process.env.MIX_PUSHER_PORT,
    forceTLS: false,
    disableStats: false,
});

console.log({
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_LARAVEL_WEBSOCKET_ADDRESS
})
