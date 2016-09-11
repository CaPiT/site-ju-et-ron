<?php

namespace RJSite\FrontBundle;

use Knp\Menu\FactoryInterface;
use Knp\Menu\Matcher\Matcher;
use Knp\Menu\MenuFactory;
use Knp\Menu\Renderer\ListRenderer;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     *
     * Add any other dependency you need
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $childrenAttributes = array();
        if (isset($options['rootClass']) && $options['rootClass']) {
            $childrenAttributes = array('class' => $options['rootClass']); 
        }
        
        $menu = $this->factory->createItem('root', array(
            'childrenAttributes' => $childrenAttributes
        ));

        $menu->addChild('DESCRIPTION', array('route' => 'rj_site_front.cv.view'));
        $menu['DESCRIPTION']->setLinkAttribute('class', 'icon-desc');
        
        $menu->addChild('IMAGES', array('route' => 'rj_site_front.page.creation'));
        $menu['IMAGES']->setLinkAttribute('class', 'icon-image');
        
        $menu->addChild('EXPÉDITION', array('route' => 'rj_site_front.page.description'));
        $menu['EXPÉDITION']->setLinkAttribute('class', 'icon-plane');
        
        $menu->addChild('AJOUTER AU PANIER', array('route' => 'rj_site_contact.page.request'));
        $menu['AJOUTER AU PANIER']->setLinkAttribute('class', 'icon-cart');
        
        return $menu;
    }
}