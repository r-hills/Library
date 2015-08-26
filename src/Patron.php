<?php

    class Patron
    {
        private $name;
        private $phone;
        private $email;
        private $id;

        function __construct($name, $phone, $email, $id = null)
        {
            $this->name = $name;
            $this->phone = $phone;
            $this->email = $email;
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

        function setPhone ($new_phone)
        {
            $this->phone = $new_phone;
        }

        function getPhone ()
        {
            return $this->phone;
        }

        function setEmail ($new_email)
        {
            $this->email = $new_email;
        }

        function getEmail ()
        {
            return $this->email;
        }

        function getId ()
        {
            return $this->id;
        }

        // Basic database storage methods
        function save ()
        {
            try {
                $GLOBALS['DB']->exec("INSERT INTO patrons (name,phone,email) VALUES (
                    '{$this->getName()}',
                    '{$this->getPhone()}',
                    '{$this->getEmail()}'
                    );");
                $this->id = $GLOBALS['DB']->lastInsertId();
            } catch (PDOException $e) {
                echo "Error in Book save function: " . $e->getMessage();
            }
        }

        function delete ()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM checkouts WHERE patron_id = {$this->getId()};");
        }

        function updateName ($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function updatePhone ($new_phone)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET phone = '{$new_phone}' WHERE id = {$this->getId()};");
            $this->setPhone($new_phone);
        }

        function updateEmail ($new_email)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET email = '{$new_email}' WHERE id = {$this->getId()};");
            $this->setEmail($new_email);
        }

        // Methods involving other tables

        function addCheckout ()
        {

        }

        function getCheckouts ()
        {

        }

        // Static methods
        static function find ($search_id)
        {
            $found_patron = null;
            $patrons = Patron::getAll();
            foreach ($patrons as $patron) {
                if ($patron->getId() == $search_id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

        static function deleteAll ()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons;");
            $GLOBALS['DB']->exec("DELETE FROM checkouts;");
        }

        static function getAll ()
        {
            try {
                $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            } catch (PDOException $e) {
                echo "There was an error: " . $e->getMessage();
            }
            $patrons = array();
            foreach ($returned_patrons as $patron) {
                $name = $patron['name'];
                $phone = $patron['phone'];
                $email = $patron['email'];
                $id = $patron['id'];
                $new_patron = new Patron($name, $phone, $email, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }




    }

?>
