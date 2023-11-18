<?php

namespace Imbue\SendCloud;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Imbue\SendCloud\Endpoints\IntegrationEndpoint;
use Imbue\SendCloud\Endpoints\IntegrationShipmentEndpoint;
use Imbue\SendCloud\Endpoints\InvoiceEndpoint;
use Imbue\SendCloud\Endpoints\LabelEndpoint;
use Imbue\SendCloud\Endpoints\ParcelEndpoint;
use Imbue\SendCloud\Endpoints\ParcelMultiEndpoint;
use Imbue\SendCloud\Endpoints\ParcelStatusEndpoint;
use Imbue\SendCloud\Endpoints\SenderAddressEndpoint;
use Imbue\SendCloud\Endpoints\ShippingMethodEndpoint;
use Imbue\SendCloud\Endpoints\ShippingProductsEndpoint;
use Imbue\SendCloud\Endpoints\UserEndpoint;
use Imbue\SendCloud\Exceptions\ApiException;
use Psr\Http\Message\ResponseInterface;

class SendCloudApiClient
{
    public const CLIENT_VERSION = '1.1.0';
    public const API_ENDPOINT = 'https://panel.sendcloud.sc/api';
    public const API_VERSION = 'v2';

    public const HTTP_GET = 'GET';
    public const HTTP_POST = 'POST';
    public const HTTP_DELETE = 'DELETE';
    public const HTTP_PATCH = 'PATCH';

    private const CONTENT_TYPE_JSON = 'application/json';
    private const CONTENT_TYPE_PDF = 'application/pdf';

    /** @var int */
    private const TIMEOUT = 10;
    /** @var int */
    private const HTTP_NO_CONTENT = 204;

    /** @var ClientInterface */
    protected $httpClient;
    /** @var string */
    protected $apiEndpoint = self::API_ENDPOINT;
    /** @var array */
    private $versionStrings;

    /** @var string */
    private $apiKey;
    /** @var string */
    private $apiSecret;
    /** @var string */
    private $partnerId;

    /** @var ParcelEndpoint */
    public $parcels;
    /** @var ParcelMultiEndpoint */
    public $parcelsMulti;
    /** @var ParcelStatusEndpoint */
    public $parcelStatuses;
    /** @var ShippingMethodEndpoint */
    public $shippingMethods;
    /** @var ShippingProductsEndpoint */
    public $shippingProducts;
    /** @var LabelEndpoint */
    public $labels;
    /** @var InvoiceEndpoint */
    public $invoices;
    /** @var UserEndpoint */
    public $user;
    /** @var IntegrationEndpoint */
    public $integrations;
    /** @var IntegrationShipmentEndpoint */
    public $integrationShipments;
    /** @var SenderAddressEndpoint */
    public $senderAddresses;

    /**
     * SendCloudApiClient constructor.
     * @param ClientInterface|null $httpClient
     */
    public function __construct(ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?
            $httpClient :
            new Client([
                RequestOptions::TIMEOUT => self::TIMEOUT,
            ]);

        $this->initializeEndpoints();

        $this->addVersionString('SendCloud/' . self::CLIENT_VERSION);
        $this->addVersionString('PHP/' . phpversion());
    }

    /**
     * @return void
     */
    public function initializeEndpoints()
    {
        $this->parcels = new ParcelEndpoint($this);
        $this->parcelsMulti = new ParcelMultiEndpoint($this);
        $this->parcelStatuses = new ParcelStatusEndpoint($this);
        $this->shippingMethods = new ShippingMethodEndpoint($this);
        $this->shippingProducts = new ShippingProductsEndpoint($this);
        $this->senderAddresses = new SenderAddressEndpoint($this);
        $this->labels = new LabelEndpoint($this);
        $this->invoices = new InvoiceEndpoint($this);
        $this->user = new UserEndpoint($this);
        $this->integrations = new IntegrationEndpoint($this);
        $this->integrationShipments = new IntegrationShipmentEndpoint($this);
    }

    /**
     * @return string
     */
    public function getApiEndpoint(): string
    {
        return $this->apiEndpoint;
    }

    /**
     * @param string $apiKey
     * @param string $apiSecret
     */
    public function setApiAuth(string $apiKey, string $apiSecret): void
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * @param string $partnerId
     */
    public function setPartnerId(string $partnerId): void
    {
        $this->partnerId = $partnerId;
    }

    /**
     * @param $versionString
     * @return $this
     */
    private function addVersionString($versionString)
    {
        $this->versionStrings[] = str_replace([" ", "\t", "\n", "\r"], '-', $versionString);
        return $this;
    }

    /**
     * @param      $httpMethod
     * @param      $apiMethod
     * @param null $httpBody
     * @return mixed|null
     * @throws ApiException
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null)
    {
        $url = $this->apiEndpoint . '/' . self::API_VERSION . '/' . $apiMethod;
        return $this->performHttpCallToFullUrl($httpMethod, $url, $httpBody);
    }

    /**
     * @param      $httpMethod
     * @param      $url
     * @param null $httpBody
     * @return mixed|null
     * @throws ApiException
     */
    public function performHttpCallToFullUrl($httpMethod, $url, $httpBody = null)
    {
        if (!$this->apiKey || !$this->apiSecret) {
            throw new ApiException('You have not set an API key or API secret.');
        }

        $userAgent = implode(' ', $this->versionStrings);

        $headers = [
            'Accept' => self::CONTENT_TYPE_JSON,
            'Content-Type' => self::CONTENT_TYPE_JSON,
            'Authorization' => "Basic {$this->getBasicToken()}",
            'User-Agent' => $userAgent,
        ];

        if ($this->partnerId) {
            $headers['Sendcloud-Partner-Id'] = $this->partnerId;
        }

        if (function_exists('php_uname')) {
            $headers['X-SendCloud-Client-Info'] = php_uname();
        }

        $request = new Request($httpMethod, $url, $headers, $httpBody);

        try {
            $response = $this->httpClient->send($request, ['http_errors' => false]);
        } catch (GuzzleException $e) {
            throw ApiException::createFromGuzzleException($e);
        }

        if (!$response) {
            throw new ApiException('Did not receive API response.');
        }

        return $this->parseResponseBody($response);
    }

    /**
     * @param ResponseInterface $response
     * @return mixed|null
     * @throws ApiException
     */
    private function parseResponseBody(ResponseInterface $response)
    {
        $body = (string)$response->getBody();

        if (empty($body)) {
            if ($response->getStatusCode() === self::HTTP_NO_CONTENT) {
                return null;
            }

            throw new ApiException('No response body found.');
        }

        if ($this->getContentTypeFromResponse($response) === self::CONTENT_TYPE_PDF) {
            return $body;
        }

        $object = @json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException("Unable to decode response: '{$body}'.");
        }

        if ($response->getStatusCode() >= 400) {
            throw ApiException::createFromResponse($response);
        }

        return $object;
    }

    /**
     * @return string
     */
    private function getBasicToken(): string
    {
        return base64_encode("{$this->apiKey}:{$this->apiSecret}");
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    private function getContentTypeFromResponse(ResponseInterface $response)
    {
        return $response->getHeaderLine('Content-Type');
    }
}
