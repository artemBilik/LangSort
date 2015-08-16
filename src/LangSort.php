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
     */
    public function setOrderDirection($direction)
    {

        $this->_order_direction = $direction;
        return $this;

    }

    /**
     * @param $encoding
     * @return $this
     */
    public function setEncoding($encoding)
    {

        $this->_encoding = $encoding;
        return $this;

    }

    private function compare($a, $b)
    {

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

    private function getSymbolType($symbol)
    {

        $code = $this->getSymbolCode($symbol);
        foreach($this->_types as $key => $value){
            if(array_key_exists('list', $value) && is_array($value['list']) && in_array($code, $value['list'])){
                return $key;
            }
            if(array_key_exists('left_border', $value) && $code < $value['left_border']){
                continue;
            }
            if(array_key_exists('right_border', $value) && $code > $value['right_border']){
                continue;
            }

            return $key;
        }

    }

    private function getSymbolCode($symbol)
    {

        // encode symbol into 4 bytes encoding
        $symbol = mb_convert_encoding($symbol,"UCS-4BE",$this->_encoding);
        $ord = unpack("N", $symbol);

        return $ord[1];

    }

}