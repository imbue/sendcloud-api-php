<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\Collections\AbstractCollection;
use Imbue\SendCloud\Resources\Invoice;

class InvoiceEndpoint extends AbstractEndpoint
{
    /** @var string */
    protected $resourcePath = 'user/invoices';

    /**
     * @return Invoice
     */
    protected function getResourceObject(): Invoice
    {
        return new Invoice($this->client);
    }

    /**
     * @return array|AbstractCollection
     * @throws ApiException
     */
    public function list()
    {
        return $this->restList([]);
    }

    /**
     * @return array|AbstractCollection
     * @throws ApiException
     */
    public function get()
    {
        return $this->restList([]);
    }
}
