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

        }

        function updateName($new_name)
        {

        }



        // Methods involving other tables
        function getBooks()
        {

        }

        function addBook($new_book)
        {

        }



        // Static methods
        static function find($search_id)
        {

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
