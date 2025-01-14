<?php

namespace AdobeConnectClient\Commands;

use AdobeConnectClient\Abstracts\Command;
use AdobeConnectClient\Contracts\ArrayableInterface;
use AdobeConnectClient\Converter\Converter;
use AdobeConnectClient\Entities\SCO;
use AdobeConnectClient\Helpers\SetEntityAttributes as FillObject;
use AdobeConnectClient\Helpers\StatusValidate;

/**
 * Create a SCO.
 *
 * More info see {@link https://helpx.adobe.com/adobe-connect/webservices/sco-update.html}
 */
class ScoCreate extends Command
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @param ArrayableInterface $sco
     */
    public function __construct(ArrayableInterface $sco)
    {
        $this->parameters = [
            'action' => 'sco-update',
        ];

        $this->parameters += $sco->toArray();
    }

    /**
     * {@inheritdoc}
     *
     * @return SCO
     */
    protected function process()
    {
        // Create a SCO only in a folder
        if (isset($this->parameters['sco-id'])) {
            unset($this->parameters['sco-id']);
        }

        $response = Converter::convert(
            $this->client->doGet(
                $this->parameters + ['session' => $this->client->getSession()]
            )
        );

        StatusValidate::validate($response['status']);

        $sco = new SCO();
        FillObject::setAttributes($sco, $response['sco']);

        return $sco;
    }
}
