<?php


namespace AdobeConnectClient\Commands;

use AdobeConnectClient\Abstracts\Command;
use AdobeConnectClient\Converter\Converter;
use AdobeConnectClient\Entities\SCO;
use AdobeConnectClient\Exceptions\InvalidException;
use AdobeConnectClient\Exceptions\NoAccessException;
use AdobeConnectClient\Exceptions\NoDataException;
use AdobeConnectClient\Exceptions\TooMuchDataException;
use AdobeConnectClient\Helpers\SetEntityAttributes as FillObject;
use AdobeConnectClient\Helpers\StatusValidate;

class ScoShortcuts extends Command
{
    /**
     * Request Parameters
     *
     * @var array
     */
    protected $parameters = ["action" => "sco-shortcuts"];

    /**
     * Process the command and return a value
     *
     * @return SCO[]
     * @throws InvalidException
     * @throws NoAccessException
     * @throws NoDataException
     * @throws TooMuchDataException
     */
    protected function process()
    {
        $response = Converter::convert(
            $this->client->doGet(
                $this->parameters + ['session' => $this->client->getSession()]
            )
        );

        StatusValidate::validate($response['status']);

        $shorcuts = [];
        foreach ($response['shortcuts'] as $shortcut) {
            $sco = new SCO;
            FillObject::setAttributes($sco, $shortcut);
            $shorcuts[$sco->type] = $sco;
        }
        return $shorcuts;
    }
}