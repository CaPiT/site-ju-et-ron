<?php

namespace RJSite\AdminBundle\Controller;

use RJSite\AdminBundle\Controller\AdminController;
use Symfony\Component\HttpFoundation\Request;
use RJSite\PlatformBundle\Entity\CV\Profile;
use RJSite\PlatformBundle\Form\CV\ProfileType;
use RJSite\PlatformBundle\Entity\CV\Experience;
use RJSite\PlatformBundle\Form\CV\ExperienceType;
use RJSite\PlatformBundle\Entity\CV\Section;
use RJSite\PlatformBundle\Form\CV\SectionType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class CVController extends AdminController
{
    public function listAction($page)
    {
//     	return new Response($page);
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
        
//         return new Response($page . ' - ' . $nbPages);
//         if ($page > $nbPages) {
//             throw $this->createNotFoundException("La page ".$page." n'existe pas.");
//         }
    
        // L'appel de la vue ne change pas
        return $this->render('RJSiteAdminBundle:CV:list.html.twig', array(
            'listProfiles' => $listProfiles,
            'nbPages'     => $nbPages,
            'page'        => $page,
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
    
        $sectionForms = array();
        foreach ($profile->getSections() as $section) {
            $sectionForm = $this->get('form.factory')->create(SectionType::class, $section);
            $sectionForms[] = $sectionForm->createView();
        }
        $newSectionForm = $this->get('form.factory')->create(SectionType::class, new Section());
        
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre annonce
            $em->flush();
    
            $request->getSession()->getFlashBag()->add('notice', "Le Curriculum Vitae de " . $profile->getFirstname() . " a bien été modifié.");
    
            return $this->redirectToRoute('rj_site_admin.cv.list');
        }
//         $profile->getServices();
        return $this->render('RJSiteAdminBundle:CV:edit.html.twig', array(
            'profile' => $profile,
            'form'    => $form->createView(),
            'sectionForms'    => $sectionForms,
            'newSectionForm' => $newSectionForm->createView()
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
    
    public function addSectionAction($profile_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository('RJSitePlatformBundle:CV\Profile')->find($profile_id);
        
        if (null === $profile) {
            throw new NotFoundHttpException("Le Curriculum Vitae avec l'id " . $id . " n'existe pas.");
        }
        
        $section = new Section();
        $section->setProfile($profile);
    
        $form = $this->createForm(SectionType::class, $section);
    
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
    
            if ($form->isValid()) {
    
                $em = $this->getDoctrine()->getManager();
                $em->persist($section);
                $em->flush();
    
                $request->getSession()->getFlashBag()->add('notice', 'Section bien enregistrée.');
    
                return $this->redirectToRoute('rj_site_admin.cv.edit', array('id' => $profile_id));
            }
        }
        return $this->redirectToRoute('rj_site_admin.cv.list'/*, array('id' => $advert->getId())*/);
    }
    
    public function editSectionAction($id, Request $request)
    {
        $response = "Error";
        if ($isAjax = $request->isXmlHttpRequest()) {
           if ($params = $request->request->get('params')) {
               
               $em = $this->getDoctrine()->getManager();
               $section = $em->getRepository('RJSitePlatformBundle:CV\Section')->find($id);
               
               foreach ($params as $param) {
                   if ($param['name'] == 'section[title]') {
                       $section->setTitle($param['value']);
                   } elseif ($param['name'] == 'section[position]') {
                       $section->setPosition($param['value']);
                   }
               }
               $em->flush();
        
               $response = 'OK';
           }
        }
       
        return new Response($response);
        
    }
    
    public function deleteSectionAction($id, Request $request)
    {
        $response = "Error";
        if ($isAjax = $request->isXmlHttpRequest()) {
                 
            $em = $this->getDoctrine()->getManager();
            $section = $em->getRepository('RJSitePlatformBundle:CV\Section')->find($id);
            
            if ($section) {
                $em->remove($section);
                $em->flush();
                $response = 'OK';
            }

        }
         
        return new Response($response);
    
    }
    
    public function addExperienceAction($section_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $section = $em->getRepository('RJSitePlatformBundle:CV\Section')->find($section_id);
    
        if (null === $section) {
            throw new NotFoundHttpException("La section " . $section_id . " du Curriculum Vitae n'existe pas.");
        }
       
        $experience = new Experience();
        $experience->setSection($section);
        $form = $this->createForm(ExperienceType::class, $experience);
        
        $profile = $section->getProfile();
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
    
            if ($form->isValid()) {
    
                $em = $this->getDoctrine()->getManager();
                $em->persist($experience);
                $em->flush();
    
                $request->getSession()->getFlashBag()->add('notice', 'Experience bien enregistrée.');
    
                return $this->redirectToRoute('rj_site_admin.cv.edit' , array('id' => $profile->getId()));
            }
        }
    
        return $this->render('RJSiteAdminBundle:CV:editExperience.html.twig', array(
            'profile' => $profile,
            'form'   => $form->createView(),
        ));
    }
    
    public function editExperienceAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
    
        $experience = $em->getRepository('RJSitePlatformBundle:CV\Experience')->find($id);
    
        if (null === $experience) {
            throw new NotFoundHttpException("L'experience " . $id . " du Curriculum Vitae n'existe pas.");
        }
        if (null === $profile = $experience->getSection()->getProfile()) {
            throw new NotFoundHttpException("Le Curriculum Vitae de l'experience " . $id . " n'existe pas.");
        }
        
        $form = $this->get('form.factory')->create(ExperienceType::class, $experience);
    
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            // Inutile de persister ici, Doctrine connait déjà notre annonce
            $em->flush();
    
            $request->getSession()->getFlashBag()->add('notice', "L'experience " . $experience->getTitle() . " a bien été modifié.");
    
            return $this->redirectToRoute('rj_site_admin.cv.edit' , array('id' => $profile->getId()));
        }
        //         $profile->getServices();
        return $this->render('RJSiteAdminBundle:CV:editExperience.html.twig', array(
            'profile' 	=> $profile,
        	'experience' => $experience,
            'form'   	=> $form->createView(),
        ));
    }
    
    public function deleteExperienceAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
    
        $experience = $em->getRepository('RJSitePlatformBundle:CV\Experience')->find($id);
    
        if (null === experience) {
            throw new NotFoundHttpException("L'experience avec l'id ".$id." n'existe pas.");
        }
    
        $em->remove(experience);
        $em->flush();
    
        $request->getSession()->getFlashBag()->add('info', "L'annonce a bien été supprimée.");
    
        return $this->redirectToRoute('rj_site_admin.cv.list');
    }
    
}
