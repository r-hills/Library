<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    //require_once "src/Book.php";
    require_once "src/Author.php";
    //require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            // Book::deleteAll();
            Author::deleteAll();
            // Patron::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Dan Brown";
            $test_author = new Author($name);

            //Act
            $result = $test_author->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

    }

?>
