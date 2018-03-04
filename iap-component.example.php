<?php

use linnoxlewis\iap\IapComponent;

return [
    'class' => IapComponent::class,
    'sandbox' => true !== YII_ENV_PROD,
    'sandboxUrl' =>'https://sandbox.itunes.apple.com/verifyReceipt',
    'buyUrl' => 'https://buy.itunes.apple.com/verifyReceipt',
    'password' => '',
];
