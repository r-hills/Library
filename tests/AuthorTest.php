<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    //require_once "src/Author.php";
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
            // Author::deleteAll();
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

        function test_save()
        {
            //Arrange
            $name = "Bob";
            $test_author = new Author($name);

            //Act
            $test_author->save();

            //Assert
            $result = Author::getAll();
            $this->assertEquals($test_author, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Bob";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Rob";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Bob";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Billy Bob";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            Author::deleteAll();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_delete()
        {
            //Arrange
            $name = "Bob";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Billy Bob";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $test_author->delete();

            //Assert
            $result = Author::getAll();
            $this->assertEquals([$test_author2], $result);
        }

        function test_update()
        {
            //Arrange
            $name = "Bob";
            $test_author = new Author($name);
            $test_author->save();

            //Act
            $new_name = "Billy Bobby";
            $test_author->updateName($new_name);

            //Assert
            $result = Author::getAll();
            $this->assertEquals($new_name, $result[0]->getName());
        }

        function test_find()
        {
            //Arrange
            $name = "Bob";
            $test_author = new Author($name);
            $test_author->save();

            //Act
            $result = Author::find($test_author->getId());

            //Assert
            $this->assertEquals($test_author, $result);
        }

        function test_addBook()
        {
            //Arrange
            $name = "Bob";
            $test_author = new Author($name);
            $test_author->save();

            $title = "dog book";
            $test_book = new Book($title);
            $test_book->save();

            //Act
            $test_author->addBook($test_book);

            //Assert
            $result = $test_author->getBooks();
            $this->assertEquals([$test_book], $result);

        }

        function test_getBooks()
        {
            //Arrange
            //Arrange
            $name = "Bob";
            $test_author = new Author($name);
            $test_author->save();

            $title = "dog book";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "History of nothing";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);

            //Assert
            $result = $test_author->getBooks();
            $this->assertEquals([$test_book, $test_book2], $result);
        }







    }

?>
