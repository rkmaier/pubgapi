## A PHP Wrapper for the Official PUBG Dev API

#### Installation 

composer require rkmaier/pubgapi dev-master

``
require_once 'vendor/autoload.php';
$data['access_token'] = '<YOUR PUBG DEV ACCESS TOKEN>';
$pubgAPi = new \Rkmaier\Pubgapi\PubgApiService($data);
dd($pubgAPi->region('pc-eu')->players('rkmaier,molnarz')->get());
``
