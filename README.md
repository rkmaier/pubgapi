# A PHP Wrapper for the Official PUBG Dev API
[![Total Downloads](https://poser.pugx.org/rkmaier/pubgapi/downloads)](https://packagist.org/packages/rkmaier/pubgapi)
[![License](https://poser.pugx.org/rkmaier/pubgapi/license)](https://packagist.org/packages/rkmaier/pubgapi)

## Installation 

` composer require rkmaier/pubgapi `

### Laravel 5.5+ Integration
Laravel Pacakage discovery should take care of it

### Laravel 5.* Integration

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
    'region' => 'pc-eu',
    'access_token' =>'',

];

```


### Laravel

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

###### Get Player Info

```php
PubgApi::region('pc-eu')->player('<PLAYER_ID>')->get();
```
```php
PubgApi::region('pc-eu')->player('<PLAYER_NAME')->get();
```
###### Get Seasons

```php
PubgApi::region('pc-eu')->seasons()->get();
```

###### Get Player Stats

```php
PubgApi::region('pc-eu')->playerStats('<PLAYER_NAME')->get;
```



```php
PubgApi::region('pc-eu')->playerStats('<PLAYER_NAME')->get(); // Current Season by default 
```

```php
PubgApi::region('pc-eu')->playerStats('<PLAYER_NAME','SEASON_ID')->get;
```

```php
PubgApi::region('pc-eu')->playerStats('<PLAYER_NAME')->stat('duo-fpp');
```

```php
PubgApi::region('pc-eu')->playerStats('<PLAYER_NAME','<SEASON_ID>')->stat('duo-fpp');
```

###### Get Player Match IDs

```php
PubgApi::region('pc-eu')->player('<PLAYER_NAME')->matches();
```


###### Filter by Match ID

```php
PubgApi::region('pc-eu')->match('<MATCH_ID>')->get();
```

###### Pagination

```php
PubgApi::region('pc-eu')->players('<PLAYER_ID1>','<PLAYER_ID2>','<PLAYER_ID3>')->limit(1)->offset(2)->get();
```


### PHP without Laravel 

```php

require_once 'vendor/autoload.php'; 

$data['access_token'] = '<YOUR PUBG DEV ACCESS TOKEN>'; 
$pubgAPi = new \Rkmaier\Pubgapi\PubgApiService($data); 
$pubgAPi->region('pc-eu')->players('rkmaier,molnarz,Istvan92,zuuup,Aigialeusz')->get());

```


## License

Pubgapi is licensed under the [MIT License](http://opensource.org/licenses/MIT).

Copyright 2018 Erik Maier

