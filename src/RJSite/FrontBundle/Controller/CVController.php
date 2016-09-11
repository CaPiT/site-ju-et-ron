<?php

namespace RJSite\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use RJSite\PlatformBundle\Entity\CV\Profile;

class CVController extends Controller
{
    public function viewAction()
    {
        $listProfiles = $this->getDoctrine()
            ->getManager()
            ->getRepository('RJSitePlatformBundle:CV\Profile')
            ->getProfiles(1, 2)
        ;
        
        return $this->render('RJSiteFrontBundle:CV:view.html.twig', array(
            'listProfiles' => $listProfiles,
        ));
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
