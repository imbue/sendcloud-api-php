<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\Label;

class LabelEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'labels';

    /**
     * @return Label
     */
    protected function getResourceObject(): Label
    {
        return new Label($this->client);
    }

    /**
     * @param $parcelId
     * @return Label
     * @throws ApiException
     */
    public function get($parcelId)
    {
        return $this->restRead($parcelId, []);
    }

    /**
     * @param array $data
     * @return Label
     * @throws ApiException
     */
    public function print(array $data)
    {
        return $this->restCreate($data);
    }

    /**
     * @param        $parcelId
     * @param string $printer
     * @return mixed|null
     * @throws ApiException
     */
    public function getLabelAsPdf($parcelId, string $printer)
    {
        $id = urlencode($parcelId);

        $result = $this->client->performHttpCall(
            self::REST_READ,
            "{$this->getResourcePath()}/{$printer}/{$id}"
        );

        return $result;
    }
}
