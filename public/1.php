<?php
include '../vendor/autoload.php';

use Strava\API\OAuth;
use Strava\API\Exception;

try {
    $options = [
        'clientId'     => 25225,
        'clientSecret' => '68ec92ec441b834fa248b397984a81cf462a8b7d',
        'redirectUri'  => 'http://mengc06.cpanel.unitec.ac.nz/sportanalysis/public/'
    ];
    $oauth = new OAuth($options);

    if (!isset($_GET['code'])) {
        print '<a href="'.$oauth->getAuthorizationUrl([
            // Uncomment required scopes.
            'scope' => [
                'public',
                // 'write',
                // 'view_private',
            ]
        ]).'">Connect</a>';
    } else {
        $token = $oauth->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        print $token->getToken();
    }
} catch(Exception $e) {
    print $e->getMessage();
}
