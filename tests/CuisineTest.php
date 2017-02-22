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
            //Arrange
            $cuisine = "indian";
            $id = null;
            $cuisine_test = new Cuisine($cuisine, $id);
            $cuisine_test->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals(1, is_numeric($result[0]->getId()));

        }

        function test_deleteAll()
        {
            //Arrange
            $cuisine = "indian";
            $id = null;
            $cuisine_test = new Cuisine($cuisine, $id);
            $cuisine_test->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([], $result);

        }

        function test_update()
        {
            $cuisine = "Korean";
            $new_name = "Korean BBQ";
            $id = null;
            $cuisine_test = new Cuisine($cuisine, $id);

            $cuisine_test->update($new_name);

            $this->assertEquals($new_name, $cuisine_test->getCuisine());
        }
      }
?>
