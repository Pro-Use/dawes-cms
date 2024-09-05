<?php
Kirby::plugin('10pm/cache-control', [
    'sections' => [
        'cache-control' => [
            'props' => [
                'label' => function ($label) {
                    return $label;
                }
            ]
        ]
    ],
    'api' => [
        'routes' => function ($kirby) {
            return [
              [
                'pattern' => 'refresh-cache',
                'auth' => false,
                'action'  => function () use ($kirby) {
                    // flush cache
                    $kirby->cache('pages')->flush();
                    $subpages = $kirby->site()->children();
                    $names = [];
                    foreach($subpages as $page){
                        $template = $page->template();
		                $representation = $kirby->template($template->name(), 'json');
                        $has_json = $representation->exists() === true;
                        if($page->isCacheable() && $has_json){
                            $data = $page->content()->data();
                            $res = $page->render($data, 'json');
                            $file = $representation->name().'.'.$representation->type();
                            array_push($names, $file);
                        }
                    }
                    return $names;
                }
              ]
            ];
        }
    ],
    'hooks' => [
        'page.*:after' => function ($event) {
            if ($event->action() === 'render'){
                return;
            } else {
                $res = $this->api()->call('/refresh-cache');
                return;
            }
        }
    ],
]);