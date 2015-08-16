<?php
namespace artem_c\langSort\test;

use artem_c\langSort\RusEngLangSort;

require_once __DIR__ . '/../src/LangSort.php';
require_once __DIR__ . '/../src/RusEngLangSort.php';

class LangSortTest extends \PHPUnit_Framework_TestCase
{

    public function testGlobalIndexesFalse()
    {

        $books = $this->getBooks();
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

        $this->assertTrue($result === $books);

    }

    public function testGlobalIndexesTrue()
    {

        $books = $this->getBooks();

        (new RusEngLangSort())->sort($books, true);
        $result = [
            2 => 'Ёж русская версия',
            1 => 'Ёж english version',
            10 => 'Медведь',
            8 => 'Медведь и бабочка',
            6 => 'Обыкновеннае чудо',
            0 => 'Преступление и наказание',
            4 => 'Путешествия Гулливера',
            9 => 'Actions and Reactions',
            7 => 'Adventures of Huckleberry Finn',
            3 => 'The Little Lady of the Big House',
            11 => '"Устные" рассказы',
            5 => '102 способа хищения электроэнергии',
        ];

        $this->assertTrue($result === $books);

    }

    public function testGlobalDescDirection()
    {

        $books = $this->getBooks();
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
        $this->assertTrue($result === $books);

    }

    public function testGlobalEncoding()
    {

        $books = $this->getBooks();
        foreach($books as $key => $book){
            $books[$key] = mb_convert_encoding($book, 'WINDOWS-1251', 'UTF-8');
        }

        (new RusEngLangSort())->setEncoding('WINDOWS-1251')->sort($books, true);
        $result = [
            2 => 'Ёж русская версия',
            1 => 'Ёж english version',
            10 => 'Медведь',
            8 => 'Медведь и бабочка',
            6 => 'Обыкновеннае чудо',
            0 => 'Преступление и наказание',
            4 => 'Путешествия Гулливера',
            9 => 'Actions and Reactions',
            7 => 'Adventures of Huckleberry Finn',
            3 => 'The Little Lady of the Big House',
            11 => '"Устные" рассказы',
            5 => '102 способа хищения электроэнергии',
        ];
        foreach($result as $key => $book){
            $result[$key] = mb_convert_encoding($book, 'WINDOWS-1251', 'UTF-8');
        }

        $this->assertTrue($result === $books);

    }

    public function testGlobalObjectKey()
    {

        $books = $this->getBooks();
        foreach($books as $k => $book){
            $books[$k] = new \stdClass();
            $books[$k]->title = $book;
        }
        $result = [
            2 => $books[2],
            1 => $books[1],
            10 => $books[10],
            8 => $books[8],
            6 => $books[6],
            0 => $books[0],
            4 => $books[4],
            9 => $books[9],
            7 => $books[7],
            3 => $books[3],
            11 => $books[11],
            5 => $books[5],
        ];
        (new RusEngLangSort())->setKey('title')->sort($books, true);

        $this->assertTrue($result === $books);
    }

    public function testGlobalArrayKey()
    {

        $books = $this->getBooks();
        foreach($books as $k => $book){
            if($k % 2 === 0){
                $books[$k] = new \stdClass();
                $books[$k]->title = $book;
            } else {
                $books[$k] = ['title' => $book];
            }
        }
        $result = [
            2 => $books[2],
            1 => $books[1],
            10 => $books[10],
            8 => $books[8],
            6 => $books[6],
            0 => $books[0],
            4 => $books[4],
            9 => $books[9],
            7 => $books[7],
            3 => $books[3],
            11 => $books[11],
            5 => $books[5],
        ];
        (new RusEngLangSort())->setKey('title')->sort($books, true);

        $this->assertTrue($result === $books);
    }

    protected function getBooks()
    {

        return [
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

    }

}