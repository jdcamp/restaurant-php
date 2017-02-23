<?php
    date_default_timezone_set ("America/Los_Angeles");

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=cuisine_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app['debug'] = true;


     use Symfony\Component\HttpFoundation\Request;
     Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    $app->get("/", function() use ($app) {
        return $app['twig']->render("index.html.twig");
    });
    $app->get("/cuisine/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render("restaurant_list.html.twig", array('cuisine'=>$cuisine, 'restaurants'=>$cuisine->getRestaurants()));
    });

    $app->get("/cuisine_list", function() use ($app) {
        return $app['twig']->render("cuisine_type.html.twig", array('cuisines'=>Cuisine::getAll()));
    });
    $app->post("/cuisine_list", function() use ($app) {
        $new_cuisine = new Cuisine($_POST['cuisine_type'], null);
        $new_cuisine->save();

        return $app['twig']->render("cuisine_type.html.twig", array('cuisines'=>Cuisine::getAll()));
    });
    $app->post("/add_restaurant/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $new_restaurant = new Restaurant(null, $id, $_POST['name'], $_POST['price']);
        $new_restaurant->save();
        return $app['twig']->render("restaurant_list.html.twig", array('cuisine'=>$cuisine, 'restaurants'=>$cuisine->getRestaurants()));
    });

    $app->get("/delete", function() use ($app) {
        Cuisine::deleteAll();
        Restaurant::deleteAll();
        return $app['twig']->render("index.html.twig");
    });
    $app->get("/user_homepage", function() use ($app) {
        $all_cuisines = Cuisine::getAll();
        return $app['twig']->render("user_homepage.html.twig", array('cuisines' => $all_cuisines));
    });
    $app->post("/custom_wheel", function() use ($app) {
        $cuisine_id = $_POST['random'];
        $all_cuisines = Cuisine::getAll();
        $random = Cuisine::getRandomRestaurant($cuisine_id);
        return $app['twig']->render("custom_wheel.html.twig", array('cuisines' => $all_cuisines, 'random'=>$random));
    });
    $app->get("/update_cuisine/{id}", function($id) use ($app) {
        $original_cuisine = Cuisine::find($id);
        return $app['twig']->render("update_cuisine.html.twig", array('cuisine' => $original_cuisine));
    });
    $app->patch("/edit_cuisine/{id}", function($id) use ($app) {
        $cuisine = $_POST['new_name'];
        $cuisine_type = Cuisine::find($id);
        $cuisine_type->update($cuisine);
        return $app['twig']->render("cuisine_type.html.twig", array('cuisines'=>Cuisine::getAll()));
     });
     $app->delete("/delete_cuisine/{id}", function($id) use ($app) {
         $original_cuisine = Cuisine::find($id);
         $original_cuisine->deleteOne();
         return $app['twig']->render("cuisine_type.html.twig", array('cuisines'=>Cuisine::getAll()));
     });
     $app->get("/edit_restaurant/{id}", function($id) use ($app) {
         $original_restaurant = Restaurant::find($id);
         return $app['twig']->render("update_restaurant.html.twig", array('restaurant' => $original_restaurant));
     });
     $app->patch("/edit_restaurant/{id}", function($id) use ($app) {
         $restaurant = Restaurant::find($id);
         $restaurant_name = $_POST['new_name'];
         $price_point = $_POST['new_price'];
         $restaurant->updateName($restaurant_name);
         $restaurant->updatePrice($price_point);
         $cuisine = Cuisine::find($restaurant->getCuisineId());
         return $app['twig']->render("restaurant_list.html.twig", array('cuisine'=>$cuisine, 'restaurants'=>$cuisine->getRestaurants()));
      });
      $app->delete("/delete_restaurant/{id}", function($id) use ($app) {
          $original_restaurant = Restaurant::find($id);
          $cuisine = Cuisine::find($original_restaurant->getCuisineId());
          $original_restaurant->deleteOne();
          return $app['twig']->render("restaurant_list.html.twig", array('cuisine'=>$cuisine, 'restaurants'=>$cuisine->getRestaurants()));
      });
    return $app;

?>
