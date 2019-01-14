<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => '/Users/markbrand/Sites/sites/wl-schermen/www/feed/user/themes/boilerplate/blueprints/videos.yaml',
    'modified' => 1547295347,
    'data' => [
        'title' => 'Videos',
        '@extends' => 'simple',
        'form' => [
            'fields' => [
                'tabs' => [
                    'fields' => [
                        'content' => [
                            'type' => 'tab',
                            'title' => 'Content',
                            'fields' => [
                                'header.title' => [
                                    'unset@' => true
                                ],
                                'header.videos' => [
                                    'name' => 'videos',
                                    'type' => 'list',
                                    'style' => 'horizontal',
                                    'label' => 'Videos',
                                    'fields' => [
                                        '.id' => [
                                            'type' => 'text',
                                            'label' => 'Youtube ID'
                                        ],
                                        '.title' => [
                                            'type' => 'text',
                                            'label' => 'Titel'
                                        ],
                                        '.name' => [
                                            'type' => 'text',
                                            'label' => 'Naam'
                                        ],
                                        '.function' => [
                                            'type' => 'text',
                                            'label' => 'Functie'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
