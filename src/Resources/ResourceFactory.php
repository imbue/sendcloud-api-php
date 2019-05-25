<?php

namespace Imbue\SendCloud\Resources;

use Imbue\SendCloud\SendCloudApiClient;

class ResourceFactory
{
    /**
     * @param                  $apiResult
     * @param AbstractResource $resource
     * @return AbstractResource
     */
    public static function createFromApiResult($apiResult, AbstractResource $resource)
    {
        foreach ($apiResult as $property => $value) {
            $resource->{$property} = $value;
        }
        return $resource;
    }

    /**
     * @param SendCloudApiClient $client
     * @param array              $input
     * @param                    $resourceClass
     * @param null               $resourceCollectionClass
     * @return array
     */
    public static function createBaseResourceCollection(
        SendCloudApiClient $client,
        array $input,
        $resourceClass,
        $resourceCollectionClass = null
    ) {
        if ($resourceCollectionClass === null) {
            $resourceCollectionClass = $resourceClass . 'Collection';
        }

        $data = new $resourceCollectionClass();

        foreach ($input as $item) {
            $data[] = static::createFromApiResult($item, new $resourceClass($client));
        }

        return $data;
    }

    /**
     * @param SendCloudApiClient $client
     * @param array              $input
     * @param                    $resourceClass
     * @param null               $previous
     * @param null               $next
     * @param null               $resourceCollectionClass
     * @return array
     */
    public static function createCursorResourceCollection(
        SendCloudApiClient $client,
        array $input,
        $resourceClass,
        $previous = null,
        $next = null,
        $resourceCollectionClass = null
    ) {
        if ($resourceCollectionClass === null) {
            $resourceCollectionClass = $resourceClass . 'Collection';
        }
        $data = new $resourceCollectionClass($client, $previous, $next);

        foreach ($input as $item) {
            $data[] = static::createFromApiResult($item, new $resourceClass($client));
        }

        return $data;
    }
}
