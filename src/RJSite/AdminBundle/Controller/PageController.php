<?php

namespace RJSite\AdminBundle\Controller;

use RJSite\AdminBundle\Controller\AdminController;

class PageController extends AdminController
{
    public function dashboardAction()
    {
        return $this->render('RJSiteAdminBundle:Page:dashboard.html.twig');
    }
    
    public function mainmenuAction()
    {
    
        $menuItems = array(
            array('title' => 'Tableau de bord', 'link' => $this->generateUrl('rj_site_admin.page.dashboard'), 'class'=> 'active'),
            array('title' => 'Navigation',      'link' => $this->generateUrl('rj_site_admin.page.dashboard'), 'class'=> ''),
            array('title' => 'Curiculum Vitae', 'link' => $this->generateUrl('rj_site_admin.cv.list'), 'class'=> ''),
            array('title' => 'Contact',         'link' => $this->generateUrl('rj_site_admin.contact.list'), 'class'=> ''),
            array('title' => 'Configuration',   'link' => $this->generateUrl('rj_site_admin.configuration.list'), 'class'=> '')
        );
    
        return $this->render('RJSiteAdminBundle:Page:mainmenu.html.twig', array(
            'menuItems' => $menuItems
        ));
    }
}
