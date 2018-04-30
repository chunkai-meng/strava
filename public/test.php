<?

$servername = "localhost";
$username = "leeg36_admin";
$password = "11011993";
$database = "leeg36_wordpressDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

$url = 'https://www.strava.com/api/v3/athlete?access_token=c5d7635cf4b2b94fa48eb55794fc376214cd97d8';

if (!function_exists('curl_init'))
    { 
        die('CURL is not installed!\n');
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($output,true);
    
    $firstname = ($obj['firstname']);
    $lastname = ($obj['lastname']);
    $sex =  ($obj['sex']);
    $city = ($obj['city']);
    $country = ($obj['country']);
    
    print($firstname.$lastname.$sex.$city.$country);
    
    $sql = "INSERT into athlete (firstname,lastname,sex,city,country) VALUES
    ('$firstname','$lastname','$sex','$city','$country')";
    
    if ($conn->query($sql) === TRUE) 
    {
        echo ("New record created successfully");
    } 
    else 
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

$conn->close();



//$obj = json_decode($json,true);
//foreach($obj as $item)
//{
//    $name = $item['name'];
//    $start_date = $item['start_date'];
//    echo $name." ".$start_date. "\n";

?>
