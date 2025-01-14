<?php

namespace AdobeConnectClient\Commands;

use AdobeConnectClient\Abstracts\Command;
use AdobeConnectClient\Converter\Converter;
use AdobeConnectClient\Entities\Principal;
use AdobeConnectClient\Helpers\SetEntityAttributes as FillObject;
use AdobeConnectClient\Helpers\StatusValidate;

/**
 * Provides information about one principal, either a user or a group.
 *
 * More info see {@link https://helpx.adobe.com/adobe-connect/webservices/principal-info.html}
 */
class PrincipalInfo extends Command
{
    /**
     * @var int
     */
    protected $principalId;

    /**
     * @param int $principalId
     */
    public function __construct($principalId)
    {
        $this->principalId = (int) $principalId;
    }

    /**
     * {@inheritdoc}
     *
     * @return Principal
     */
    protected function process()
    {
        $response = Converter::convert(
            $this->client->doGet([
                'action'       => 'principal-info',
                'principal-id' => $this->principalId,
                'session'      => $this->client->getSession(),
            ])
        );

        StatusValidate::validate($response['status']);

        $principal = new Principal();
        FillObject::setAttributes($principal, $response['principal']);

        return $principal;
    }
}
