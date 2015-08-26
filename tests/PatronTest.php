<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    //require_once "src/Patron.php";
    require_once "src/Patron.php";
    //require_once "src/Patron.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            // Patron::deleteAll();
            Patron::deleteAll();
            // Patron::deleteAll();
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



    }


?>
