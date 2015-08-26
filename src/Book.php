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

        }

        static function getAll ()
        {

        }



    }

?>
