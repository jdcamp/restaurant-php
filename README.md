# Restaurants

#### Epicodus PHP Week 3 lab, 2/22/2017

#### By Sarah Leahy, Jake Campa

## Description

Allows users to enter restaurants by name and cuisine type then search through the results.

## Setup/Installation Requirements
* See https://secure.php.net/ for details on installing _PHP_.  Note: PHP is typically already installed on Macs.
* See https://getcomposer.org for details on installing _composer_.
* Clone repository
* From project root, run > composer install --prefer-source --no-interaction
* From web folder in project, Start PHP > php -S localhost:8000
* In web browser open localhost:8000

## Known Bugs
* No known bugs

## Specifications

| Behavior - Our Program should Handle?| Input         | Output |      
|---| --- | --- |        
|  Accept one type of cuisine. | Indian | Indian |
|  Save cuisine type to database via save button. | Indian  |  in db- 1.Indian|
|  Accept multiple types and save them. | Korean, Mexican |  in db- 1.Korean, 2.Mexican|
|  Accept Restaurant input in cuisine type. | Restaurant = Samosa, cuisine_id =1, price_point = 2| Cuisine = 1, restaurant = Samosa|
|  Accept multiple restaurants in cuisine type. | restaurant = Souel food , restaurant = Korean BBQ| Cuisine = 2, restaurant = Souel food, Korean BBQ
|  Get complete inventory by type. | get All  cuisines     |Indian, Korean, Mexican |
|  Get restaurant list by cuisine type. | get All  restaurants in Mexican     |Little Anitas |
|  Update cuisine type. | Korean   |Korean BBQ |
|  Update restaurant name. | Little Anitas  |Anitas Mexican |
|  Delete cuisine type. | Indian |  Deleted|
|  Delete restaurant. | Little Anitas |  "deleted"|
|  Delete complete inventory. | delete all |  "nothing in inventory"|


## Support and contact details
no support

## Technologies Used
* PHP
* Composer
* Silex
* Twig
* HTML
* CSS
* Bootstrap
* Git

## Copyright (c)
* 2017 Sarah Leahy, Jake Campa

## License
* MIT
