<?php

    class Book
    {
        private $title;
        private $id;

        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }


        // Getters and Setters
        function setTitle ($new_title)
        {
            $this->title = $new_title;
        }

        function getTitle ()
        {
            return $this->title;
        }

        function getId ()
        {
            return $this->id;
        }




        // Basic database storage methods
        function save ()
        {
            try {
                $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES (
                    '{$this->getTitle()}'
                    );");
                $this->id = $GLOBALS['DB']->lastInsertId();
            } catch (PDOException $e) {
                echo "Error in Book save function: " . $e->getMessage();
            }
        }

        function delete ()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authorships WHERE book_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM copies WHERE book_id = {$this->getId()};");
        }

        function updateTitle ($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title = '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
        }



        // Methods involving other tables
        function getAuthors ()
        {

        }

        function addAuthor ($new_author)
        {

        }

        function getCopies ()
        {

        }

        function addCopy ()
        {

        }



        // Static methods
        static function find ($search_id)
        {
            $found_book = null;
            $books = Book::getAll();
            foreach ($books as $book) {
                if ($book->getId() == $search_id) {
                    $found_book = $book;
                }
            }
            return $found_book;
        }

        static function deleteAll ()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
            // $GLOBALS['DB']->exec("DELETE FROM authorships;");
            // $GLOBALS['DB']->exec("DELETE FROM copies;");
        }

        static function getAll ()
        {
            try {
                $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
            $books = array();
            foreach ($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }



    }

?>
