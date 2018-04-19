<?php
return [
    'M' => [
        'type' => 1,
        'ruleName' => 'tipoUsuario',
    ],
    'E' => [
        'type' => 1,
        'ruleName' => 'tipoUsuario',
    ],
    'F' => [
        'type' => 1,
        'ruleName' => 'tipoUsuario',
    ],
    'A' => [
        'type' => 1,
        'ruleName' => 'tipoUsuario',
        'children' => [
            'M',
            'E',
            'F'
        ],
    ],
    'master' => [
        'type' => 1,
        'ruleName' => 'tipoUsuario',
        'children' => [
            'A',
        ],
    ],
];
