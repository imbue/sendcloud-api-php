<h1 align="center">SendCloud API client for PHP</h1>

<img src="https://i.imgur.com/kEZU7HH.png" />

## Installation

```
$ composer require imbue/sendcloud-api-php:^0.1

{
    "require": {
        "imbue/sendcloud-api-php": "^0.1"
    }
}
```

## Getting started

Initialize the SendCloud API client

```php
$sendCloud = new \Imbue\SendCloud\SendCloudApiClient();
$sendCloud->setApiAuth('gb3iogpp8uf74p92holav67ij7jmpswe', '1m9mtv4ylnd8fy0xb61ury81pt6xp3fh');
```

Creating a new parcel

```php
$payment = $sendcloud->parcels->create([
    'name'  => 'Julie Appleseed',
    'company_name' => 'SendCloud',
    'address' => 'Insulindelaan 115',
    'house_number' => 115,
    'city' => 'Eindhoven',
    'postal_code' => '5642CV',
    'telephone' => '+31612345678',
    'request_label' => true,
    'email' => 'julie@appleseed.com',
    'country' => 'NL',
    'shipment' => [
        'id' => 8,
    ],
    'weight' => '10.000',
    'order_number' => '1234567890',
    'insured_value' => 2000,
]);
```
