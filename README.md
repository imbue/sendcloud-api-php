<h1 align="center">SendCloud API client for PHP</h1>

<img src="https://i.imgur.com/8M1YeVx.png" />

[![Build Status](https://travis-ci.org/imbue/sendcloud-api-php.svg?branch=master)](https://travis-ci.org/imbue/sendcloud-api-php)
[![Latest Stable Version](https://poser.pugx.org/imbue/sendcloud-api-php/v/stable)](https://packagist.org/packages/imbue/sendcloud-api-php)
[![Downloads](https://img.shields.io/packagist/dt/imbue/sendcloud-api-php.svg)]
(https://packagist.org/packages/imbue/sendcloud-api-php)

> Note that this library does not yet implement the complete functionality of the SendCloud API. Feel free to open a merge request with the additional implementation.

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
$parcel = $sendCloud->parcels->create([
    'parcel' => [
        'name' => 'Julie Appleseed',
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
    ]
]);
```

Insert or update (upsert) shipment for an integration

```php
$shipment = $sendCloud->integrationShipments->upsert(1346, [
    'name' => 'Julie Appleseed',
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

Retrieve a list of integrations

```php
$sendCloud->integrations->list();
```

Retrieve a single parcel
```php
$sendCloud->parcels->get($id);
```

##### Partner ID

If you are a partner of SendCloud, you can set the `partner id`. The library will ensure it will be added as header to the request.

```php
$sendCloud->setPartnerId('3dd88a04-26e4-4959-af11-f5674491573e')
```


## List of available methods

### Integrations
- List

### Integration Shipments
- List
- Upsert (Update or create)

### Invoices
- List
- Find

### Parcels
- Get
- List
- Create

### Parcel statuses
- List

### Sender addresses
- Get
- List

### Shipping methods
- Get
- List

### User
- Get


## Roadmap

- Implement all possible endpoints
- Add PHPUnit tests


## Want to help improving the library?

I will happily accept new [pull requests](https://github.com/imbue/sendcloud-api-php/pulls).
