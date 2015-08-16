<?php
namespace artem_c\langSort;


class LangSort
{

    const ASC  =  1;
    const DESC = -1;

    protected $_types = [
        1 => []
    ];

    private $_order_direction = 1;
    private $_encoding        = 'UTF-8';
    private $_key             = null;

    /**
     * @param array &$sort
     * @param bool $save_indexes
     * @return bool
     */
    public function sort(array &$sort, $save_indexes = true)
    {

        if($save_indexes){
            return uasort($sort, [$this, 'compare']);
        } else {
            return usort($sort, [$this, 'compare']);
        }

    }

    /**
     * @param $direction
     * @return $this
     * @throws LangSortException
     */
    public function setOrderDirection($direction)
    {

        if($direction !== self::ASC && $direction !== self::DESC){
            throw new LangSortException('setOrderDirection() - $direction must be a LangSort::ASC || LangSort::DESC.');
        }
        $this->_order_direction = $direction;
        return $this;

    }

    /**
     * @param $encoding
     * @return $this
     * @throws LangSortException
     */
    public function setEncoding($encoding)
    {

        if(!is_string($encoding)){
            throw new LangSortException('setEncoding() - $encoding must be a string.');
        }
        $this->_encoding = $encoding;
        return $this;

    }

    /**
     * @param $key
     * @return $this
     * @throws LangSortException
     */
    public function setKey($key)
    {

        if(!is_string($key)){
            throw new LangSortException('setKey() - $key must be a string.');
        }
        $this->_key = $key;
        return $this;

    }

    private function compare($a, $b)
    {

        $a = $this->getValue($a);
        $b = $this->getValue($b);
        // find minimum length
        $a_length   = mb_strlen($a, $this->_encoding);
        $b_length   = mb_strlen($b, $this->_encoding);
        $min_length = (($a_length < $b_length) ? $a_length : $b_length) - 1;
        // compare
        for($i = 0; $i < $min_length; ++$i){
            $a_symbol = mb_substr($a, $i, 1, $this->_encoding);
            $b_symbol = mb_substr($b, $i, 1, $this->_encoding);
            // if symbols identical -> compare next symbols
            if($a_symbol === $b_symbol){
                continue;
            }
            // find types of the symbols
            $a_type = $this->getSymbolType($a_symbol);
            $b_type = $this->getSymbolType($b_symbol);
            // if types identical -> compare symbols
            if($a_type === $b_type){
                return ($a_symbol > $b_symbol) ? $this->_order_direction : -1 * $this->_order_direction;
            }
            // if types is not identical ->  compare types
            return ($a_type > $b_type) ? $this->_order_direction : -1 * $this->_order_direction;
        }
        // if part of string in minimum length identical
        if($a_length === $b_length){
            return 0;
        }
        return ($a_length > $b_length) ? $this->_order_direction : -1 * $this->_order_direction;

    }

    private function getValue($element)
    {

        if(!is_string($this->_key)){
            return $element;
        }
        if(is_object($element)){
            return $element->{$this->_key};
        }
        if(is_array($element)){
            return $element[$this->_key];
        }
        return $element;

    }

    private function getSymbolType($symbol)
    {

        $code = $this->getSymbolCode($symbol);
        foreach($this->_types as $key => $value){
            if(empty($value)){
                return $key;
            }
            if(array_key_exists('list', $value) && is_array($value['list']) && in_array($code, $value['list'])){
                return $key;
            }
            if(array_key_exists('borders', $value) && is_array($value['borders'])){
                foreach($value['borders'] as $border){
                    $l_border = $r_border = true;
                    if(array_key_exists('left_border', $border) && $code < $border['left_border']){
                        $l_border = false;
                    }
                    if(array_key_exists('right_border', $border) && $code > $border['right_border']){
                        $r_border = false;
                    }
                    if($l_border && $r_border){
                        return $key;
                    }
                }
            }
        }
        return 0;

    }

    public function getSymbolCode($symbol)
    {

        // encode symbol into 4 bytes encoding
        $symbol = mb_convert_encoding($symbol,"UCS-4BE",$this->_encoding);
        $ord = unpack("N", $symbol);

        return $ord[1];

    }

}

class LangSortException extends \Exception
{}