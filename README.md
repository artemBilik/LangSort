# LangSort
Сортировка с учетом языковой принадлежности символа. Например для расположения русских символов перед английскими.
# Interface
 LangSort::sort(array &$sort, $save_indexes = true) - сортирует массив по ссылке сохраняя индексы в зависимости от параметра $save_indexes
 
 LangSort::setOrderDirection($direction) - устанавливает направление сортировки LangSort::ASC  ||  LangSort::DESC
 
 LangSort::setEncoding($encoding) - устанавливает кодировку сортируемой строки
 
 LangSort::setKey($key) - устанавливает ключ по которому будут сравниваться элементы если сравниваются не строки, а массивы или объекты
