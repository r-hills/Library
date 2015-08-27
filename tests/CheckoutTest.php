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

        /* save and getAll tests are not currently passing for Checkout.
         * All other tests should be passing.
         * The only problem is ids aren't being set correctly somehow... */


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
            $due_date = "2015-08-09";
            $test_checkout = new Checkout($patron_id, $copy_id, $due_date);

            //Act
            $result = $test_checkout->getPatronId();

            //Assert
            $this->assertEquals($patron_id, $result);
        }

        function test_save()
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
            $test_patron->save();

            // Make a Checkout
            $patron_id = $test_patron->getId();
            $copy_id = 1;
            $due_date = "2015-08-09";
            $test_checkout = new Checkout($patron_id, $copy_id, $due_date);

            //Act
            $test_checkout->save();

            //Assert
            $result = Checkout::getAll();
            $this->assertEquals($test_checkout, $result[0]);
        }

        function test_getAll()
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
            $test_patron->save();

            // Make a Checkout and save
            $patron_id = $test_patron->getId();
            $copy_id = 1;
            $due_date = "2015-08-09";
            $test_checkout = new Checkout($patron_id, $copy_id, $due_date);
            $test_checkout->save();

            // Make a 2nd Checkout and save under the same patron
            $copy_id2 = 1;
            $due_date2 = "2015-08-09";
            $test_checkout2 = new Checkout($patron_id, $copy_id2, $due_date2);
            $test_checkout2->save();

            //Act
            $result = Checkout::getAll();

            //Assert
            $this->assertEquals([$test_checkout, $test_checkout2], $result);
        }

        // deleteAll test

        // updatePatronId test

        // updateCopyId test

        // updateDueDate test


    }

?>
