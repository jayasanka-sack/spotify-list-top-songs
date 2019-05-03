# List Users Top Spotify songs

## Demo

http://142.93.213.121/spotify

<img src="https://i.ibb.co/N1D1VYp/Screen-Shot-2019-05-02-at-08-01-35.png" alt="Screen-Shot-2019-05-02-at-08-01-35" border="0"><br/><br/>
<img src="https://i.ibb.co/Db4FwLQ/Screen-Shot-2019-05-02-at-07-58-50.png" alt="Screen-Shot-2019-05-02-at-07-58-50" border="0">

## Step 1:

Clone this repo.
Open terminal and type 

```
composer install
```

## Step 2:

Create your spotify app from here: <br/>
https://developer.spotify.com/dashboard/applications<br/>

## Step 3:

get client ID and client secret from dashboard
<img src="https://i.imgur.com/kSxt6kr.png" border="0"><br/><br/>

## Step 4:

Add your client secret to ***/api/v1/config.config.json*** file
```
{
  "spotify": {
    "clientSecret" : "YOUR_CLIENT_SECRET"
  }
}
```
## Step 5:

Add your following details to ***config/config.json*** file
```
{
  "spotify": {
    "clientId": "YOUR_CLIENT_ID"
  },
  "server": {
    "url" : "PATH_TO _YOUR_APPLICATION ex: http://localhost/spotify",
    "api" : "/api/v1"
  }
}
```

## Step 6:

Click edit settings button on your spotify application,

add a Redirect URI with your server address followed by /api/v1/get-token

ex: http://localhost/spotify/api/v1/get-token

<img src="https://imgur.com/TYNij7T.jpg" border="0"><br/><br/>


## Troubleshooting

If your local api is not working, Check whether url rewriting is enabled on ur apache server:

follow this tutorial:
https://hostadvice.com/how-to/how-to-enable-apache-mod_rewrite-on-an-ubuntu-18-04-vps-or-dedicated-server/
