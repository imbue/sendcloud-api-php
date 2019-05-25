<?php

namespace Imbue\SendCloud\Resources;

class IntegrationShipment extends AbstractResource
{
    /** @var string */
    public $order_number;
    /** @var int */
    public $integration;
    /** @var string */
    public $external_order_id;
    /** @var string */
    public $external_shipment_id;
    /** @var string */
    public $address;
    /** @var string */
    /** @var string */
    public $house_number;
    public $address_2;
    /** @var string */
    public $city;
    /** @var string */
    public $company_name;
    /** @var string */
    public $country;
    /** @var string */
    public $email;
    /** @var string */
    public $name;
    /** @var string */
    public $postal_code;
    /** @var string */
    public $to_service_point;
    /** @var string */
    public $telephone;
    /** @var string */
    public $weight;
    /** @var string */
    public $to_state;
    /** @var string */
    public $customs_invoice_nr;
    /** @var string */
    public $customs_shipment_type;
    /** @var array */
    public $parcel_items;
    /** @var string */
    public $shipment_uuid;
    /** @var int */
    public $shipping_method;
    /** @var array */
    public $allowed_shipping_methods;
    /** @var string */
    public $barcode;
    /** @var string */
    public $currency;
    /** @var object */
    public $order_status;
    /** @var object */
    public $payment_status;
    /** @var int */
    public $sender_address;
    /** @var string */
    public $shipping_method_checkout_name;
    /** @var string */
    public $to_post_number;
    /** @var object */
    public $errors;
    /** @var string */
    public $created_at;
    /** @var */
    public $updated_at;
}
