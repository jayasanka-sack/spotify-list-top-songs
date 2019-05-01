<?php
session_start();
require '../../vendor/autoload.php';
$configFile = file_get_contents("../../config.json");
$config = json_decode($configFile, true);

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

$app->get('/get-token', function ($request, $response, $args) {

    global $config;
    $cars = array("Volvo", "BMW", "Toyota");

    echo $config["spotify"]["clientId"];

    $url = 'https://accounts.spotify.com/api/token';
    $data = array(
        'grant_type' => 'authorization_code',
        'code' => $request->getQueryParam("code", $default = ""),
        'redirect_uri' => "http://localhost/experiments/spotify/spotify-list-top-songs/api/v1/get-token",
        'client_id' => $config["spotify"]["clientId"],
        'client_secret' => $config["spotify"]["clientSecret"]
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
        echo "something went wrong";
    }

    $resultObj = json_decode($result);
    $_SESSION["access_token"]=$resultObj->access_token;

    return $response->withStatus(302)->withHeader('Location', '../../hoo.html');

});


$app->get('/get-songs', function ($request, $response, $args) {
    $url = 'https://api.spotify.com/v1/me/top/tracks?time_range=medium_term&limit=10&offset=5';
    $data = array(

    );

    $accessToken = $_SESSION["access_token"];
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n".
                "Authorization: Bearer $accessToken\r\n",
            'method' => 'GET'
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */
        echo "something went wrong";
    }

    $resultObj = json_decode($result);

    return $response->withStatus(200)->withJson($resultObj);

});


$app->get('/display-token', function ($request, $response, $args) {
    $payload = array("token"=>$_SESSION['access_token']);
    return $response->withStatus(200)->withJson($payload);

});


try {
    $app->run();
} catch (\Slim\Exception\MethodNotAllowedException $e) {
} catch (\Slim\Exception\NotFoundException $e) {
} catch (Exception $e) {
    echo 'error';
}

