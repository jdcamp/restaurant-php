<?php
    class Cuisine
    {
        private $cuisine;
        private $id;

        function __construct($cuisine, $id = null)
        {
            $this->cuisine = $cuisine;
            $this->id = $id;
        }

        function setCuisine($cuisine)
        {
            $this->cuisine = $cuisine;
        }

        function getId()
        {
            return $this->id;
        }

        function getCuisine()
        {
            return $this->cuisine;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisine_type(cuisine_type) VALUES ('{$this->getCuisine()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine_type;");
            $cuisines = array();
            foreach ($returned_cuisines as $cuisine) {
                $type = $cuisine['cuisine_type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine($type, $id);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }
        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach ($cuisines as $cuisine) {
                $cuisine_id = $cuisine->getId();
                if ($cuisine_id == $search_id)
                {
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec(" DELETE FROM cuisine_type;");
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE cuisine_type SET cuisine_type = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setCuisine($new_name);
        }

        function getRestaurants()
        {
            $restaurants = array();
            $found_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant WHERE cuisine_id = {$this->getId()};");
            foreach ($found_restaurants as $restaurant) {
                $restaurant_id = $restaurant['id'];
                $cuisine_id = $restaurant['cuisine_id'];
                $name = $restaurant['restaurant_name'];
                $price_point = $restaurant['price_point'];
                $new_restaurant = new Restaurant($restaurant_id, $cuisine_id, $name, $price_point);
                array_push($restaurants,$new_restaurant);

            }
            return $restaurants;
        }

        static function getRandomRestaurant($id)
        {
        $random_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant WHERE cuisine_id = {$id};");
        $restaurants = array();
            foreach ($random_restaurants as $restaurant) {
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

    function deleteOne()
    {
        $GLOBALS['DB']->exec("DELETE FROM cuisine_type WHERE id = {$this->getId()};");
    }
}
?>
