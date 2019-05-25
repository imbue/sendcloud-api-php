<?php

namespace Imbue\SendCloud\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Response;
use Throwable;

class ApiException extends Exception
{
    /** @var string */
    protected $field;
    /** @var Response */
    protected $response;

    /**
     * ApiException constructor.
     * @param string         $message
     * @param int            $code
     * @param null           $field
     * @param Response|null  $response
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = '',
        $code = 0,
        $field = null,
        Response $response = null,
        Throwable $previous = null
    ) {
        if (!empty($field)) {
            $this->field = (string)$field;
            $message .= '. Field: {$this->field}';
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @param                $guzzleException
     * @param Throwable|null $previous
     * @return ApiException
     * @throws ApiException
     */
    public static function createFromGuzzleException($guzzleException, Throwable $previous = null)
    {
        // Not all Guzzle Exceptions implement hasResponse() / getResponse()
        if (method_exists($guzzleException, 'hasResponse') && method_exists($guzzleException, 'getResponse')) {
            if ($guzzleException->hasResponse()) {
                return static::createFromResponse($guzzleException->getResponse());
            }
        }

        return new static($guzzleException->getMessage(), $guzzleException->getCode(), null, $previous);
    }

    /**
     * @param                $response
     * @param Throwable|null $previous
     * @return ApiException
     * @throws ApiException
     */
    public static function createFromResponse($response, Throwable $previous = null)
    {
        $object = static::parseResponseBody($response);
        $field = null;

        if (!empty($object->field)) {
            $field = $object->field;
        }

        return new static(
            "Error executing API call {$object->error->request}: {$object->error->message} ({$object->error->code})",
            $response->getStatusCode(),
            $field,
            $response,
            $previous
        );
    }

    /**
     * @return string|null
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return bool
     */
    public function hasResponse()
    {
        return $this->response !== null;
    }

    /**
     * @param $response
     * @return mixed
     * @throws ApiException
     */
    protected static function parseResponseBody($response)
    {
        $body = (string)$response->getBody();
        $object = @json_decode($body);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new static("Unable to decode response: '{$body}'");
        }

        return $object;
    }
}

