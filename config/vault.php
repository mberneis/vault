<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Minutes to cache
    |--------------------------------------------------------------------------
    |
    | The selection of minutes text can be cached for. Each label is a
| translation key plus its replacements, translated in the view.
    |
    */

    'minutes' => [
        '30'     => ['vault.form.minutes', ['minutes' => 30]],
        '60'     => ['vault.form.hour', ['hour' => 1]],
        '720'    => ['vault.form.hours', ['hours' => 12]],
        '1440'   => ['vault.form.hours', ['hours' => 24]],
        '2880'   => ['vault.form.hours', ['hours' => 48]],
        '10080'  => ['vault.form.days', ['days' => 7]],
        '20160'  => ['vault.form.days', ['days' => 14]],
        '43200'  => ['vault.form.days', ['days' => 30]],
    ],

    /*
    |--------------------------------------------------------------------------
    | Max text size (in bytes)
    |--------------------------------------------------------------------------
    |
    | Don't allow text larger than this. Note, this limit is checked after the text
    | has been encrypted and base 64 encoded client side which means isn't
    | significantly larger than the original text entered by the user.
    |
    */

    'max_size' => 32000,

    /*
    |--------------------------------------------------------------------------
    | Google Analytics ID
    |--------------------------------------------------------------------------
    |
    | Enter your Google Analytics ID in "UA-XXXXXX" format for tracking
    */

    'google_analytics' => false,
];
