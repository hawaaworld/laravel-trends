<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Trends Loss Time
    |--------------------------------------------------------------------------
    |
    | Defines how long your energy starts to loss in minutes. The energy
    | losses three times until it returns to 0. For example if value is
    | set to 60 minutes it would take 3 hours to energy return to zero.
    |
    */
    'loss_time' => env('TRENDS_LOSS_TIME', 60),

    /*
    |--------------------------------------------------------------------------
    | IP Blacklist
    |--------------------------------------------------------------------------
    |
    | Sometimes you may want to prevent an IP to add energy to a model.
    | You can add as many IPs as you want to.
    |
    */
    'ip_blacklist' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Trends Loss Sequence
    |--------------------------------------------------------------------------
    |
    | Defines the sequence of energy losing. You can add as many
    | sequences as you want.
    |
    */
    'loss_sequence' => [0.25, 0.45, 0.30],

    /*
    |--------------------------------------------------------------------------
    | Truncate Zero Energy Trends
    |--------------------------------------------------------------------------
    |
    | Defines if the trends should be truncated. If set to true,
    | the trends with the zero energy will be deleted immediately.
    |
    */
    'truncate' => true,

    /*
    |--------------------------------------------------------------------------
    | Dispatch Jobs To Queue
    |--------------------------------------------------------------------------
    |
    | Defines if the jobs should be dispatched to queue. If set to true,
    | the jobs will be dispatched to queue. If set to false, the jobs
    | will be executed synchronously.
    */
    'queue' => true,
];
