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
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_delete()
        {
            //Arrange
            $title = "History of whatever";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "History of nothing";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $test_book->delete();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([$test_book2], $result);
        }

        function test_updateTitle()
        {
            //Arrange
            $title = "History of whatever";
            $test_book = new Book($title);
            $test_book->save();

            //Act
            $new_title = "Future of him";
            $test_book->updateTitle($new_title);

            //Assert
            $result = Book::getAll();
            $this->assertEquals($new_title, $result[0]->getTitle());
        }

        function test_find()
        {
            //Arrange
            $title = "History of whatever";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "History of nothing";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $result = Book::find($test_book2->getId());

            //Assert
            $this->assertEquals($test_book2, $result);
        }

        function test_addAuthor()
        {
            //Arrange
            $title = "dog book";
            $test_book = new Book($title);
            $test_book->save();

            $name = "William Wegman";
            $test_author = new Author($name);
            $test_author->save();

            //Act
            $test_book->addAuthor($test_author);

            //Assert
            $result = $test_book->getAuthors();
            $this->assertEquals([$test_author], $result);
        }

        function test_getAuthors()
        {
            //Arrange
            $title = "dog book";
            $test_book = new Book($title);
            $test_book->save();

            $name = "William Wegman";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Bogus Dogtographer";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            //Assert
            $result = $test_book->getAuthors();
            $this->assertEquals([$test_author, $test_author2], $result);
        }




    }
?>
