<?php

namespace RJSite\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    
    public function mainmenuAction()
    {
        
        $menuItems = array(
            array('title' => 'DESCRIPTION',         'link' => $this->generateUrl('rj_site_front.cv.view'), 'class' => 'icon-desc active'),
            array('title' => 'IMAGES',              'link' => $this->generateUrl('rj_site_front.page.creation'), 'class' => 'icon-image'),
            array('title' => 'EXPÉDITION',          'link' => $this->generateUrl('rj_site_front.page.description'), 'class' => 'icon-plane'),
            array('title' => 'AJOUTER AU PANIER',   'link' => $this->generateUrl('rj_site_contact.page.request'), 'class' => 'icon-cart')
        );
        
        return $this->render('RJSiteFrontBundle:Page:mainmenu.html.twig', array(
            'menuItems' => $menuItems
        ));
    }
    
    public function languagesAction()
    {
    
        $languages = array(
            array('title' => 'FR', 'link' => "#", 'class' => 'active'),
            array('title' => 'EN', 'link' => '#', 'class' => ''),
        );
    
        return $this->render('RJSiteFrontBundle:Page:languages.html.twig', array(
            'languages' => $languages
        ));
    }
    
    public function homepageAction()
    {
        return $this->render('RJSiteFrontBundle:Page:homepage.html.twig');
    }
    
    public function creationAction()
    {
        return $this->render('RJSiteFrontBundle:Page:creation.html.twig');
    }
    
    public function descriptionAction()
    {
        return $this->render('RJSiteFrontBundle:Page:description.html.twig');
    }
}
