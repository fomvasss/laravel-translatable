<?php

return [
    /* -----------------------------------------------------------------
     |  The default DB columns name
     | -----------------------------------------------------------------
     */

    'db' => [
        'columns' => [
            'langcode' => 'langcode',
            'translation_uuid' => 'translation_uuid',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Allowed languages
     | -----------------------------------------------------------------
     */
    'languages' => [
        'en' => [
            'code' => 'en',
            'locale' => 'en_GB',
            'name' => 'English',
            'native' => 'English',
            'dir' => 'ltr',
            'flag' => 'gb',
        ],
        'es' => [
            'code' => 'es',
            'locale' => 'es_ES',
            'name' => 'Spanish',
            'native' => 'Español',
            'dir' => 'ltr',
            'flag' => 'es',
        ],
        'ru' => [
            'code' => 'ru',
            'locale' => 'ru_RU',
            'name' => 'Russian',
            'native' => 'Русский',
            'dir' => 'ltr',
            'flag' => 'ru',
        ],
        'uk' => [
            'code' => 'uk',
            'locale' => 'uk_UA',
            'name' => 'Ukrainian',
            'native' => 'Українська',
            'dir' => 'ltr',
            'flag' => 'ua',
        ],
    ],
];
