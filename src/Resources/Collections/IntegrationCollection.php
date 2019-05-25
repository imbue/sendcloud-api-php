<?php

namespace Imbue\SendCloud\Resources\Collections;

use Imbue\SendCloud\Resources\Integration;

class IntegrationCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'integrations';
    }

    /**
     * @return Integration
     */
    protected function createResourceObject(): Integration
    {
        return new Integration($this->client);
    }
}
