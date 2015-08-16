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
 ```
class RusEngLangSort extends LangSort
{

    protected $_types = [
        // russian symbols
        1 => [
            'borders' => [
                [
                    'left_border' => 1040,
                    'right_border' => 1103,
                ],
            ],
            'list' => [1105, 1025]
        ],
        // english symbols
        2 => [
            'borders' => [
                [
                    'left_border' => 65,
                    'right_border' => 90,
                ],
            ],
        ],
        // something else (signs, numbers...)
        3 => [],
    ];

}
 
```
Рассмотрим русский алфавит - это все символы с номерами от 1040 до 1103 включительно и две буквы которые не попадают в этот промежуток ё и Ё. Они указаны в свойстве 'list'.

В английском алфавите таких букв нет и достаточно указать только границы.

И все остальные символы - пустой массив.

Если не указать тип по умолчанию то все символы к которым ни одно из правил не применимы будут иметь тип 0.

Итак как устанавливать типы.
Есть три варианта опций.
1 - Тип по умолчанию под который попадают все символы - пустой массив. Не забудьте расположить его в самом конце. Так как проверка выполняется последовательно до первого совпадения.

2 - Границы. Свойство - 'borders'. Их может быть несколько. например
```
        1 => [
            'borders' => [
                [
                    'left_border' => 1040,
                    'right_border' => 1103,
                ],
                [
                    'left_border' => 1120,
                ]
            ],
        ],
    
  ```
  И не обязательно указывать и левые и правые границы. Если необходимо можно указать только одну.
  
  3 - list - перечисление кодов символов.
# Example
```
        $books = [
            'Преступление и наказание',
            'Ёж english version',
            'Ёж русская версия',
            'The Little Lady of the Big House',
            'Путешествия Гулливера',
            '102 способа хищения электроэнергии',
            'Обыкновеннае чудо',
            'Adventures of Huckleberry Finn',
            'Медведь и бабочка',
            'Actions and Reactions',
            'Медведь',
            '"Устные" рассказы',
        ];
        (new RusEngLangSort())->sort($books, false);
        $result = [
            'Ёж русская версия',
            'Ёж english version',
            'Медведь',
            'Медведь и бабочка',
            'Обыкновеннае чудо',
            'Преступление и наказание',
            'Путешествия Гулливера',
            'Actions and Reactions',
            'Adventures of Huckleberry Finn',
            'The Little Lady of the Big House',
            '"Устные" рассказы',
            '102 способа хищения электроэнергии',
        ];

```

Или в обратном направлении
```
          $books = [
            'Преступление и наказание',
            'Ёж english version',
            'Ёж русская версия',
            'The Little Lady of the Big House',
            'Путешествия Гулливера',
            '102 способа хищения электроэнергии',
            'Обыкновеннае чудо',
            'Adventures of Huckleberry Finn',
            'Медведь и бабочка',
            'Actions and Reactions',
            'Медведь',
            '"Устные" рассказы',
        ];
        (new RusEngLangSort())->setOrderDirection(RusEngLangSort::DESC)->sort($books, false);
        $result = [
            '102 способа хищения электроэнергии',
            '"Устные" рассказы',
            'The Little Lady of the Big House',
            'Adventures of Huckleberry Finn',
            'Actions and Reactions',
            'Путешествия Гулливера',
            'Преступление и наказание',
            'Обыкновеннае чудо',
            'Медведь и бабочка',
            'Медведь',
            'Ёж english version',
            'Ёж русская версия',
        ];
        
```

Также как направление сортировки можно указать и кодировку и ключ.
```
  (new RusEngLangSort())->setEncoding('WINDOWS-1251')->setKey('title')->sort($books);
  ```
