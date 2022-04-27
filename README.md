# Heuréka.cz/sk for Shopaholic plugin for OctoberCMS

This plugin sends 'Heuréka Ověřeno' conversion for your Shopaholic Orders.

Tested and developed with OctoberCMS v1.1.9 (Laravel 6.0).

## Settings

In Backend Settings area just fill Secret key for CZ and/or SK service.

## How it works

Conversion is automatically sent after order is created. Both Czech and Slovak version of Heuréka Ověřeno is supported.

Czech conversion is sent for orders with *billing_country* property set to 'cz'. Slovak with country 'sk'. Skipped when empty API key for related country.

As unique product identifier is used Offer EAN (external_id) parameter. Same parameter should be used in Heuréka XML feed. Products counts is limited to 40.

## Contributing

Please send Pull Request to the master branch.

Icon made by Vectors Market from www.flaticon.com.
