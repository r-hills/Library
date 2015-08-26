<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Book.php";
    //require_once "src/Author.php";
    //require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            // Author::deleteAll();
            // Patron::deleteAll();
        }

        function test_getTitle()
        {
            //Arrange
            $title = "America";
            $test_book = new Book($title);

            //Act
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($title, $result);
        }

        function test_save()
        {
            //Arrange
            $title = "History of whatever";
            $test_book = new Book($title);

            //Act
            $test_book->save();

            //Assert
            $result = Book::getAll();
            $this->assertEquals($test_book, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $title = "History of whatever";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "History of nothing";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $title = "History of whatever";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "History of nothing";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $result = Book::deleteAll();

            //Assert
            $this->assertEquals([], $result);
        }
        
    }
?>
