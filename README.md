# LangSort
Sort based on linguistic identity symbol. For example, for the location of Russian characters before English.

Сортировка с учетом языковой принадлежности символа. Например для расположения русских символов перед английскими.
# Interface
 LangSort::sort(array &$sort, $save_indexes = true) - 
 
     sort an array by reference, maintaining or not indexes depending on the parameter $ save_indexes;
     
     сортирует массив по ссылке сохраняя или нет индексы в зависимости от параметра $save_indexes;
 
 LangSort::setOrderDirection($direction) - 
 
     sets the sort direction LangSort::ASC  ||  LangSort::DESC; 
     
     устанавливает направление сортировки LangSort::ASC  ||  LangSort::DESC
 
 LangSort::setEncoding($encoding) - 
 
     sets encoding sorted string; 
     
     устанавливает кодировку сортируемой строки
 
 LangSort::setKey($key) - 
 
     sets the key by which elements will be compared when compared not strings and arrays or objects; 
 
     устанавливает ключ по которому будут сравниваться элементы если сравниваются не строки, а массивы или объекты
# Usage
An example of the sort in which the first row of the characters of the Russian alphabet them in the end English and all other symbols
It should be inherited from the base class LangSort override its properties $ _types.

 Пример сортировки в которой первыми идут символы русского алфавита за ними английского и в конце все остальные символы
 Необходимо унаследовавшись от базового класса  LangSort переопределить его свойство $_types.
 ```
 use artem_c\langSort\LangSort
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
Consider the Russian alphabet - all symbols with numbers from 1040 to 1103, inclusive, and two letters that do not fall into the gap 'ё' and 'Ё'. These are shown in the property 'list'.

The letters of the English alphabet, and there is enough to specify only the border.

And all the other characters - an empty array.

If you do not specify the type of default, all the characters to which none of the rules do not apply will be of type 0.


Рассмотрим русский алфавит - это все символы с номерами от 1040 до 1103 включительно и две буквы которые не попадают в этот промежуток 'ё' и 'Ё'. Они указаны в свойстве 'list'.

В английском алфавите таких букв нет и достаточно указать только границы.

И все остальные символы - пустой массив.

Если не указать тип по умолчанию то все символы к которым ни одно из правил не применимы будут иметь тип 0.

# Settings

So how to set types.
There are three possible options.

Итак как устанавливать типы.
Есть три варианта опций.

1 - The default type that fall under all of the characters - an empty array. Be sure to place it at the end. Since the test is performed sequentially to the first match;

Тип по умолчанию под который попадают все символы - пустой массив. Не забудьте расположить его в самом конце. Так как проверка выполняется последовательно до первого совпадения.
```
   3 => []
```  
2 - Boundaries. Property - 'borders'. There may be more. And it is not necessary to specify both the left and right borders. If necessary, you can specify only one. eg:


Границы. Свойство - 'borders'. Их может быть несколько.   И не обязательно указывать и левые и правые границы. Если необходимо можно указать только одну.
Например:
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
  
  3 - 
  list - listing of character codes.
  
  list - перечисление кодов символов.
 ```
    2 => [
      'list' => [12,13,14]
    ]
 ```   
 4 - 
 if the character has not got any of the specified type its number is 0.
 
 если символ не попал ни в один из установленных типов то его номер будет 0.
 
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
Or vice versa

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

You can specify the encoding and key the same way as sorting direction.

Также как направление сортировки можно указать и кодировку и ключ.
```
  (new RusEngLangSort())->setEncoding('WINDOWS-1251')->setKey('title')->sort($books);
  ```
