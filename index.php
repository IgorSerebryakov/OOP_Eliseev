<?php
// День первый: Философия ООП

/* $a -> [ 5 ] -- храниться в памяти
 * $b -> [ 7 ] -- храниться в памяти
 * 
 * $b = $a; -- копия по значению
 * 
 * $a -> [ 5 ]
 * $b -> [ 5 ]
 * 
 * $a = 10;
 * 
 * $a -> [ 10 ]
 * $b -> [ 5 ]
 * ----------------------------------------------
 * 
 * $a = 5;
 * $b = 7;
 * 
 * Перем     Ссылка       Значение
 * $a        ->           [ 5 ]
 * $b        ->           [ 7 ]
 * 
 * $b = &$a; -- копия по ссылке
 * 
 * $a -> [ 5 ]
 * $b / -- скопировали ссылку
 * 
 * $b = 10;
 * echo $a; // 10
 * 
 * -----------------------------------------------
 * $array = [1, 2, 3];
 * 
 * foreach ($array as $key => $value) {
 *      $value = $value * 2; 
 * }
 * 
 * print_r($array); // [1, 2, 3] -- значения массива не изменятся, так как в foreach происходит копирование по значению
 * 
 * 
 * -----------------------------------------------
 * 
 * foreach ($array as $key => &$value) {
 *      $value = $value * 2; 
 * }
 * 
 * print_r($array); // [2, 4, 6] -- значения массива изменятся, так как в foreach происходит копирование по ссылке
 * 
 * -----------------------------------------------
 * 
 * $a = new Student(); -- конструкция "new" в памяти создала объект и вернула указатель @ на него, а переменная ссылается на этот указатель
 * 
 * $a   ->   [ @ ]                @  ->  { Student#1 }
 * 
 * $a ссылается на область памяти, в которой хранится @ (указатель)
 * 
 * $b = $a;
 * 
 * $a   ->   [ @ ]                @  ->  { Student#1 }
 * $b   ->   [ @ ]                   /
 * 
 * $b = &$a;
 * 
 * $a   ->   [ @ ]                @  ->  { Student#1 }
 * $b   /
 * 
 * $b = 7;
 * 
 * $a   ->   [ @ ]                @  ->  { Student#1 }
 * $b   ->   [ 7 ]
 * 
 * $a = 5;
 * 
 * $a   ->   [ 5 ]                       { Student#1 } -- остаётся в памяти, но на него ничто не ссылается
 * $b   ->   [ 7 ]
 * 
 */



// День второй. Что такое классы, работа с классами.

/* Типизация определяет, что с переменными можно делать.
 * 
 * class Student -- заготовка для создания объектов, $student = new Student(); -- экземпляр(объект) класса
 * 
 */

const STUDENT_TYPE_OCHN = 1;
const STUDENT_TYPE_ZAOCHN = 2;

class Student
{
    const STUDENT_TYPE_OCHN = 1; // можно явно добавлять в классы
    const STUDENT_TYPE_ZAOCHN = 2;
    private $firstName; // недоступное поле извне
    private $lastName; // недоступное поле извне
    public $birthDate; // поле, доступное извне
    private $type;
    
    public function __construct($firstName, $lastName) // Автоматический метод, который срабатывает при создании объекта
    {
        $this->lastName = $lastName; // $this показывает на текущий объект
        $this->firstName = $firstName;
        $this->type = Student::STUDENT_TYPE_OCHN; // Присвоение константы объекту (можно использовать в любом методе) [можно self вместо student]
    }
    
    public static function createOchn($lastName, $firstName) // Фабричный метод, который создаёт экземпляр класса
    {
        return new self($lastName, $firstName, self::STUDENT_TYPE_OCHN);
    }

    public static function createZaochn($lastName, $firstName) // Фабричный метод, который создаёт экземпляр класса
    {
        return new self($lastName, $firstName, self::STUDENT_TYPE_ZAOCHN);
    }
    
    public function __toString() // Приводит значение объекта к строке
    {
        return '123';
    }

    public function __call($name, $args) // $name - имя несуществующего метода, $args - массив, аргументы, в который мы передаём в этом методе
    {
        echo 'Call' . $name . PHP_EOL;
        print_r($args);
    }
    
    public function __invoke() // Срабатывает, когда пытаемся вызвать объект как функцию
    {
        echo 'Invoke';
    }
    
    public function __get($name)
    {
        return $name . PHP_EOL;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    
    public function getFullName()
    {
        return $this->lastName . ' ' . $this->firstName;
    }
    
    public function rename($lastName, $firstName)
    {
        $this->lastName = $lastName;
        $this->firstName = $firstName;
    }
    
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    public function getLastName()
    {
        return $this->lastName;
    }
}

$student = new Student('Vasya', 'Pupkin');

// $student->firstName = 'Vasya'; -- ошибка (обращение к приватному свойству)
// $student->lastName = 'Pupkin'; -- ошибка (обращение к приватному свойству)


echo Student::STUDENT_TYPE_OCHN . PHP_EOL; // :: - обращение к константе класса (их нет в объекте)
$student1 = Student::createOchn('Pasha', 'Markov'); // Экземпляр класса, созданный статическим конструктором 
$student2 = Student::createZaochn('Kirill', 'Markov'); // Экземпляр класса, созданный статическим конструктором 
print_r($student1);

/* Если в методе не используется $this и он должен быть глобальным, то можно (нужно) его делать статическим.
 * В статическом методе нет $this и не можем там использовать
 * 
 * 
 * 
 */