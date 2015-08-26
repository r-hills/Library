<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";
    require_once "src/Author.php";
    require_once "src/Patron.php";
    //require_once "src/Checkout.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
            Book::deleteAll();
            Author::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Dan Brown";
            $phone = "3";
            $email = "a@a.com";
            $test_patron = new Patron($name, $phone, $email);

            //Act
            $result = $test_patron->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Dan Brown";
            $phone = "3";
            $email = "a@a.com";
            $test_patron = new Patron($name, $phone, $email);
            $test_patron->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals($test_patron, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Dan Brown";
            $phone = "3";
            $email = "a@a.com";
            $test_patron = new Patron($name, $phone, $email);
            $test_patron->save();

            $name2 = "Ian Browne";
            $phone2 = "4";
            $email2 = "b@b.com";
            $test_patron2 = new Patron($name2, $phone2, $email2);
            $test_patron2->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron, $test_patron2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Dan Brown";
            $phone = "3";
            $email = "a@a.com";
            $test_patron = new Patron($name, $phone, $email);
            $test_patron->save();

            $name2 = "Ian Browne";
            $phone2 = "4";
            $email2 = "b@b.com";
            $test_patron2 = new Patron($name2, $phone2, $email2);
            $test_patron2->save();

            //Act
            Patron::deleteAll();
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_delete()
        {
            //Arrange
            $name = "Dan Brown";
            $phone = "3";
            $email = "a@a.com";
            $test_patron = new Patron($name, $phone, $email);
            $test_patron->save();

            $name2 = "Ian Browne";
            $phone2 = "4";
            $email2 = "b@b.com";
            $test_patron2 = new Patron($name2, $phone2, $email2);
            $test_patron2->save();

            //Act
            $test_patron->delete();
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$test_patron2], $result);
        }

        function test_updateName()
        {
            //Arrange
            $name = "Dan Brown";
            $phone = "3";
            $email = "a@a.com";
            $test_patron = new Patron($name, $phone, $email);
            $test_patron->save();

            //Act
            $new_name = "Billy Worthington";
            $test_patron->updateName($new_name);

            //Assert
            $result = Patron::getAll();
            $this->assertEquals($new_name, $result[0]->getName());
        }

        function test_updatePhone()
        {
            //Arrange
            $name = "Dan Brown";
            $phone = "3";
            $email = "a@a.com";
            $test_patron = new Patron($name, $phone, $email);
            $test_patron->save();

            //Act
            $new_phone = "888";
            $test_patron->updatePhone($new_phone);

            //Assert
            $result = Patron::getAll();
            $this->assertEquals($new_phone, $result[0]->getPhone());
        }

        function test_updateEmail()
        {
            //Arrange
            $name = "Dan Brown";
            $phone = "3";
            $email = "a@a.com";
            $test_patron = new Patron($name, $phone, $email);
            $test_patron->save();

            //Act
            $new_email = "hi@bye.com";
            $test_patron->updateEmail($new_email);

            //Assert
            $result = Patron::getAll();
            $this->assertEquals($new_email, $result[0]->getEmail());
        }

        function test_find()
        {
            //Arrange
            $name = "Dan Brown";
            $phone = "3";
            $email = "a@a.com";
            $test_patron = new Patron($name, $phone, $email);
            $test_patron->save();

            //Act
            $result = Patron::find($test_patron->getId());

            //Assert
            $this->assertEquals($test_patron, $result);
        }

        // function test_addCheckout()
        // {
        //
        // }
        //
        // function test_getCheckouts()
        // {
        //
        // }









    }


?>
