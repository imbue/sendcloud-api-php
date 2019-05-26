<?php

namespace Imbue\SendCloud\Endpoints;

use Imbue\SendCloud\Exceptions\ApiException;
use Imbue\SendCloud\Resources\Collections\InvoiceCollection;
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
     * @return InvoiceCollection
     */
    protected function getResourceCollectionObject(): InvoiceCollection
    {
        return new InvoiceCollection();
    }

    /**
     * @return InvoiceCollection
     * @throws ApiException
     */
    public function list()
    {
        return $this->restList([]);
    }

    /**
     * @param $id
     * @return Invoice
     * @throws ApiException
     */
    public function get($id)
    {
        return $this->restRead($id, []);
    }
}
