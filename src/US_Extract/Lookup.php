<?php

namespace SmartyStreets\PhpSdk\US_Extract;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 *     @see "https://smartystreets.com/docs/cloud/us-extract-api#http-request-input-fields"
 */
class Lookup {
    private $result,
            $html,
            $aggressive,
            $addressesHaveLineBreaks,
            $addressPerLine,
            $text;

    /**
     * @param text The text that is to have addresses extracted out of it for verification
     */
    public function __construct($text = null) {
        $this->result = new Result();
        $this->aggressive = false;
        $this->addressesHaveLineBreaks = true;
        $this->addressPerLine = 0;
        $this->text = $text;
    }

    //region [ Getters ]

    public function getResult() {
        return $this->result;
    }

    public function isHtml() {
        return $this->html;
    }

    public function isAggressive() {
        return $this->aggressive;
    }

    public function addressesHaveLineBreaks() {
        return $this->addressesHaveLineBreaks;
    }

    public function getAddressesPerLine() {
        return $this->addressPerLine;
    }

    public function getText() {
        return $this->text;
    }

    //endregion

    //region [ Setters ]

    public function setResult(Result $result) {
        $this->result = $result;
    }

    public function setHtml($html) {
//        $this->html = ArrayUtil::getEncodedValue($html);
        $this->html = strval($html);// TODO: what type of value is it getting? (string value) 'true' 'false' or boolean value?
    }

    public function setAggressive($aggressive) {
        $this->aggressive = $aggressive;
    }

    public function setAddressesHaveLineBreaks($addressesHaveLineBreaks) {
        $this->addressesHaveLineBreaks = $addressesHaveLineBreaks;
    }

    public function setAddressPerLine($addressPerLine) {
        $this->addressPerLine = $addressPerLine;
    }

    public function setText($text) {
        $this->text = $text;
    }

    //endregion
}