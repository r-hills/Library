<?php

    class Checkout
    {
        private $patron_id;
        private $copy_id;
        private $date;
        private $id;

        function __construct($patron_id, $copy_id, $date, $id = null)
        {
            $this->patron_id = $patron_id;
            $this->copy_id = $copy_id;
            $this->date = $date;
            $this->id = $id;
        }


        // Getters and Setters
        function setPatronId ($new_patron_id)
        {
            $this->patron_id = $new_patron_id;
        }

        function getPatronId ()
        {
            return $this->patron_id;
        }

        function setCopyId ($new_copy_id)
        {
            $this->copy_id = $new_copy_id;
        }

        function getCopyId ()
        {
            return $this->copy_id;
        }

        function setDate ($new_date)
        {
            $this->date = $new_date;
        }

        function getDate ()
        {
            return $this->date;
        }

        function getId ()
        {
            return $this->id;
        }



        // Basic database storage methods
        function save ()
        {
            try {
                $GLOBALS['DB']->exec("INSERT INTO checkouts (patron_id, copy_id, date) VALUES ({$this->getPatronId()}, {$this->getCopyId()}, {$this->getDate()});");
                $this->id = $GLOBALS['DB']->lastInsertId();
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
        }

        function delete ()
        {
            $GLOBALS['DB']->exec("DELETE FROM checkouts WHERE id = {$this->getId()};");
        }

        function updatePatronId ($new_patron_id)
        {
            $GLOBALS['DB']->exec("UPDATE checkouts SET patron_id = {$new_patron_id} WHERE id = {$this->getId()};");
            $this->setPatronId($new_patron_id);
        }

        function updateCopyId ($new_copy_id)
        {
            $GLOBALS['DB']->exec("UPDATE checkouts SET copy_id = {$new_copy_id} WHERE id = {$this->getId()};");
            $this->setCopyId($new_copy_id);
        }

        function updateDate ($new_date)
        {
            $GLOBALS['DB']->exec("UPDATE checkouts SET date = {$new_date} WHERE id = {$this->getId()};");
            $this->setDate($new_date);
        }

        static function deleteAll ()
        {
            
        }

        static function getAll ()
        {

        }

        static function find ($search_id)
        {

        }

    }
?>
