<?php

namespace AdobeConnectClient\Converter;

use AdobeConnectClient\Connection\ResponseInterface;
use InvalidArgumentException;

interface ConverterInterface
{
    /**
     * Converts the data into an associative array with camelCase keys
     *
     * Example:
     *     [
     *         'status' => [
     *             'code' => 'invalid',
     *             'invalid' => [
     *                 'field' => 'login',
     *                 'type' => 'string',
     *                 'subcode' => 'missing',
     *             ],
     *         ],
     *         'common' => [
     *             'zoneId' => 3,
     *             'locale' => '',
     *         ],
     *     ];
     *
     * @param ResponseInterface $response
     * @return array
     * @throws InvalidArgumentException if data is invalid
     */
    public static function convert(ResponseInterface $response);
}
