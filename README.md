Yii2 In app Purchase Component.

Installation
composer require "linnoxlewis/Iap-component"

Basic Configuration
Once the extension is installed, simply modify your application configuration as follows:

use linnoxlewis\iap\IapComponent;

return [
   'components' => [
         // ...
           'iap-component' => [
               'class' => IapComponent::class,
               'sandbox' => true !== YII_ENV_PROD,
               'sandboxUrl' =>'https://sandbox.itunes.apple.com/verifyReceipt',
               'buyUrl' => 'https://buy.itunes.apple.com/verifyReceipt',
               'password' => '',
           ]
    ],
]

How to Use :

  $verify = Yii::$app->get('iap-component');
  
  $verify->verify($receipt);