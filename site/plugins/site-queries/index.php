<?php

Kirby::plugin('10pm/dawes-site-queries', [
    'api' => [
        'routes' => function ($kirby) {
            return [
              [
                'pattern' => 'site-query',
                'auth' => false,
                'action'  => function () use ($kirby) {
                    $cache_exists = false;
                    $result = [
                        "url"=> $kirby->site()->url(),
                        "title" => $kirby->site()->meta_title(),
                        "meta_description" => $kirby->site()->meta_description(),
                        "news_on" => $kirby->site()->news_on()->toBool(),
                        "news_text" => $kirby->site()->news_text()->upper(),
                    ];

                    return new Response(json_encode($result), 'application/json', 200, ['X-Cached' => $cache_exists]);
                }
              ]
            ];
        }
    ]
]);