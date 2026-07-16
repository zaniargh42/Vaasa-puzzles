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
        'directions' => 'Directions to this stage',
        'open_maps' => 'Open maps',
        'code_input' => 'Enter the stage code',
        'code_placeholder' => 'e.g. VANKILA',
        'submit_next' => 'Go to next stage',
        'submit_finish' => 'Finish game',
        'previous' => 'Previous stage',
        'next' => 'Next stage',
        'return_current' => 'Return to current stage',
        'review_note' => 'You are reviewing a completed stage.',
        'invalid_code' => 'The code you entered is incorrect.',
        'dev_puzzle_title' => 'Dev note — puzzle design (temporary)',
        'dev_puzzle_hint' => 'For the team only; this section will be removed later.',
    ],

    'bag' => [
        'title' => 'Game bag',
        'close' => 'Close',
        'empty' => 'Nothing in the bag yet.',
        'view_overlay' => 'View on today’s map',
        'overlay_help' => 'The old plan is locked in place. Use the opacity slider to see more or less of the modern map underneath.',
        'items' => [
            'setterberg_plan' => 'Setterberg city plan',
            'setterberg_plan_aligned' => 'Setterberg plan (aligned)',
        ],
    ],

    'stage1' => [
        'part1_title' => '1. Old city plan',
        'part1_help' => 'Add the Setterberg master plan to your game bag. (No AR yet; later this unlocks near the monument.)',
        'add_to_bag' => 'Add map to game bag',
        'map_in_bag' => 'The map is in your game bag. Open the bag in the header to view it again.',
        'part2_title' => '2. Align on today’s map',
        'part2_help' => 'Drag, rotate, and scale until it roughly fits the city. When you are close enough, it snaps and locks — no millimetre precision needed.',
        'check_alignment' => 'Check alignment',
        'align_success' => 'Map locked and stage code unlocked. Use the opacity slider to peek underneath.',
        'align_fail' => 'Not close enough yet. Adjust rotation, size, or position a little.',
        'code_locked' => 'Add the map to your bag and finish the alignment to reveal the code.',
        'overlay_in_bag' => 'This aligned overlay is also saved in your game bag for later.',
        'legend_done' => 'Current place (stage complete)',
        'legend_next' => 'Next destination — Vaasa Prison',
        'success_title' => 'The plan has locked into place',
        'success_body' => 'The investigation seal is set. The grain route grows clearer — see the next destination on the map.',
    ],

    'locations' => [
        'st_nicholas' => 'St Nicholas Orthodox Church',
        'vaasa_prison' => 'Vaasa Prison',
    ],

    'calibrator' => [
        'badge' => 'Dev tool',
        'title' => 'Setterberg map calibrator',
        'help' => 'Move and rotate the historic plan over OSM until it fits. Then copy the JSON and send it so we can lock the puzzle target.',
        'copy_json' => 'Copy calibration JSON',
        'copied' => 'Copied',
        'back' => 'Back',
    ],

    'language' => [
        'label' => 'Language',
    ],
];
