<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\AbstractResource;
use Imbue\SendCloud\Resources\ResourceFactory;
use Imbue\SendCloud\Resources\User;

class UserEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'user';
    /** @var string */
    protected $singleResourceKey = 'user';

    /**
     * @return User
     */
    protected function getResourceObject(): User
    {
        return new User($this->client);
    }

    /**
     * @return AbstractResource
     * @throws ApiException
     */
    public function get()
    {
        $result = $this->client->performHttpCall(
            self::REST_READ,
            $this->getResourcePath()
        );
        return ResourceFactory::createFromApiResult($result, $this->getResourceObject(), $this->getSingleResourceKey());
    }
}
