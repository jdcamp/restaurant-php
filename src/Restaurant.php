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

        function getRestaurantId()
        {
            return $this->restaurant_id;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function getRestaurantName()
        {
            return $this->restaurant_name;
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
    }
 ?>
