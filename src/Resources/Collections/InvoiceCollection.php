<?php

namespace Imbue\SendCloud\Resources\Collections;

use Imbue\SendCloud\Resources\Invoice;

class InvoiceCollection extends AbstractCollection
{
    /**
     * @return string
     */
    public function getCollectionResourceName()
    {
        return 'invoices';
    }

    /**
     * @return Invoice
     */
    protected function createResourceObject(): Invoice
    {
        return new Invoice($this->client);
    }
}
