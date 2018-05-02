# Sport Analysis

> A platform better visualize you sport data  
> Team Member:

## Strava API Lib Usage
- Derek find a very useful Strava PHP library and it's very easy to use:
``` bash
git clone https://github.com/basvandorst/StravaPHP.git
composer install
```

- A sample PHP page:
```php
<?php
include '../vendor/autoload.php';

use Strava\API\OAuth;
use Strava\API\Exception;
use Strava\API\Client;
use Strava\API\Service\REST;

try {
    // **Change** blow parameters with your own APP value
    $options = [
        'clientId'     => 888888,
        'clientSecret' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        // **Change** here to redirect to the same page to post and receive the token.
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
            $adapter = new Pest('https://www.strava.com/api/v3');
            $service = new REST($token, $adapter);  // Define your user token here.
            $client = new Client($service);

            // print out whatever you want.
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
```

- The OAuth Flow：
    - Get method redirect customer to strava with client_id, redirect_uri, etc, but not client_secret
    - customer is asked to logon Strava
    - customer is asked to grant data access to our APP
    - on success，strava redirect back to redirect_uri and exchange the temporary authorization code for an access token, using our client ID and client_secret [POST to https://www.strava.com/oauth/token]
    - if success our server will receive a customer token
    - then we can use this token in Strava API to collect customer data.

## Action Plan:

#### 1. User ID related ToDo List:
![image](readme_asset/Sport%20Analyst.png)
- [x] Register / Login
- [x] Retrieve user token
- [ ] Auto create user ID with user's Strava profile
- [ ] Ask and save user password after connecting to strava

### 2. Home Page and Segments
- [ ] Show Dashboard




## Other resource about Laravel

#### Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of any modern web application framework, making it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 1100 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

#### Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Pulse Storm](http://www.pulsestorm.net/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)

#### Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

#### Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

#### License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
