<?php

return [
    /*
    |-------------------------------------------------------------
    | Your validation token from "App Credentials"
    |-------------------------------------------------------------
    */
    'signing_secret' => env('SLACK_SIGNING_SECRET', 'your-signing-secret'),

    /*
    |-------------------------------------------------------------
    | Events Request URL — path, where events will be served
    |-------------------------------------------------------------
    */
    'route' => '_slack-events',

];
