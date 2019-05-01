<?php
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


    return $response->withStatus(201)->withJson($result);

});


try {
    $app->run();
} catch (\Slim\Exception\MethodNotAllowedException $e) {
} catch (\Slim\Exception\NotFoundException $e) {
} catch (Exception $e) {
    echo 'error';
}

