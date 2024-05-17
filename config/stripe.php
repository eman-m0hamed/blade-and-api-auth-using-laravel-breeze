<?php
return [
    'api_key' =>[
        'secret' => env('STRIPE_SECRET_KEY'),
        'publish' => env('STRIPE_PUBLISH_KEY')
    ]
]
?>
