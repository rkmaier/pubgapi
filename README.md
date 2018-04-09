## A PHP Wrapper for the Official PUBG Dev API

#### Installation 

` composer require rkmaier/pubgapi dev-master `

#### Laravel 5.5+ Integration
Laravel Pacakage discovery should take care of it

#### Laravel 5.* Integration

Add the service provider to your `config/app.php` file:

```php

    'providers'     => array(

        //...
        Rkmaier\Pubgapi\PubgApiService::class,

    ),
```

Add the facade to your `config/app.php` file:

```php

    'aliases'       => array(

        //...
        'PubgApi' => Rkmaier\Pubgapi\Facades\PubgApi::class,

    ),

```
#### Publish config file

`php artisan vendor:publish`

#### Edit config file

```php

return [

    'api_url'=>'https://api.playbattlegrounds.com/shards/',

    'shards' => [
        'eu' => 'pc-eu',
        'na' => 'pc-na',
    ],

    'access_token' =>'',

];

```


#### Laravel

###### Get API Status

```php
PubgApi::status()
```

###### Set Region

```php
PubgApi::region('pc-na')
```

###### Filter by Player Names

```php
PubgApi::region('pc-na')->players('shroud')->get();
```

###### Filter by Player ID

```php
PubgApi::region('pc-eu')->player('<PLAYER_ID>')->get();
```

###### Filter by Match ID

```php
PubgApi::region('pc-eu')->match('<MATCH_ID>')->get();
```

###### Pagination

```php
PubgApi::region('pc-eu')->players('<PLAYER_ID1>','<PLAYER_ID2>','','<PLAYER_ID3>')->limit(1)->offset(2)->get();
```


#### PHP without Laravel 

```php

require_once 'vendor/autoload.php'; 

$data['access_token'] = '<YOUR PUBG DEV ACCESS TOKEN>; 
$pubgAPi = new \Rkmaier\Pubgapi\PubgApiService($data); 
$pubgAPi->region('pc-eu')->players('rkmaier,molnarz,Istvan92,zuuup,Aigialeusz')->get());

```


