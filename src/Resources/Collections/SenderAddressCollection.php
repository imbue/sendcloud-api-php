<?php

namespace Imbue\SendCloud\Resources\Collections;

use Imbue\SendCloud\Resources\SenderAddress;

class SenderAddressCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'sender_addresses';
    }

    /**
     * @return SenderAddress
     */
    protected function createResourceObject(): SenderAddress
    {
        return new SenderAddress($this->client);
    }
}
