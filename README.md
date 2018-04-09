## A PHP Wrapper for the Official PUBG Dev API

#### Installation 

` composer require rkmaier/pubgapi dev-master `



#### Getting Started

```php

require_once 'vendor/autoload.php'; 

$data['access_token'] = '<YOUR PUBG DEV ACCESS TOKEN>; 
$pubgAPi = new \Rkmaier\Pubgapi\PubgApiService($data); 
$pubgAPi->region('pc-eu')->players('rkmaier,molnarz')->get());

```
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

