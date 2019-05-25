<?php

namespace Imbue\SendCloud\Resources\Collections;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\AbstractResource;
use Imbue\SendCloud\Resources\ResourceFactory;
use Imbue\SendCloud\SendCloudApiClient;

abstract class CursorCollection extends AbstractCollection
{
    /** @var SendCloudApiClient */
    protected $client;

    /**
     * CursorCollection constructor.
     * @param SendCloudApiClient $client
     * @param                    $previous
     * @param                    $next
     */
    final public function __construct(SendCloudApiClient $client, $previous, $next)
    {
        parent::__construct($previous, $next);
        $this->client = $client;
    }

    /**
     * @return AbstractResource
     */
    abstract protected function createResourceObject();

    /**
     * @return array|CursorCollection|null
     * @throws ApiException
     */
    final public function next()
    {
        if (!$this->hasNext()) {
            return null;
        }

        $result = $this->client->performHttpCallToFullUrl(SendCloudApiClient::HTTP_GET, $this->next);

        $collection = new static($this->client, $result->previous, $result->next);

        foreach ($result->{$collection->getCollectionResourceName()} as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->createResourceObject());
        }

        return $collection;
    }

    /**
     * @return array|CursorCollection|null
     * @throws ApiException
     */
    final public function previous()
    {
        if (!$this->hasPrevious()) {
            return null;
        }

        $result = $this->client->performHttpCallToFullUrl(SendCloudApiClient::HTTP_GET, $this->previous);

        $collection = new static($this->client, $result->previous, $result->next);

        foreach ($result->{$collection->getCollectionResourceName()} as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->createResourceObject());
        }

        return $collection;
    }

    /**
     * @return bool
     */
    public function hasNext(): bool
    {
        return isset($this->next) && $this->next;
    }

    /**
     * @return bool
     */
    public function hasPrevious(): bool
    {
        return isset($this->previous) && $this->previous;
    }
}
