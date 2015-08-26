<?php

    class Author
    {
        private $title;
        private $name;

        function __construct($title, $id = null)
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

        }

        static function getAll()
        {

        }


    }

?>
