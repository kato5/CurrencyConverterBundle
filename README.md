# CurrencyConverterBundle

Installation
1. composer install

2. In config/bundles.php add to others bundles

Kato\CurrencyConverterBundle\KatoCurrencyConverterBundle::class => ['all' => true]

3. In config/routes.yaml add new routes

kato_cc:

    resource: "@KatoCurrencyConverterBundle/Controller"
    type:     annotation
