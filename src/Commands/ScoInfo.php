<?php

namespace AdobeConnectClient\Commands;

use AdobeConnectClient\Abstracts\Command;
use AdobeConnectClient\Converter\Converter;
use AdobeConnectClient\Entities\SCO;
use AdobeConnectClient\Helpers\SetEntityAttributes as FillObject;
use AdobeConnectClient\Helpers\StatusValidate;

/**
 * Gets the Sco info.
 *
 * More info see {@link https://helpx.adobe.com/adobe-connect/webservices/sco-info.html}
 */
class ScoInfo extends Command
{
    /**
     * @var int
     */
    protected $scoId;

    /**
     * @param int $scoId
     */
    public function __construct($scoId)
    {
        $this->scoId = intval($scoId);
    }

    /**
     * {@inheritdoc}
     *
     * @return SCO
     */
    protected function process()
    {
        $response = Converter::convert(
            $this->client->doGet([
                'action'  => 'sco-info',
                'sco-id'  => $this->scoId,
                'session' => $this->client->getSession(),
            ])
        );
        StatusValidate::validate($response['status']);
        $sco = new SCO();
        FillObject::setAttributes($sco, $response['sco']);

        return $sco;
    }
}
