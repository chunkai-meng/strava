<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sport Analysis</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Hi Strava! I'm Sport Analyst.
                </div>
                    <a href="/user/strava-login" title="Connect with Strava">

<?php
include '../vendor/autoload.php';

use Strava\API\OAuth;
use Strava\API\Exception;
use Strava\API\Client;
use Strava\API\Service\REST;

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
        ]).'"><img alt="Connect with Strava" src="/sportanalysis/public/img/ConnectToStrava.png"></a>';
    } else {
        $token = $oauth->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        echo '<h4>';
        print $token->getToken();
        echo '</h4>';

        try {
//            $token = '1aaa15b17163e597c6c491b5284aa40c775d935d';
            $adapter = new Pest('https://www.strava.com/api/v3');
            $service = new REST($token, $adapter);  // Define your user token here.
            $client = new Client($service);

            echo "<br />";
            $athlete = $client->getAthlete();
            print_r($athlete);
            echo "<br />";
            $activities = $client->getAthleteActivities();
            print_r($activities);
            echo "<br />";
            $club = $client->getClub(9729);
            print_r($club);
        } catch(Exception $e) {
            print $e->getMessage();
        }
    }
} catch(Exception $e) {
    print $e->getMessage();
}
?>
                </a>
                <div class="links">
                    <a href="https://www.strava.com">Strava</a>
                    {{--<a href="https://laracasts.com">Laracasts</a>--}}
                    {{--<a href="https://laravel-news.com">News</a>--}}
                    {{--<a href="https://forge.laravel.com">Forge</a>--}}
                    {{--<a href="https://github.com/laravel/laravel">GitHub</a>--}}
                </div>
            </div>
        </div>
    </body>
</html>
