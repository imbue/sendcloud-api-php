<?php

namespace Imbue\SendCloud\Resources;

use Imbue\SendCloud\SendCloudApiClient;

abstract class AbstractResource
{
    /** @var SendCloudApiClient */
    protected $client;

    /**
     * @param $client
     */
    public function __construct(SendCloudApiClient $client)
    {
        $this->client = $client;
    }
}
