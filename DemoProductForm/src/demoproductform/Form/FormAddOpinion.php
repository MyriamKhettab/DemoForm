<?php

namespace demoproductform\Form;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class FormAddOpinion {

    public function createForm(Application $app) {
        $form = $app['form.factory']->createBuilder()
                ->add('uuidproduct', HiddenType::class, array(
                    'constraints' => array(new Assert\NotBlank()),))
                ->add('email', TextType::class, array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Email()), ))
                ->add('content', TextType::class, array(
                    'constraints' => array(new Assert\NotBlank()),))
                ->getForm();
        return $form;
    }

}
