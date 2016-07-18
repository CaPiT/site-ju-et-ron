<?php

namespace RJSite\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function homepageAction()
    {
        return $this->render('RJSiteFrontBundle:Page:homepage.html.twig');
    }
    
    
    public function mainmenuAction()
    {
        
        $menuItems = array(
            array('title' => 'DESCRIPTION',         'link' => $this->generateUrl('rj_site_front.cv.view'), 'class'=>'icon-desc'),
            array('title' => 'IMAGES',              'link' => '#', 'class'=>'icon-image'),
            array('title' => 'EXPÉDITION',          'link' => '#', 'class'=>'icon-plane'),
            array('title' => 'AJOUTER AU PANIER',   'link' => $this->generateUrl('rj_site_contact.page.view'), 'class'=>'icon-cart')
        );
        
        return $this->render('RJSiteFrontBundle:Page:mainmenu.html.twig', array(
            'menuItems' => $menuItems
        ));
    }
}
