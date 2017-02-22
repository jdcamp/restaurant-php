<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost:8889;dbname=cuisine_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
        }
        function test_save()
        {
            $restaurant_name = "Samosa";
            $restaurant_id = 1;
            $cuisine_id = 1;
            $price_point = 1;
            $restaurant_test = new Restaurant($restaurant_id, $cuisine_id, $restaurant_name, $price_point);
            var_dump($restaurant_test->getRestaurantId());
            $restaurant_test->save();

            $restaurant_name = "Little Anitas";
            $restaurant_id = 2;
            $cuisine_id = 1;
            $price_point = 1;
            $restaurant_test2 = new Restaurant($restaurant_id, $cuisine_id, $restaurant_name, $price_point);
            $restaurant_test2->save();


            $result = Restaurant::getAll();

            $this->assertEquals($result[0],$restaurant_test);

        }

        // function test_deleteAll()
        // {
        //     $restaurant_name = "Samosa";
        //     $restaurant_id = null;
        //     $cuisine_id = null;
        //     $price_point = 1;
        //     $restaurant_test = new Restaurant($restaurant_name, $restaurant_id, $cuisine_id, $price_point);
        //     $restaurant_test->save();
        //
        //     Restaurant::deleteAll();
        //     $result = Restaurant::getAll();
        //
        //
        //     $this->assertEquals([], $result);
        //
        // }
      }
