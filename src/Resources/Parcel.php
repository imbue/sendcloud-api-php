<?php

namespace Imbue\SendCloud\Resources;

class Parcel extends AbstractResource
{
    /** @var string */
    public $id;
    /** @var string */
    public $address;
    /** @var string */
    public $address_2;
    /** @var object */
    public $address_divided;
    /** @var string */
    public $city;
    /** @var string */
    public $company_name;
    /** @var object */
    public $country;
    /** @var object */
    public $data;
    /** @var string */
    public $date_created;
    /** @var string */
    public $email;
    /** @var string */
    public $name;
    /** @var string */
    public $postal_code;
    /** @var string */
    public $reference;
    /** @var object */
    public $shipment;
    /** @var object */
    public $status;
    /** @var string */
    public $to_service_point;
    /** @var string */
    public $telephone;
    /** @var string */
    public $tracking_number;
    /** @var string */
    public $weight;
    /** @var object */
    public $label;
    /** @var object */
    public $customs_declaration;
    /** @var string */
    public $order_number;
    /** @var int */
    public $insured_value;
    /** @var int */
    public $total_insured_value;
    /** @var string */
    public $to_state;
    /** @var string */
    public $customs_invoice_nr;
    /** @var string */
    public $customs_shipment_type;
    /** @var array */
    public $parcel_items;
    /** @var string */
    public $type;
    /** @var string */
    public $shipment_uuid;
    /** @var int */
    public $shipping_method;
    /** @var string */
    public $external_order_id;
    /** @var string */
    public $external_shipment_id;
    /** @var bool */
    public $is_return;
    /** @var object */
    public $carrier;
    /** @var string */
    public $tracking_url;
    /** @var string */
    public $country_state;
}
