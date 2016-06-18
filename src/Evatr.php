<?php namespace Codedge\Evatr;

use PhpXmlRpc\Client;
use PhpXmlRpc\Request;
use PhpXmlRpc\Response;

class Evatr
{
    /**
     * Evatr connection url for the XML RPC
     */
    const EVATRINTERFACEURL = 'https://evatr.bff-online.de';

    /**
     * @var string
     */
    private $ownUstId = '';

    /**
     * @var string
     */
    private $foreignUstId = '';

    /**
     * @var string
     */
    private $companyName = '';

    /**
     * @var string
     */
    private $street = '';

    /**
     * @var string
     */
    private $city = '';

    /**
     * @var string
     */
    private $zipCode = '';

    /**
     * @var bool
     */
    private $printConfirmation = false;

    /**
     * @var array
     */
    private $printOptions = [
        'ja'    => true,
        'nein'  => false,
    ];

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var EvatrXmlResponse
     */
    private $xmlResponse;

    /**
     * Evatr constructor.
     */
    public function __construct()
    {
        $this->client = new Client(self::EVATRINTERFACEURL);
    }

    /**
     * @param string $ustId
     * @return $this
     */
    public function setOwnUstId($ustId)
    {
        $this->ownUstId = $ustId;
        return $this;
    }

    /**
     * @param string $ustId
     * @return $this
     */
    public function setUstId1($ustId)
    {
        $this->setOwnUstId($ustId);
        return $this;
    }

    /**
     * @param string $ustId
     * @return $this
     */
    public function setForeignUstId($ustId)
    {
        $this->foreignUstId = $ustId;
        return $this;
    }

    public function setUstId2($ustId)
    {
        $this->setForeignUstId($ustId);
        return $this;
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @param string $zipCode
     * @return $this
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @param bool $printConfirmation
     * @return $this
     */
    public function setPrintConfirmation(bool $printConfirmation)
    {
        $this->printConfirmation = $printConfirmation;
        return $this;
    }

    public function query()
    {
        $this->response = $this->client->send(new Request(
            'evatrRPC',
            [
                $this->ownUstId,
                $this->foreignUstId,
                $this->companyName,
                $this->city,
                $this->zipCode,
                $this->street,
                $this->printConfirmation
            ]
        ));

        $this->_processResponse();
    }

    /**
     * @return EvatrXmlResponse
     */
    public function getResponse()
    {
        return $this->xmlResponse;
    }

    /**
     * @return Response
     */
    public function getPlainResponse()
    {
        return $this->response;
    }

    private function _processResponse()
    {
        $this->xmlResponse = new EvatrXmlResponse($this->response->value()->me['string']);
    }
    
}