<?php

namespace Imbue\SendCloud\Resources;

class User extends AbstractResource
{
    /** @var string */
    public $username;
    /** @var string */
    public $email;
    /** @var string */
    public $company_name;
    /** @var string */
    public $address;
    /** @var string */
    public $city;
    /** @var string */
    public $postal_code;
    /** @var string */
    public $company_logo;
    /** @var string */
    public $telephone;
    /** @var array */
    public $data;
    /** @var string */
    public $registered;
    /** @var array */
    public $modules;
    /** @var array */
    public $invoices;
}
