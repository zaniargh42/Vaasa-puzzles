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
        'directions' => 'Reittiohjeet tähän vaiheeseen',
        'open_maps' => 'Avaa kartta',
        'code_input' => 'Syötä vaiheen koodi',
        'code_placeholder' => 'esim. VANKILA',
        'submit_next' => 'Siirry seuraavaan vaiheeseen',
        'submit_finish' => 'Lopeta peli',
        'previous' => 'Edellinen vaihe',
        'next' => 'Seuraava vaihe',
        'return_current' => 'Palaa nykyiseen vaiheeseen',
        'review_note' => 'Tarkastelet aiemmin suorittamaasi vaihetta.',
        'invalid_code' => 'Syöttämäsi koodi on virheellinen.',
        'dev_puzzle_title' => 'Kehittäjän muistiinpano — pulman suunnittelu (väliaikainen)',
        'dev_puzzle_hint' => 'Vain tiimiä varten; tämä osio poistetaan myöhemmin.',
    ],

    'bag' => [
        'title' => 'Pelilaukku',
        'close' => 'Sulje',
        'empty' => 'Laukussa ei ole vielä mitään.',
        'view_overlay' => 'Näytä nykykartalla',
        'overlay_help' => 'Vanha suunnitelma on lukittu paikoilleen. Säätimen avulla näet enemmän tai vähemmän nykykarttaa alta.',
        'items' => [
            'setterberg_plan' => 'Setterbergin kaupunkisuunnitelma',
            'setterberg_plan_aligned' => 'Setterbergin suunnitelma (kohdistettu)',
        ],
    ],

    'stage1' => [
        'part1_title' => '1. Vanha kaupunkisuunnitelma',
        'part1_help' => 'Lisää Setterbergin asemakaava pelilaukkuun. (Ei AR:ää vielä; myöhemmin tämä avautuu muistomerkin luona.)',
        'add_to_bag' => 'Lisää kartta pelilaukkuun',
        'map_in_bag' => 'Kartta on pelilaukussasi. Voit avata laukun yläpalkista.',
        'part2_title' => '2. Kohdista nykykartalle',
        'part2_help' => 'Vedä, kierrä ja skaalaa kunnes se sopii suunnilleen kaupunkiin. Kun olet tarpeeksi lähellä, se napsahtaa ja lukittuu — millimetrin tarkkuutta ei tarvita.',
        'check_alignment' => 'Tarkista kohdistus',
        'align_success' => 'Kartta lukittu ja vaiheen koodi avattu. Käytä peittävyyssäädintä nähdäksesi alle.',
        'align_fail' => 'Ei vielä tarpeeksi lähellä. Säädä kiertoa, kokoa tai sijaintia.',
        'code_locked' => 'Lisää kartta laukkuun ja viimeistele kohdistus nähdäksesi koodin.',
        'overlay_in_bag' => 'Tämä kohdistettu kartta on myös tallennettu pelilaukkuun.',
        'legend_done' => 'Nykyinen paikka (vaihe valmis)',
        'legend_next' => 'Seuraava kohde — Vaasan vankila',
        'success_title' => 'Suunnitelma lukittui paikoilleen',
        'success_body' => 'Tutkimuksen sinetti on lyöty. Viljan reitti selkenee — katso seuraava kohde kartalta.',
    ],

    'locations' => [
        'st_nicholas' => 'Pyhän Nikolauksen ortodoksikirkko',
        'vaasa_prison' => 'Vaasan vankila',
    ],

    'calibrator' => [
        'badge' => 'Kehitystyökalu',
        'title' => 'Setterberg-kartan kalibroija',
        'help' => 'Siirrä ja kierrä historiallista suunnitelmaa OSM:n päällä kunnes se sopii. Kopioi JSON ja lähetä se, jotta pulman target voidaan lukita.',
        'copy_json' => 'Kopioi kalibrointi-JSON',
        'copied' => 'Kopioitu',
        'back' => 'Takaisin',
    ],

    'language' => [
        'label' => 'Kieli',
    ],
];
