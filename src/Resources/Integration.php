<?php

namespace Imbue\SendCloud\Resources;

class Integration extends AbstractResource
{
    /** @var int */
    public $id;
    /** @var string */
    public $shop_name;
    /** @var string */
    public $shop_url;
    /** @var string */
    public $system;
    /** @var string */
    public $failing_since;
    /** @var string */
    public $last_updated_at;
    /** @var bool */
    public $service_point_enabled;
    /** @var array */
    public $service_point_carriers;
    /** @var bool */
    public $webhook_active;
    /** @var string */
    public $webhook_url;
    /** @var string */
    public $last_fetch;
}
