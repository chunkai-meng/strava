<?php
include '../vendor/autoload.php';

use Strava\API\Client;
use Strava\API\Exception;
use Strava\API\Service\REST;



try {
    $token = '1aaa15b17163e597c6c491b5284aa40c775d935d';
    $adapter = new Pest('https://www.strava.com/api/v3');
    $service = new REST($token, $adapter);  // Define your user token here.
    $client = new Client($service);

    $athlete = $client->getAthlete();
    print_r($athlete);

    $activities = $client->getAthleteActivities();
    print_r($activities);

    $club = $client->getClub(9729);
    print_r($club);
} catch(Exception $e) {
    print $e->getMessage();
}
