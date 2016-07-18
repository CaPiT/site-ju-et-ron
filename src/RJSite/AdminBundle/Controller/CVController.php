<?php

namespace RJSite\AdminBundle\Controller;

use RJSite\AdminBundle\Controller\AdminController;
use Symfony\Component\HttpFoundation\Request;
use RJSite\PlatformBundle\Entity\CV\Profile;
use RJSite\PlatformBundle\Form\CV\ProfileType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CVController extends AdminController
{
    public function listAction($page)
    {
        if ($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }
    
        $nbPerPage = 3;
         
        $listProfiles = $this->getDoctrine()
            ->getManager()
            ->getRepository('RJSitePlatformBundle:CV\Profile')
            ->getProfiles($page, $nbPerPage)
        ;
    
        $nbPages = ceil(count($listProfiles) / $nbPerPage);
        // Si la page n'existe pas, on retourne une 404
        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
    
        // L'appel de la vue ne change pas
        return $this->render('RJSiteAdminBundle:CV:list.html.twig', array(
            'listProfiles' => $listProfiles,
            'nbPages'     => $nbPages,
            'page'        => $page,
        ));
    }
    
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
    
        // Pour récupérer une seule annonce, on utilise la méthode find($id)
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
    
        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id n'existe pas, d'où ce if :
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
    
        // Récupération de la liste des candidatures de l'annonce
        $listApplications = $em
        ->getRepository('OCPlatformBundle:Application')
        ->findBy(array('advert' => $advert))
        ;
    
        // Récupération des AdvertSkill de l'annonce
        $listAdvertSkills = $em
        ->getRepository('OCPlatformBundle:AdvertSkill')
        ->findBy(array('advert' => $advert))
        ;
    
        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
            'advert'           => $advert,
            'listApplications' => $listApplications,
            'listAdvertSkills' => $listAdvertSkills,
        ));
    }
    
    public function addAction(Request $request)
    {
        $profile = new Profile();
    
        $form = $this->createForm(ProfileType::class, $profile);
    
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
    
            if ($form->isValid()) {
    
                $em = $this->getDoctrine()->getManager();
                $em->persist($profile);
                $em->flush();
    
                $request->getSession()->getFlashBag()->add('notice', 'Profil bien enregistré.');
    
                return $this->redirectToRoute('rj_site_admin.cv.list'/*, array('id' => $advert->getId())*/);
            }
        }
    
        return $this->render('RJSiteAdminBundle:CV:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
    
        $profile = $em->getRepository('RJSitePlatformBundle:CV\Profile')->find($id);
    
        if (null === $profile) {
            throw new NotFoundHttpException("Le Curriculum Vitae avec l'id " . $id . " n'existe pas.");
        }
    
        $form = $this->get('form.factory')->create(ProfileType::class, $profile);
    
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre annonce
            $em->flush();
    
            $request->getSession()->getFlashBag()->add('notice', "Le Curriculum Vitae de " . $profile->getFirstname() . " a bien été modifié.");
    
            return $this->redirectToRoute('rj_site_admin.cv.list'/*, array('id' => $advert->getId())*/);
        }
    
        return $this->render('RJSiteAdminBundle:CV:edit.html.twig', array(
            'advert' => $profile,
            'form'   => $form->createView(),
        ));
    }
    
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
    
        $profile = $em->getRepository('RJSitePlatformBundle:CV\Profile')->find($id);
    
        if (null === $profile) {
            throw new NotFoundHttpException("Le Curriculum Vitae avec l'id ".$id." n'existe pas.");
        }
    
        $em->remove($profile);
        $em->flush();
    
        $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");
    
        return $this->redirectToRoute('rj_site_admin.cv.list');
    }
    
    public function menuAction($limit)
    {
        $em = $this->getDoctrine()->getManager();
    
        $listAdverts = $em->getRepository('OCPlatformBundle:Advert')->findBy(
            array(),                 // Pas de critère
            array('date' => 'desc'), // On trie par date décroissante
            $limit,                  // On sélectionne $limit annonces
            0                        // À partir du premier
            );
    
        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }
    
}
