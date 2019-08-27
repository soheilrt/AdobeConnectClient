<?php

namespace AdobeConnectClient\Entities;

use AdobeConnectClient\Helpers\ValueTransform as VT;
use AdobeConnectClient\Traits\PropertyCaller;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;

/**
 * Result for Common Info Action
 *
 * @property string|mixed $local
 * @property int|string $timeZoneId Time Zone ID list in {@link https://helpx.adobe.com/adobe-connect/webservices/common-xml-elements-attributes.html#time_zone_id}
 * @property string|mixed $cookie
 * @property string|mixed $host
 * @property string|mixed $localHost
 * @property int|string|mixed $accountId
 * @property string|mixed $version
 * @property string|mixed $url
 * @property DateTimeImmutable|string|mixed $date
 * @property string|mixed $adminHost
 *
 */
class CommonInfo
{
    use PropertyCaller;

    /**
     * Set the Date
     *
     * @param DateTimeInterface|string $date
     * @return CommonInfo
     * @throws Exception
     */
    public function setDate($date)
    {
        $this->attributes["date"]= VT::toDateTimeImmutable($date);
        return $this;
    }
}
