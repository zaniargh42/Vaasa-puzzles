<?php

return [
    'name' => 'City Games',

    'nav' => [
        'cities' => 'Cities',
    ],

    'home' => [
        'title' => 'City Games',
        'subtitle' => 'Choose a city, then pick a game to begin.',
        'intro' => 'This early version tests the app flow: choose a city, choose a game, read each stage, and enter the code to continue.',
        'start' => 'Start — choose a city',
        'no_cities' => 'No active cities yet.',
    ],

    'cities' => [
        'title' => 'Choose a city',
        'subtitle' => 'First, choose the city where you want to play.',
        'games_count' => ':count game|:count games',
        'empty' => 'No cities are active yet.',
        'choose_game' => 'Choose a game.',
        'no_games' => 'No games have been published for this city yet.',
    ],

    'games' => [
        'stages' => ':count stages',
        'prototype_note' => 'This game has :count stages. In this early version, only stage text and codes are shown — no puzzles and no location activation.',
        'start' => 'Start game',
        'complete' => [
            'title' => 'Game complete',
            'congrats' => 'Congratulations! You completed all stages.',
            'truth' => 'The grain was not stolen; it was hidden.',
            'truth_code' => 'EI VARASTETTU. KÄTKETTY.',
            'summary' => 'Viktor Granholm was the culprit. Twelve barrels of rye were found hidden in warehouse III at the cotton factory.',
            'back' => 'Back to city games',
            'restart' => 'Play again',
        ],
    ],

    'stages' => [
        'stage' => 'Stage :order',
        'acts' => [
            1 => 'Act I: Shadow of the knife men',
            2 => 'Act II: Respected names of the city',
            3 => 'Act III: Numbers and memory',
        ],
        'code_label' => 'Code for this stage',
        'copy' => 'Copy',
        'copied' => 'Copied',
        'code_hint' => 'For testing the app flow, copy this code and enter it below.',
        'next_destination' => 'Next destination: :name',
        'code_input' => 'Enter the stage code',
        'code_placeholder' => 'e.g. VANKILA',
        'submit_next' => 'Go to next stage',
        'submit_finish' => 'Finish game',
        'previous' => 'Previous stage',
        'return_current' => 'Return to current stage',
        'review_note' => 'You are reviewing a completed stage.',
        'invalid_code' => 'The code you entered is incorrect.',
    ],

    'language' => [
        'label' => 'Language',
    ],
];
