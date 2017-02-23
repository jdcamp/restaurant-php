<?php
    class Restaurant
    {
        private $restaurant_id;
        private $cuisine_id;
        private $restaurant_name;
        private $price_point;

        function __construct($restaurant_id = null, $cuisine_id, $restaurant_name, $price_point)
        {
            $this->restaurant_id = $restaurant_id;
            $this->cuisine_id = $cuisine_id;
            $this->restaurant_name = $restaurant_name;
            $this->price_point = $price_point;
        }

        function setRestaurantName($new_restaurant_name)
        {
            $this->restaurant_name = $new_restaurant_name;
        }
        function setPricePoint($new_price_point)
        {
            $this->price_point = $new_price_point;
        }

        function getRestaurantName()
        {
            return $this->restaurant_name;
        }
        function getRestaurantId()
        {
            return $this->restaurant_id;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }


        function getPricePoint()
        {
            return $this->price_point;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurant(restaurant_name, price_point, cuisine_id) VALUES ('{$this->getRestaurantName()}', {$this->getPricePoint()}, {$this->getCuisineId()});");
            $this->restaurant_id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant;");
            $restaurants = array();
            foreach ($returned_restaurants as $restaurant) {
                $restaurant_name = $restaurant['restaurant_name'];
                $restaurant_id = $restaurant['id'];
                $price_point = $restaurant['price_point'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_restaurant = new Restaurant((int)$restaurant_id, (int)$cuisine_id, $restaurant_name, (int)$price_point);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec(" DELETE FROM restaurant;");
        }

        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE restaurant SET restaurant_name = '{$new_name}' WHERE id = {$this->getRestaurantId()};");
            $this->setRestaurantName($new_name);
        }

        function updatePrice($new_price)
        {
            $GLOBALS['DB']->exec("UPDATE restaurant SET price_point = '{$new_price}' WHERE id = {$this->getRestaurantId()};");
            $this->setPricePoint($new_price);
        }
        function deleteOne()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurant WHERE id = {$this->getRestaurantId()};");
        }

        static function find($search_id)
        {
            $found_restaurant = null;
            $restaurants = Restaurant::getAll();
            foreach ($restaurants as $restaurant) {
                $restaurant_id = $restaurant->getRestaurantId();
                if ($restaurant_id == $search_id)
                {
                    $found_restaurant = $restaurant;
                }
            }
            return $found_restaurant;
        }
        static function randomAll(){
            $all_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant;");
            $restaurants = array();
                foreach ($all_restaurants as $restaurant) {
                    $restaurant_id = $restaurant['id'];
                    $cuisine_id = $restaurant['cuisine_id'];
                    $name = $restaurant['restaurant_name'];
                    $price_point = $restaurant['price_point'];
                    $new_restaurant = new Restaurant($restaurant_id, $cuisine_id, $name, $price_point);
                    array_push($restaurants, $new_restaurant);
            }
            $index = rand(0,sizeof($restaurants)-1);
            if (sizeof($restaurants) == 0) {
                return null;
            }
            return $restaurants[$index];
        }
    }
 ?>
