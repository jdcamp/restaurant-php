<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost:8889;dbname=cuisine_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        function test_save()
        {
            $cuisine = "indian";
            $id = null;
            $cuisine_test = new Cuisine($cuisine, $id);
            $cuisine_test->save();

            $result = Cuisine::getAll();

            $this->assertEquals(1, is_numeric($result[0]->getId()));

        }

        function test_deleteAll()
        {
            $cuisine = "indian";
            $id = null;
            $cuisine_test = new Cuisine($cuisine, $id);
            $cuisine_test->save();

            Cuisine::deleteAll();
            $result = Cuisine::getAll();


            $this->assertEquals([], $result);

        }
      }
?>
