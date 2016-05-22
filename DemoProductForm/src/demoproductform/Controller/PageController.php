<?php

namespace demoproductform\Controller; 

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class PageController {
    
    public function getHomePage(Application $app)
    {
         return $app['twig']->render('home.twig.html');
    }
    
    public function getAllProducts(Application $app)
    {
       $products =  $app['db']->fetchAll('SELECT * FROM product');
       return $app['twig']->render('products.twig.html', array('products' => $products));
       
    }
}
