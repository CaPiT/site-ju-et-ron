<?php

namespace RJSite\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CVController extends Controller
{
    public function viewAction()
    {
        return $this->render('RJSiteFrontBundle:CV:view.html.twig');
    }
    
    public function menuAction()
    {
        $menuItems = array(
        );
    
        return $this->render('RJSiteFrontBundle:CV:menu.html.twig', array(
            'menuItems' => $menuItems
        ));
    }
    
}
