<?php

Kirby::plugin('10pm/dawes-headless', [
    'routes' => [
        [
            'pattern' => 'mailing-list-signup',
            'method' => 'POST',
            'action' => function () {
                $key = 'fd_key_e0455ad3afdb4149a01b07fa7b3f11f6.mqu8tfonr8NeKidUcIcudrAxLW4TFKtbKNlvjIQXS8m3TFy3BI5U2kM07lv4D0aZ1ZWjOVlX5fgNCahYps8QlgkxeLSml6ZN2hrFIVJX4F4jWMcG5FsgYVirEZYYbpLxfUVUlJctqWF0isqj0Xk9RRvvgv76NdZkKbtDbAgxgJ45635pjPFw3VO9ZZfSYduS';
                $payload = get();
                if (array_key_exists('email', $payload)){
                // if (true){
                    $dt = new DateTime();
                    $ds = $dt->format('Y-m-d\TH:i:s.').substr($dt->format('u'),0,3).'Z';
                    $data = [
                        "status" => "active",
                        "email" => $payload['email'],
                        "source" => "manual",
                        "created_at" => $ds
                    ];
                    $response = Remote::request('https://api.flodesk.com/v1/subscribers', [
                        'method' => 'POST',
                        'headers' => [
                            'Authorization: Basic ' . base64_encode($key . ':'),
                            'Content-Type: application/json',
                        ],
                        'data' => json_encode($data),
                    ]);

                    if ($response->code() === 200) {
                        $data = $response->content();
                        $data_obj = json_decode($data, true);
                        $id = $data_obj['id'];
                        $seg_res = Remote::request('https://api.flodesk.com/v1/subscribers/'.$id.'/segments', [
	                        'method' => 'POST',
	                        'headers' => [
	                            'Authorization: Basic ' . base64_encode($key . ':'),
	                            'Content-Type: application/json',
	                        ],
	                        'data' => '{"segment_ids":["65731ff166c73e02f2427d74"]}',
	                    ]);
	                    if ($seg_res->code() === 200) {
	                    	$seg_res_data = $seg_res->content();
	                    	return new Response($seg_res_data, 'application/json', $seg_res->code());
	                    } else {
	                    	// $seg_res_data = $seg_res->content();
	                    	return new Response($data, 'application/json', $res->code());
	                    }                     
                        
                    }
                    else {
                        $data = $response->content();                  
                        return new Response($data, 'application/json', $response->code());
                    }
                } else {
                    return new Response('{message: No valid email}', 'application/json', 401);
                }
            }
        ],
        [
            'pattern' => 'assets/(:all)',
            'action'  => function($all) {
                if (strpos($all, '.js') != false){
                	$resource = file_get_contents(__DIR__ . '/dist/assets/' . $all);
                	return new Response($resource, 'text/javascript');
                } elseif (strpos($all, '.css') != false){
                	$resource = file_get_contents(__DIR__ . '/dist/assets/' . $all);
                	return new Response($resource, 'text/css');
                } elseif (strpos($all, '.woff') != false){
                	$resource = file_get_contents(__DIR__ . '/dist/assets/' . $all);
                	return new Response($resource, 'application/font-woff2');
                } elseif (strpos($all, '.svg') != false){
                	$resource = file_get_contents(__DIR__ . '/dist/assets/' . $all);
                	return new Response($resource, 'image/svg+xml');
                }
                
            }
        ],
    ],
    'templates' => [
        'default' => __DIR__ . '/dist/index.html'
    ],
]);