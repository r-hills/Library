<?php

    class Checkout
    {
        private $patron_id;
        private $copy_id;
        private $due_date;
        private $id;

        function __construct($patron_id, $copy_id, $due_date, $id = null)
        {
            $this->patron_id = (int) $patron_id;
            $this->copy_id = (int) $copy_id;
            $this->due_date = (string) $due_date;
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

        function setDueDate ($new_due_date)
        {
            $this->due_date = $new_due_date;
        }

        function getDueDate ()
        {
            return $this->due_date;
        }

        function getId ()
        {
            return $this->id;
        }



        // Basic database storage methods
        function save ()
        {
            try {
                $GLOBALS['DB']->exec("INSERT INTO checkouts (patron_id, copy_id, due_date) VALUES (
                    {$this->getPatronId()},
                    {$this->getCopyId()},
                    '{$this->getDueDate()}');
                ");
                $this->id = $GLOBALS['DB']->lastInsertId();
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
        }

        // Why would we delete one checkout? We want to keep the history of all checkouts FOREVER
        // function delete ()
        // {
        //     $GLOBALS['DB']->exec("DELETE FROM checkouts WHERE id = {$this->getId()};");
        // }

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

        function updateDueDate ($new_due_date)
        {
            $GLOBALS['DB']->exec("UPDATE checkouts SET due_date = {$new_due_date} WHERE id = {$this->getId()};");
            $this->setDueDate($new_due_date);
        }

        static function deleteAll ()
        {
            $GLOBALS['DB']->exec("DELETE FROM checkouts;");
        }

        static function getAll ()
        {
            try {
                $checkouts_query = $GLOBALS['DB']->query("SELECT * FROM checkouts;");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
            $all_checkouts = array();
            foreach($checkouts_query as $checkout) {
                $new_checkout = new Checkout(
                    $checkout['patron_id'],
                    $checkout['copy_id'],
                    $checkout['due_date'],
                    $checkout['id']
                );
                array_push($all_checkouts, $new_checkout);
            }
            return $all_checkouts;
        }

        static function find ($search_id)
        {

        }

    }
?>
