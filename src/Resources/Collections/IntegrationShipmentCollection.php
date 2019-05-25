<?php

namespace Imbue\SendCloud\Resources\Collections;

use Imbue\SendCloud\Resources\IntegrationShipment;

class IntegrationShipmentCollection extends CursorCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'results';
    }

    /**
     * @return IntegrationShipment
     */
    protected function createResourceObject(): IntegrationShipment
    {
        return new IntegrationShipment($this->client);
    }
}
