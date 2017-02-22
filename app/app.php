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
    return $app;

?>
