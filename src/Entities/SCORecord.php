<?php

namespace AdobeConnectClient\Entities;

use AdobeConnectClient\Helpers\ValueTransform as VT;
use AdobeConnectClient\Traits\PropertyCaller;
use AdobeConnectClient\Traits\Setter;
use DateInterval;
use DateTimeImmutable;
use Exception;
use InvalidArgumentException;

/**
 * The recording archive from a SCO
 *
 * @property int|string|mixed $sco_id
 * @property int|string|mixed $source_sco_id
 * @property int|string|mixed $folder_id
 * @property int|string|mixed $display_seq
 * @property int|string|mixed $job_id
 * @property int|string|mixed $account_id
 * @property int|string|mixed $encoder_service_job_progress
 * @property int|string|mixed $no_of_downloads
 * @property int|string|mixed $file_name
 * @property string|mixed $type
 * @property string|mixed $icon
 * @property string|mixed $job_status
 * @property string|mixed $name
 * @property string|mixed $url_path
 * @property bool|string|mixed $is_folder
 * @property DateTimeImmutable|mixed $date_begin
 * @property DateTimeImmutable|mixed $date_end
 * @property DateTimeImmutable|mixed $date_created
 * @property DateTimeImmutable|mixed $date_modified
 * @property DateInterval|mixed $duration
 */
class SCORecord
{
    use Setter, PropertyCaller;

    /**
     * Set if is Folder
     *
     * @param bool $isFolder
     * @return void
     */
    public function setIsFolder($isFolder)
    {
        $this->attributes["isFolder"] = VT::toBool($isFolder);
    }

    /**
     * Set the Begin date
     *
     * @param string|DateTimeImmutable $dateBegin
     * @throws Exception
     */
    public function setDateBegin($dateBegin)
    {
        $this->attributes["dateBegin"] = VT::toDateTimeImmutable($dateBegin);
    }

    /**
     * Set the End date
     *
     * @param string|DateTimeImmutable $dateEnd
     * @throws Exception
     */
    public function setDateEnd($dateEnd)
    {
        $this->attributes["dateEnd"] = VT::toDateTimeImmutable($dateEnd);
    }

    /**
     * Set the Created date
     *
     * @param string|DateTimeImmutable $dateCreated
     * @throws Exception
     */
    public function setDateCreated($dateCreated)
    {
        $this->attributes["dateCreated"] = VT::toDateTimeImmutable($dateCreated);
    }

    /**
     * Set the Modified date
     *
     * @param string|DateTimeImmutable $dateModified
     * @throws Exception
     */
    public function setDateModified($dateModified)
    {
        $this->attributes["dateModified"] = VT::toDateTimeImmutable($dateModified);
    }

    /**
     * Set the Duration
     *
     * @param DateInterval|string $duration String in format hh:mm:ss
     * @throws InvalidArgumentException
     */
    public function setDuration($duration)
    {
        if (is_string($duration)) {
            $duration = $this->timeStringToDateInterval($duration);
        }
        $this->attributes["duration"] = $duration;
    }

    /**
     * Converts the time duration string into a \DateInterval
     *
     * @param string $timeString A string like hh:mm:ss
     * @return DateInterval
     * @throws InvalidArgumentException
     */
    protected function timeStringToDateInterval($timeString)
    {
        try {
            return new DateInterval(
                preg_replace(
                    '/(\d{2}):(\d{2}):(\d{2}).*/',
                    'PT$1H$2M$3S',
                    $timeString
                )
            );
        } catch (Exception $e) {
            throw new InvalidArgumentException('Timestring is not a valid interval');
        }
    }
}
