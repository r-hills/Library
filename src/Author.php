<?php

    class Author
    {
        private $title;
        private $name;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }


        // Getters and Setters
        function setName ($new_name)
        {
            $this->name = $new_name;
        }

        function getName ()
        {
            return $this->name;
        }

        function getId ()
        {
            return $this->id;
        }

        // Basic database storage methods
        function save()
        {
            try {
                $GLOBALS['DB']->exec("INSERT INTO authors (name) VALUES (
                    '{$this->getName()}'
                    );");
                $this->id = $GLOBALS['DB']->lastInsertId();
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authorships WHERE author_id = {$this->getId()};");
        }

        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }



        // Methods involving other tables
        function getBooks()
        {
            $books_query = $GLOBALS['DB']->query(
                "SELECT books.* FROM
                    authors JOIN authorships ON (authors.id = authorships.author_id)
                            JOIN books       ON (authorships.book_id = books.id)
                WHERE authors.id = {$this->getId()};"
            );

            $matching_books = array();
            foreach($books_query as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($matching_books, $new_book);
            }
            return $matching_books;

        }

        function addBook($new_book)
        {
            $GLOBALS['DB']->exec("INSERT INTO authorships (book_id, author_id) VALUES(
                {$new_book->getId()},
                {$this->getId()}
            );");
        }

        // Static methods
        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach ($authors as $author) {
                if ($author->getId() == $search_id) {
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors;");
            $GLOBALS['DB']->exec("DELETE FROM authorships;");
        }

        static function getAll()
        {
            try {
                $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
            $all_authors = array();
            foreach ($returned_authors as $author) {
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($name, $id);
                array_push($all_authors, $new_author);
            }
            return $all_authors;
        }


    }

?>
