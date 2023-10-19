<?php defined('BASE_DIR') || exit;

$nav_items = [
    [
        'label' => 'Home',
        'link' => '#',
        'icon' => 'fa fa-home'
    ],
    [
        'label' => 'Link 1',
        'link' => '#link1',
        'icon' => ''
    ]
];

json_res( $nav_items );