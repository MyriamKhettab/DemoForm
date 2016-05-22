<?php

namespace demoproductform\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use demoproductform\Form\FormAddOpinion;
use Ramsey\Uuid\Uuid;

class ProductController {

    public function getProductDetailByUuid(Application $app, $uuid, Request $request) {
        $sql = "SELECT * FROM Product WHERE uuid = ?";
        $product = $app['db']->fetchAssoc($sql, array($uuid));

        $opinions = $app['db']->fetchAll("SELECT * FROM Opinion WHERE uuidproduct=?", array($uuid));

        $addForm = new FormAddOpinion();
        $form = $addForm->createForm($app);
        $form->handleRequest($request);

        return $app['twig']->render('product.twig.html', array('product' => $product, 'form' => $form->createView(), 'opinions' => $opinions));
    }

    public function addOpinion(Application $app, Request $request, $uuidproduct) {
        $addForm = new FormAddOpinion();
        $form = $addForm->createForm($app);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $data = $form->getData();

            $email = $data['email'];
            $content = $data['content'];

            $sql = "INSERT INTO Opinion VALUES(?,?,?,?)";
            $stmt = $app['db']->prepare($sql);
            $stmt->bindValue(1, Uuid::uuid4()->toString());
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $content);
            $stmt->bindValue(4, $uuidproduct);
            $stmt->execute();

           $message = \Swift_Message::newInstance()
                            ->setSubject('[DemoFormProduct] DemoProduct')
                            ->setFrom(array('noreply@demoproject.com')) // replace with your own
                            ->setTo(array($data['email']))   // replace with email recipient
                            ->setBody("Thanks for your opinion.");
            
            $app['mailer']->send($message);
            
            return $app['twig']->render('success.twig.html');
        }

        return $app->redirect('/index.php/product/' . $uuidproduct);
    }

}
