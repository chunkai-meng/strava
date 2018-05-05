<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Pest;
use Strava\API\OAuth;
use Strava\API\Exception;

use Strava\API\Client;
use Strava\API\Service\REST;

class StravaController extends Controller
{
    public function strava(){
        $token = $this->strava_auth();
        if ($token){
            print $token;
        }
    }

    private function strava_auth(){
        try {
            $options = [
                'clientId'     => env("CLIENT_ID"),
                'clientSecret' => env("CLIENT_SECRET"),
                'redirectUri'  => env("REDIRECT_URI")
            ];
            $oauth = new OAuth($options);

            if (!isset($_GET['code'])) {
                $strava_link = '<a href="'.$oauth->getAuthorizationUrl([
                        // Uncomment required scopes.
                        'scope' => [
                            'public',
                            // 'write',
                            // 'view_private',
                        ]
                    ]).'"><img alt="Connect with Strava1" src="/img/ConnectToStrava.png"></a>';

                return view('welcome', ['strava_link'=> $strava_link]);
            } else {
                $token = $oauth->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);

                try {
                    $adapter = new Pest('https://www.strava.com/api/v3');
                    $service = new REST($token, $adapter);  // Define your user token here.
                    $client = new Client($service);
                    $athlete = $client->getAthlete();

                    $user = new User();
                    $user->name = $athlete["username"];
                    $user->email = $athlete["email"];
                    $user->password = bcrypt("123");
                    $user->save();
                    Auth::login($user);
                    print_r($athlete);
                    return view('home', ['token' => $token, 'username'=>$athlete["username"], 'email'=>$athlete["email"]]);

                } catch(Exception $e) {
                    print $e->getMessage();
                }

                return $token;
            }
        } catch(Exception $e) {
            print $e->getMessage();
        }
    }
}
