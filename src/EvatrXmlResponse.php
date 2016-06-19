<?php

namespace Codedge\Evatr;

use Carbon\Carbon;

class EvatrXmlResponse
{
    /**
     * @var \SimpleXMLElement
     */
    private $xml;

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
    private $responseCompanyName = '';

    /**
     * @var string
     */
    private $street = '';

    /**
     * @var string
     */
    private $responseStreet = '';

    /**
     * @var string
     */
    private $city = '';

    /**
     * @var string
     */
    private $responseCity = '';

    /**
     * @var string
     */
    private $zipCode = '';

    /**
     * @var string
     */
    private $responseZipCode = '';

    /**
     * @var bool
     */
    private $printConfirmation = false;

    /**
     * @var Carbon
     */
    private $date;

    /**
     * @var Carbon
     */
    private $time;

    /**
     * @var Carbon
     */
    private $validFrom;

    /**
     * @var Carbon
     */
    private $validUntil;

    /**
     * @var int
     */
    private $errorCode = 0;

    /**
     * @var string
     */
    private $errorMessage = '';

    public function __construct($xml)
    {
        $this->xml = new \SimpleXMLElement($xml);
        $this->process();
    }

    public function process()
    {
        foreach ($this->xml->children() as $child) {
            if ($child->count() === 0) {
                continue;
            }

            $key = $child->value->array->data->value[0]->string->__toString();
            $value = $child->value->array->data->value[1]->string->__toString();

            switch ($key) {
                case 'UstId_1':
                    $this->ownUstId = (string) $value;
                    break;
                case 'UstId_2':
                    $this->foreignUstId = $value;
                    break;
                case 'Firmenname':
                    $this->companyName = $value;
                    break;
                case 'Erg_Name':
                    $this->responseCompanyName = $value;
                    break;
                case 'Strasse':
                    $this->street = $value;
                    break;
                case 'Erg_Str':
                    $this->responseStreet = $value;
                    break;
                case 'Ort':
                    $this->city = $value;
                    break;
                case 'Erg_Ort':
                    $this->responseCity = $value;
                    break;
                case 'PLZ':
                    $this->zipCode = $value;
                    break;
                case 'Erg_PLZ':
                    $this->responseZipCode = $value;
                    break;
                case 'Datum':
                    $arr = $this->_getDateTimeArray($value);
                    $this->date = Carbon::createFromDate($arr[2], $arr[1], $arr[0]);
                    break;
                case 'Uhrzeit':
                    $arr = $this->_getDateTimeArray($value, ':');
                    $this->time = Carbon::createFromTime($arr[0], $arr[1], $arr[2]);
                    break;
                case 'Gueltig_ab':
                    $arr = $this->_getDateTimeArray($value);
                    $this->validFrom = Carbon::createFromDate($arr[2], $arr[1], $arr[0]);
                    break;
                case 'Gueltig_bis':
                    $arr = $this->_getDateTimeArray($value);
                    $this->validUntil = Carbon::createFromDate($arr[2], $arr[1], $arr[0]);
                    break;
                case 'Druck':
                    $this->printConfirmation = $this->_getPrintConfirmationOption($value);
                    break;
                case 'ErrorCode':
                    $this->errorCode = (int) $value;
                    break;
            }
        }

        $this->_setErrorMessage((string) $this->errorCode);
    }

    /**
     * @return string
     */
    public function getOwnUstId()
    {
        return $this->ownUstId;
    }

    /**
     * @return string
     */
    public function getForeignUstId()
    {
        return $this->foreignUstId;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @return string
     */
    public function getResponseCompanyName()
    {
        return $this->responseCompanyName;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getResponseStreet()
    {
        return $this->responseStreet;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getResponseCity()
    {
        return $this->responseCity;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function getResponseZipCode()
    {
        return $this->responseZipCode;
    }

    /**
     * @return bool
     */
    public function isPrintConfirmation()
    {
        return $this->printConfirmation;
    }

    /**
     * @return Carbon
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return Carbon
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return Carbon
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * @return Carbon
     */
    public function getValidUntil()
    {
        return $this->validUntil;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Splits a German date or a German time format depending on the delimiter.
     *
     * Example:
     *   Date(dd.mm.yyyy): 31.03.2016
     *   Time(hh:mm:ss): 10:55:13
     *
     * @param string $string
     * @param string $delim
     *
     * @return array
     */
    private function _getDateTimeArray($string = '', $delim = '.')
    {
        $arr = [
            null, null, null,
        ];

        if (! empty($string)) {
            $arr = preg_split('/\\'.$delim.'/', $string);
        }

        return $arr;
    }

    /**
     * Returns the "translated" and converted valued for a confirmation/official confirmation.
     *
     * @param string $option
     *
     * @return bool
     */
    private function _getPrintConfirmationOption($option)
    {
        return $option == 'ja' ? true : false;
    }

    /**
     * Set the correct error message depending on the error code.
     *
     * @param string $errorCode
     */
    private function _setErrorMessage($errorCode = '')
    {
        $this->errorMessage = trans('evatr::messages.'.$errorCode);
    }
}