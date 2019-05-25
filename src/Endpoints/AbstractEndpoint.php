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

        foreach ($filters as $key => $value) {
            if ($value === true) {
                $filters[$key] = 'true';
            }
            if ($value === false) {
                $filters[$key] = 'false';
            }
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

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * @param       $id
     * @param array $filters
     * @return AbstractResource
     * @throws ApiException
     */
    protected function restRead($id, array $filters)
    {
        if (empty($id)) {
            throw new ApiException('Invalid resource id.');
        }

        $id = urlencode($id);

        $result = $this->client->performHttpCall(
            self::REST_READ,
            "{$this->getResourcePath()}/{$id}" . $this->buildQueryString($filters)
        );

        return ResourceFactory::createFromApiResult($result, $this->getResourceObject());
    }

    /**
     * @param       $id
     * @param array $body
     * @return AbstractResource|null
     * @throws ApiException
     */
    protected function restDelete($id, array $body = [])
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
     * @return array|AbstractCollection
     * @throws ApiException
     */
    protected function restList(array $filters = [])
    {
        $apiPath = $this->getResourcePath();

        if (count($filters)) {
            $apiPath .= $this->buildQueryString($filters);
        }

        $result = $this->client->performHttpCall(self::REST_LIST, $apiPath);

        $collection = null;

        if (is_object($result)) {
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

            foreach ($result->{$collection->getCollectionResourceName()} as $dataResult) {
                $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
            }
        } else {
            foreach ($result as $dataResult) {
                $collection[] = ResourceFactory::createFromApiResult($dataResult, $this->getResourceObject());
            }
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
            $encoded = json_encode($body);
        } catch (InvalidArgumentException $e) {
            throw new ApiException("Error encoding parameters into JSON: '" . $e->getMessage() . "'");
        }

        return $encoded;
    }
}
