<?php
return [
    'token'         => env('TELEGRAM_BOT_TOKEN'),
    'botusername'   => env('TELEGRAM_BOT_USERNAME'),
    
    // Chats where the bot will send messages
    'chats'         => [
        'default'   => env('TELEGRAM_CHAT_ID'),
        'error'     => env('TELEGRAM_CHAT_ID'),
        'alert'     => env('TELEGRAM_CHAT_ID'),
    ],
];