<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => true,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAAjCwRM4:APA91bGUwPyEIfAfC6inbn-l--f1WHLprV8Vmsv8IlpM33lsbBszJmsuWuvHUlMlVq9HHO_0JtiRVcwVX2fyX67n0FpzFrKKSDVUDs3RjcCp28WkVV-jx1LxhJ7RDMgDeBLt9bokU9JW'),
        'sender_id' => env('FCM_SENDER_ID', '9406792910'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
