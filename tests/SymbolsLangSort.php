<?php
namespace artem_c\langSort\test;


class SymbolsLangSort extends \artem_c\langSort\LangSort
{

    protected $_types = [
        // russian symbols
        1 => [
            'borders' => [
                [
                    'left_border' => 1040,
                    'right_border' => 1103,
                ],
                [
                    'left_border' => 65,
                    'right_border' => 90,
                ],
            ],
            'list' => [1105, 1025]
        ],
        // something else (signs, numbers...)
        3 => [],
    ];

    public function setTypes(array $array)
    {

        $this->_types = $array;
        return $this;

    }

}