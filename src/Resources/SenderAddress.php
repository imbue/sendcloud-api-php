<?php

namespace Imbue\SendCloud\Resources;

class SenderAddress extends AbstractResource
{
    /** @var int */
    public $id;
    /** @var string */
    public $company_name;
    /** @var string */
    public $contact_name;
    /** @var string */
    public $email;
    /** @var string */
    public $telephone;
    /** @var string */
    public $street;
    /** @var string */
    public $house_number;
    /** @var string */
    public $postal_box;
    /** @var string */
    public $postal_code;
    /** @var string */
    public $city;
    /** @var string */
    public $country;
}
