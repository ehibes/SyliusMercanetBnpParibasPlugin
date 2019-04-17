![Waaz](https://bitbag.pl/static/bitbag-logo.png)


## Overview

This plugin enables using Mercanet BNP Paribas payments in Sylius based stores.

## Support

We work on amazing eCommerce projects on top of Sylius and Pimcore. Need some help or additional resources for a project?
Write us an email on developpement@studiowaaz.com or visit [our website](https://www.studiowaaz.com/)! :rocket:

## Demo

We created a demo app with some useful use-cases of the plugin! Visit [demo.www.studiowaaz.com](https://demo.www.studiowaaz.com) to take a look at it. 
The admin can be accessed under [demo.www.studiowaaz.com/admin](https://demo.www.studiowaaz.com/admin) link and `sylius: sylius` credentials.

## Installation
```bash
$ composer require waaz/system-pay-plugin
```
    
Add plugin dependencies to your AppKernel.php file:
```php
public function registerBundles()
{
    return array_merge(parent::registerBundles(), [
        ...
        
        new \Waaz\SystemPayPlugin\WaazSystemPayPlugin(),
    ]);
}
```

## Usage

Go to the payment methods in your admin panel. Now you should be able to add new payment method for Mercanet BNP Paribas gateway.

## Testing
```bash
$ wget http://getcomposer.org/composer.phar
$ php composer.phar install
$ yarn install
$ yarn run gulp
$ php bin/console sylius:install --env test
$ php bin/console server:start --env test
$ open http://localhost:8000
$ bin/behat features/*
$ bin/phpspec run
```

## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/.
