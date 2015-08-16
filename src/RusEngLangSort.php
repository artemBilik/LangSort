<?php
namespace artem_c\langSort;


class RusEngLangSort extends LangSort
{

    protected $_types = [
        // russian symbols
        1 => [
            'left_border' => 1040,
            'right_border' => 1103,
            'list' => [1105, 1025]
        ],
        // english symbols
        2 => [
            'left_border' => 65,
            'right_border' => 90,
        ],
        // something else (signs, numbers...)
        3 => [],
    ];

}