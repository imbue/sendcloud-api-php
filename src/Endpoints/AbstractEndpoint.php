<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\AbstractResource;
use Imbue\SendCloud\Resources\Collections\AbstractCollection;
use Imbue\SendCloud\Resources\ResourceFactory;
use Imbue\SendCloud\SendCloudApiClient;
use InvalidArgumentException;

abstract class AbstractEndpoint
{
    protected const REST_READ = SendCloudApiClient::HTTP_GET;
    protected const REST_LIST = SendCloudApiClient::HTTP_GET;
    protected const REST_CREATE = SendCloudApiClient::HTTP_POST;
    protected const REST_UPDATE = SendCloudApiClient::HTTP_PATCH;
    protected const REST_DELETE = SendCloudApiClient::HTTP_DELETE;

    /** @var SendCloudApiClient */
    protected $client;
    /** @var string */
    protected $resourcePath;
    /** @var string */
    protected $singleResourceKey;
    /** @var string */
    protected $listResourceKey;
    /** @var string */
    protected $parentId;

    /**
     * AbstractEndpoint constructor.
     * @param SendCloudApiClient $client
     */
    public function __construct(SendCloudApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $filters
     * @return string
     */
    protected function buildQueryString(array $filters)
    {
        if (empty($filters)) {
            return '';
        }

        return '?' . http_build_query($filters, '', '&');
    }

    /**
     * @param array $body
     * @return AbstractResource
     * @throws ApiException
     */
    protected function restCreate(array $body)
    {
        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath(),
            $this->parseRequestBody($body)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject(), $this->getSingleResourceKey());
    }

    /**
     * @param array $body
     * @return AbstractCollection
     * @throws ApiException
     */
    protected function restCreateCollection(array $body)
    {
        $result = $this->client->performHttpCall(
            self::REST_CREATE,
            $this->getResourcePath(),
            $this->parseRequestBody($body)
        );

        /** @var AbstractCollection $collection */
        $collection = $this->getResourceCollectionObject(
            null,
            null
        );

        if (is_object($result)) {
            $result = $result->{$collection->getCollectionResourceName()};
        }

        foreach ($result as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
        }

        return $collection;
    }

    /**
     * @param       $id
     * @param array $filters
     * @return AbstractResource
     * @throws ApiException
     */
    protected function restRead($id, array $filters): AbstractResource
    {
        if (empty($id)) {
            throw new ApiException('Invalid resource id.');
        }

        $id = urlencode($id);

        $result = $this->client->performHttpCall(
            self::REST_READ,
            "{$this->getResourcePath()}/{$id}" . $this->buildQueryString($filters)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject(), $this->getSingleResourceKey());
    }

    /**
     * @param       $id
     * @param array $body
     * @return AbstractResource|null
     * @throws ApiException
     */
    protected function restDelete($id, array $body = []): ?AbstractResource
    {
        if (empty($id)) {
            throw new ApiException('Invalid resource id.');
        }

        $id = urlencode($id);

        $result = $this->client->performHttpCall(
            self::REST_DELETE,
            "{$this->getResourcePath()}/{$id}",
            $this->parseRequestBody($body)
        );

        if ($result === null) {
            return null;
        }

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * @param array $filters
     * @return AbstractCollection
     * @throws ApiException
     */
    protected function restList(array $filters = []): AbstractCollection
    {
        $apiPath = $this->getResourcePath();

        if (count($filters)) {
            $apiPath .= $this->buildQueryString($filters);
        }

        $result = $this->client->performHttpCall(self::REST_LIST, $apiPath);

        $previous = null;
        $next = null;

        if (isset($result->previous)) {
            $previous = $result->previous;
        }

        if (isset($result->next)) {
            $next = $result->next;
        }

        /** @var AbstractCollection $collection */
        $collection = $this->getResourceCollectionObject(
            $previous,
            $next
        );

        if (is_object($result)) {
            $result = $result->{$collection->getCollectionResourceName()};
        }

        foreach ($result as $dataResult) {
            $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
        }

        return $collection;
    }

    /**
     * @return mixed
     */
    abstract protected function getResourceObject();

    /**
     * @param string $resourcePath
     */
    public function setResourcePath($resourcePath)
    {
        $this->resourcePath = strtolower($resourcePath);
    }

    /**
     * @return string
     * @throws ApiException
     */
    public function getResourcePath()
    {
        if (strpos($this->resourcePath, '/{}/') !== false) {
            list($parentResource, $childResource) = explode('/{}/', $this->resourcePath, 2);
            if (empty($this->parentId)) {
                throw new ApiException("Subresource '{$this->resourcePath}' used without parent '$parentResource' ID.");
            }
            return "$parentResource/{$this->parentId}/$childResource";
        }
        return $this->resourcePath;
    }

    /**
     * @return string
     */
    protected function getSingleResourceKey()
    {
        return $this->singleResourceKey;
    }

    /**
     * @return string
     */
    protected function getListResourceKey()
    {
        return $this->listResourceKey;
    }

    /**
     * @param array $body
     * @return null|string
     * @throws ApiException
     */
    protected function parseRequestBody(array $body)
    {
        if (empty($body)) {
            return null;
        }

        try {
            $encoded = \GuzzleHttp\json_encode($body);
        } catch (InvalidArgumentException $e) {
            throw new ApiException("Error encoding parameters into JSON: '" . $e->getMessage() . "'");
        }

        return $encoded;
    }
}
