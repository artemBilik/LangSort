# LangSort
Сортировка с учетом языковой принадлежности символа. Например для расположения русских символов перед английскими.
# Interface
 LangSort::sort(array &$sort, $save_indexes = true) - сортирует массив по ссылке сохраняя индексы в зависимости от параметра $save_indexes
 
 LangSort::setOrderDirection($direction) - устанавливает направление сортировки LangSort::ASC  ||  LangSort::DESC
 
 LangSort::setEncoding($encoding) - устанавливает кодировку сортируемой строки
 
 LangSort::setKey($key) - устанавливает ключ по которому будут сравниваться элементы если сравниваются не строки, а массивы или объекты
 # Usage
 Пример ./src/RusEngLangSort.php
 Необходимо унаследовавшись от базового класса  LangSort переопределить его свойство $_types.
 `
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
 
 `
