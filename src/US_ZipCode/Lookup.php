<?php

namespace SmartyStreets\PhpSdk\US_ZipCode;

require_once('Result.php');

class Lookup implements \JsonSerializable {
    //region [ Fields ]

    private $result,
            $inputId,
            $city,
            $state,
            $zipcode;

    //endregion

    //region [ Constructors ]

    public function __construct($city = null, $state = null, $zipcode = null) {
        $this->result = new Result();
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
    }

    //endregion

    public function jsonSerialize()
    {
        return array(
            'input_id' => $this->inputId,
            'city' => $this->city,
            'state' => $this->state,
            'zipcode' => $this->zipcode
        );
    }

    //region [ Getters ]

    public function getResult() {
        return $this->result;
    }

    public function getInputId() {
        return $this->inputId;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getZipCode() {
        return $this->zipcode;
    }

    //endregion

    //region [ Setters ]

    public function setResult(Result $result) {
        $this->result = $result;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function setZipCode($zipcode) {
        $this->zipcode = $zipcode;
    }

    public function setInputId($inputId) {
        $this->inputId = $inputId;
        return $this;
    }
    //endregion
}