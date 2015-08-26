<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Checkout.php";
    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CheckoutTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Checkout::deleteAll();
            Patron::deleteAll();
            Book::deleteAll();
            Author::deleteAll();
        }

        function test_getPatronId()
        {
            // for now, feed a dummy copy_id just for testing
            // later, we will need to use getNextCopy() in Book class
            // to get a copy for a given book

            //Arrange
            // Make a Patron
            $name = "Dan Brown";
            $phone = "3";
            $email = "a@a.com";
            $test_patron = new Patron($name, $phone, $email);

            // Make a Checkout
            $patron_id = $test_patron->getId();
            $copy_id = 1;
            $date = "2015-08-09";
            $test_checkout = new Checkout($patron_id, $copy_id, $date);

            //Act
            $result = $test_checkout->getPatronId();

            //Assert
            $this->assertEquals($patron_id, $result);
        }

    }

?>
