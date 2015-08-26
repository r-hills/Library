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

        }

        function updateTitle ($new_title)
        {

        }

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

        static function find ($search_id)
        {

        }

        static function deleteAll ()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
            // $GLOBALS['DB']->exec("DELETE FROM authorships WHERE book_id = {$this->getId()};");
            // $GLOBALS['DB']->exec("DELETE FROM copies WHERE book_id = {$this->getId()};");
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
