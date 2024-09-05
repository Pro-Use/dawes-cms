<?php

return [
    'languages' => true,
    'debug'  => true,
    'kql' => [
        'auth' => false
    ],
    'thumbs' => [
        'srcsets' => [
                'half' => [300, 600, 800, 1024],
                'full' => [300, 600, 800, 1024, 2048]
            ]
    ],
    'cache' => [
        'pages' => [
            'active' => true,
        ]
    ],

    // Flodesk signup route
    // 'routes' => [
    //     [
    //         'pattern' => 'mailing-list-signup',
    //         'method' => 'POST',
    //         'action' => function () {
    //             $key = 'fd_key_e0455ad3afdb4149a01b07fa7b3f11f6.mqu8tfonr8NeKidUcIcudrAxLW4TFKtbKNlvjIQXS8m3TFy3BI5U2kM07lv4D0aZ1ZWjOVlX5fgNCahYps8QlgkxeLSml6ZN2hrFIVJX4F4jWMcG5FsgYVirEZYYbpLxfUVUlJctqWF0isqj0Xk9RRvvgv76NdZkKbtDbAgxgJ45635pjPFw3VO9ZZfSYduS';
    //             $payload = get();
    //             // if (array_key_exists('email', $payload)){
    //             if (true){
    //                 $dt = new DateTime();
    //                 $ds = $dt->format('Y-m-d\TH:i:s.').substr($dt->format('u'),0,3).'Z';
    //                 $data = [
    //                     "status" => "active",
    //                     "email" => $payload['email'],
    //                     // "email" => "rob@10pm.studio",
    //                     "source" => "manual",
    //                     "created_at" => $ds
    //                 ];
    //                 $response = Remote::request('https://api.flodesk.com/v1/subscribers', [
    //                     'method' => 'POST',
    //                     'headers' => [
    //                         'Authorization: Basic ' . base64_encode($key . ':'),
    //                         'Content-Type: application/json',
    //                     ],
    //                     'data' => json_encode($data),
    //                 ]);

    //                 if ($response->code() === 200) {
    //                     // var_dump($response->code());
    //                     // dump($response->content());
    //                     $data = $response->content();                        
    //                     return new Response($data, 'application/json', $response->code());
    //                 }
    //                 else {
    //                     $data = $response->content();                        
    //                     return new Response($data, 'application/json', $response->code());
    //                 }
    //             } else {
    //                 return new Response('no valid email');
    //             }
    //         }
    //     ]
    // ]
];