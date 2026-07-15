<?php

return [
    'name' => 'Kaupunkipelit',

    'nav' => [
        'cities' => 'Kaupungit',
    ],

    'home' => [
        'title' => 'Kaupunkipelit',
        'subtitle' => 'Valitse kaupunki ja sen jälkeen peli.',
        'intro' => 'Tämä varhainen versio testaa sovelluksen kulkua: valitse kaupunki, valitse peli, lue vaiheet ja siirry eteenpäin syöttämällä koodi.',
        'start' => 'Aloita — valitse kaupunki',
        'no_cities' => 'Aktiivisia kaupunkeja ei vielä ole.',
    ],

    'cities' => [
        'title' => 'Valitse kaupunki',
        'subtitle' => 'Valitse ensin kaupunki, jossa haluat pelata.',
        'games_count' => ':count peli',
        'empty' => 'Aktiivisia kaupunkeja ei vielä ole.',
        'choose_game' => 'Valitse peli.',
        'no_games' => 'Tälle kaupungille ei ole vielä julkaistu pelejä.',
    ],

    'games' => [
        'stages' => ':count vaihetta',
        'prototype_note' => 'Pelissä on :count vaihetta. Tässä varhaisessa versiossa näytetään vain vaiheiden tekstit ja koodit — ei arvoituksia eikä sijaintiaktivointia.',
        'start' => 'Aloita peli',
        'complete' => [
            'title' => 'Peli päättyi',
            'congrats' => 'Onneksi olkoon! Suoritit kaikki vaiheet.',
            'truth' => 'Viljaa ei varastettu; se piilotettiin.',
            'truth_code' => 'EI VARASTETTU. KÄTKETTY.',
            'summary' => 'Viktor Granholm oli syyllinen. Kaksitoista ruis tynnyriä löytyi piilotettuna tehtaan varastosta III.',
            'back' => 'Takaisin kaupungin peleihin',
            'restart' => 'Pelaa uudelleen',
        ],
    ],

    'stages' => [
        'stage' => 'Vaihe :order',
        'acts' => [
            1 => 'Ensimmäinen näytös: Veitsimiesten varjo',
            2 => 'Toinen näytös: Kaupungin kunnioitetut nimet',
            3 => 'Kolmas näytös: Luvut ja muisti',
        ],
        'code_label' => 'Tämän vaiheen koodi',
        'copy' => 'Kopioi',
        'copied' => 'Kopioitu',
        'code_hint' => 'Testataksesi sovelluksen kulkua kopioi tämä koodi ja syötä se alle.',
        'next_destination' => 'Seuraava kohde: :name',
        'code_input' => 'Syötä vaiheen koodi',
        'code_placeholder' => 'esim. VANKILA',
        'submit_next' => 'Siirry seuraavaan vaiheeseen',
        'submit_finish' => 'Lopeta peli',
        'previous' => 'Edellinen vaihe',
        'return_current' => 'Palaa nykyiseen vaiheeseen',
        'review_note' => 'Tarkastelet aiemmin suorittamaasi vaihetta.',
        'invalid_code' => 'Syöttämäsi koodi on virheellinen.',
    ],

    'language' => [
        'label' => 'Kieli',
    ],
];
