<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => 'AAAAI-ja_Zk:APA91bGqMacv2IkylTMXFDW8awYe9mn_apiKxN79UZWasVU4fWbdKu7ou85hHJq2nGnjsAWkF5Wp7GHaju2cHfvfYWE_8kpVqnrXwEy2Pmv1T0fba8xR11C529ki8wAlYP--6BdkNF0g',
        'sender_id' => '154230521241',
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
