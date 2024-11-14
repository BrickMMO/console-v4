<?php

function navigation_array($selected = false)
{

    $navigation = [
        [
            'title' => 'City Portal',
            'sections' => [
                [
                    'title' => 'Geography',
                    'id' => 'geography',
                    'pages' => [
                        [
                            'icon' => 'bm-roadview',
                            'url' => '/maps/dashboard',
                            'title' => 'Maps',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/maps/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Map Quick Edit',
                                    'url' => '/maps/quick',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit BrickMMO Maps',
                                    'url' => 'https://maps.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange'
                                ]
                            ]   
                        ],[
                            'icon' => 'bm-roadview',
                            'url' => '/roadview/dashboard',
                            'title' => 'Roadview',
                        ],[
                            'icon' => 'bm-roadview',
                            'url' => '/places/dashboard',
                            'title' => 'Places',
                        ]
                    ],
                ],[
                    'title' => 'Control',
                    'id' => 'control',
                    'pages' => [
                        [
                            'icon' => 'bm-control-panel',
                            'url' => '/control-panel',
                            'title' => 'Control Panel',
                        ],[
                            'icon' => 'bm-control-clock',
                            'url' => '/clock/dashboard',
                            'title' => 'Clock',
                        ]
                    ],
                ],[
                    'title' => 'Transportation',
                    'id' => 'transportation',
                    'pages' => [
                        [
                            'icon' => 'bm-navigation',
                            'url' => '/navigation/dashboard',
                            'title' => 'Navigation',
                        ],[
                            'icon' => 'bm-tracks',
                            'url' => '/tracks/dashboard',
                            'title' => 'Tracks',
                        ],[
                            'icon' => 'bm-train',
                            'url' => '/train/dashboard',
                            'title' => 'Train',
                        ],
                    ],
                ],[
                    'title' => 'Community',
                    'id' => 'community',
                    'pages' => [
                        [
                            'icon' => 'bm-radio',
                            'url' => '/radio/dashboard',
                            'title' => 'Radio',
                        ],[
                            'icon' => 'bm-events',
                            'url' => '/events/dashboard',
                            'title' => 'Events',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/events/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Event List',
                                    'url' => '/events/list',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Registration List',
                                    'url' => '/events/registrations/list',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit Events App',
                                    'url' => 'https://events.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/events',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/stats',
                                    'colour' => 'orange'
                                ]
                            ]
                        ],[
                            'icon' => 'bm-qr-codes',
                            'url' => '/qr-codes/dashboard',
                            'title' => 'Qr Codes',
                        ],
                    ],
                ],[
                    'title' => 'Social',
                    'id' => 'social',
                    'pages' => [
                        [
                            'icon' => 'bm-brix',
                            'url' => '/brix/dashboard',
                            'title' => 'Brix',
                        ],[
                            'icon' => 'bm-timeline',
                            'url' => '/timeline/dashboard',
                            'title' => 'Timeline',
                        ],
                    ],
                ],[
                    'title' => 'Finances',
                    'id' => 'finances',
                    'pages' => [
                        [
                            'icon' => 'bm-crypto',
                            'url' => '/crypto/dashboard',
                            'title' => 'Crypto',
                        ],
                    ],
                ],
            ],
        ],[
            'title' => 'Student Portal',
            'sections' => [
                [
                    'title' => 'Workflow',
                    'id' => 'students',
                    'pages' => [
                        [
                            'icon' => 'bm-timesheets',
                            'url' => '/timesheets/dashboard',
                            'title' => 'Timesheets',
                            'sub-pages' => [
                                [
                                    'title' => 'Log in hours',
                                    'url' => '/timesheets/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'View Timesheet',
                                    'url' => '/timesheets/dashboard/list',
                                    'colour' => 'orange'
                                ],
                            ],
                        ],[
                            'icon' => 'bm-brickoverflow',
                            'url' => '/brickoverflow/dashboard',
                            'title' => 'BrickOverflow',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/brickoverflow/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/brickoverflow',
                                    'colour' => 'orange'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],[
            'title' => 'Administration',
            'sections' => [
                [
                    'title' => 'Content',
                    'id' => 'admin-content',
                    'pages' => [
                        [
                            'icon' => 'bm-bricksum',
                            'url' => '/admin/bricksum/dashboard',
                            'title' => 'Bricksum',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/bricksum/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Modify Word List',
                                    'url' => '/bricksum/wordlist',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit Bricksum App',
                                    'url' => 'https://bricksum.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/bricksum',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/stats',
                                    'colour' => 'orange'
                                ]
                            ]
                        ],[
                            'icon' => 'bm-colours',
                            'url' => '/admin/colours/dashboard',
                            'title' => 'Colours',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/colours/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Import Colours',
                                    'url' => '/admin/colours/import',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit Colors App',
                                    'url' => 'https://colours.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/colours',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/stats',
                                    'colour' => 'orange'
                                ]
                            ]
                        ],[
                            'icon' => 'bm-parts',
                            'url' => '/admin/parts/dashboard',
                            'title' => 'Parts',
                        ],[
                            'icon' => 'bm-stores',
                            'url' => '/admin/stores/dashboard',
                            'title' => 'Stores',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin//stores/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Import Stores',
                                    'url' => '/admin//stores/import',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Import Countries',
                                    'url' => '/admin//stores/countries',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit Stores App',
                                    'url' => 'https://stores.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/stores',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/stats',
                                    'colour' => 'orange'
                                ]
                            ]
                        ],[
                            'icon' => 'bm-media',
                            'url' => '/admin/media/dashboard',
                            'title' => 'Media',
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/media/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Images',
                                    'url' => '/admin/media/images',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Videos',
                                    'url' => '/admin/media/videos',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Tags',
                                    'url' => '/admin/media/tags',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Visit BrickMMO Media',
                                    'url' => 'https://media.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Uptime Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/uptime/maps',
                                    'colour' => 'orange'
                                ],
                            ] ,
                        ],
                    ],
                ],[
                    'title' => 'Finances',
                    'id' => 'admin-finances',
                    'pages' => [
                        [
                            'icon' => 'bm-crypto',
                            'url' => '/crypto/dashboard',
                            'title' => 'Crypto',
                        ],
                    ],
                ],[
                    'title' => 'Tools',
                    'id' => 'admin-tools',
                    'pages' => [
                        [
                            'icon' => 'bm-github',
                            'url' => '/admin/github/dashboard',
                            'title' => 'GitHub Scanner', 
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/admin/github/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'title' => 'Scan Results',
                                    'url' => '/admin/github/results',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'BrickMMO on GitHub',
                                    'url' => 'https://github.com/BrickMMO',
                                    'colour' => 'orange'
                                ],[
                                    'title' => 'codeadamca on GitHub',
                                    'url' => 'https://github.com/codeadamca',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/github',
                                    'colour' => 'orange'
                                ]
                            ],[
                                'icon' => 'bm-uptime',
                                'url' => '/uptime/dashboard',
                                'title' => 'Up Time',
                            ],[
                                'icon' => 'bm-stats',
                                'url' => '/stats/dashboard',
                                'title' => 'Stats',
                            ],
                        ],
                    ],
                ],[
                    'title' => 'Settings',
                    'id' => 'admin-settings',
                    'pages' => [
                        [
                            'icon' => 'bm-github',
                            'url' => '/projects/dashboard',
                            'title' => 'Projects', 
                            'sub-pages' => [
                                [
                                    'title' => 'Dashboard',
                                    'url' => '/projects/dashboard',
                                    'colour' => 'red'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Project Contributions',
                                    'url' => 'https://projects.brickmmo.com',
                                    'colour' => 'orange'
                                ],[
                                    'br' => '---'
                                ],[
                                    'title' => 'Stats Report',
                                    'url' => '/stats/projects',
                                    'colour' => 'orange'
                                ]
                            ],[
                                'icon' => 'bm-uptime',
                                'url' => '/uptime/dashboard',
                                'title' => 'Up Time',
                            ],[
                                'icon' => 'bm-stats',
                                'url' => '/stats/dashboard',
                                'title' => 'Stats',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];

    if($selected)
    {
        
        $selected = '/'.$selected;
        $selected = str_replace('//', '/', $selected);
        $selected = str_replace('.php', '', $selected);
        $selected = str_replace('.', '/', $selected);
        $selected = substr($selected, 0, strrpos($selected, '/'));

        foreach($navigation as $levels)
        {

            foreach($levels['sections'] as $section)
            {

                foreach($section['pages'] as $page)
                {

                    if(strpos($page['url'], $selected) === 0)
                    {
                        return $page;
                    }

                }

            }

        }

    }

    return $navigation;

}