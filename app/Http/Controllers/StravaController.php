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
    private function create_user(User $user){
        $if_exist = false;

        if (is_null(User::where('email', $user->email) -> first())){
            $user->save();
        } else {
            $if_exist = true;
        }

        Auth::login($user);
        return $if_exist;
    }

    public function strava_auth(){
        try {
            $options = [
                'clientId'     => env("CLIENT_ID"),
                'clientSecret' => env("CLIENT_SECRET"),
                'redirectUri'  => env("REDIRECT_URI")
            ];
            $oauth = new OAuth($options);

            if (!isset($_GET['code'])) {
                $strava_link = $oauth->getAuthorizationUrl([
                        // Uncomment required scopes.
                        'scope' => [
                            'public',
                            // 'write',
                            // 'view_private',
                        ]
                    ]);

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

                    $if_exist = $this->create_user($user);
                    return view('home', ['athlete'=>$athlete, 'if_exist'=>$if_exist]);
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
