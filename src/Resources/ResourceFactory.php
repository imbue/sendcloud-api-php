<?php

namespace Imbue\SendCloud\Resources;

class ResourceFactory
{
    /**
     * @param                  $apiResult
     * @param AbstractResource $resource
     * @param string|null      $resourceKey
     * @return AbstractResource
     */
    public static function createFromApiResult(
        $apiResult,
        AbstractResource $resource,
        ?string $resourceKey = null
    ): AbstractResource {
        if ($resourceKey) {
            $apiResult = $apiResult->{$resourceKey};
        }

        foreach ($apiResult as $property => $value) {
            $resource->{$property} = $value;
        }

        return $resource;
    }
}
