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
                $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
                $this->id = $GLOBALS['DB']->lastInsertId();

                // Initialize a first copy every time we save a book
                $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ({$this->getId()});");


            } catch (PDOException $e) {
                echo "Error in Book save function: " . $e->getMessage();
            }
        }

        function delete ()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authorships WHERE book_id = {$this->getId()};");

            // If we delete this book, should we also delete any checkouts of copies of it?
            // This would involve a join delete statement of some kind...
            // And it would need to happen before deleting copies. So, right here.

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
            $authors_query = $GLOBALS['DB']->query(
                "SELECT authors.* FROM
                    books JOIN authorships ON (books.id  = authorships.book_id)
                          JOIN authors     ON (authorships.author_id = authors.id)
                 WHERE books.id = {$this->getId()};"
            );

            $matching_authors = array();
            foreach ($authors_query as $author) {
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($name, $id);
                array_push($matching_authors, $new_author);
            }
            return $matching_authors;
        }

        function addAuthor ($new_author)
        {
            $GLOBALS['DB']->exec("INSERT INTO authorships (book_id, author_id) VALUES(
                {$this->getId()},
                {$new_author->getId()}
            );");
        }

        function getCopyIds ()
        {
            $copies_query = $GLOBALS['DB']->query("SELECT * FROM copies WHERE book_id = {$this->getId()};");

            $copy_ids = array();
            foreach($copies_query as $copy) {
                array_push($copy_ids, $copy['id']);
            }
            return $copy_ids;

        }

        function addCopies ($quantity)
        {
            // Add $quantity copies of the current book to the copies table.
            for ($currentCopy = 1; $currentCopy <= $quantity; $currentCopy++) {
                $GLOBALS['DB']->exec("INSERT INTO copies (book_id) VALUES ({$this->getId()});");
            }
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
            $GLOBALS['DB']->exec("DELETE FROM authorships;");
            $GLOBALS['DB']->exec("DELETE FROM copies;");

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
