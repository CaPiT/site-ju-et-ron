<?php

namespace RJSite\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RJSite\ContactBundle\Form\RequestType;
use RJSite\ContactBundle\Entity\Request as RequestEntity;
use Symfony\Component\Validator\Constraints\Email;

class PageController extends Controller
{
    public function requestAction(Request $request)
    {
        $requestEntity = new RequestEntity();

        $form = $this->createForm(RequestType::class, $requestEntity);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {
                
                $emailConstraint = new Email();
                
                $errorList = $this->get('validator')->validate($requestEntity->getEmail(), $emailConstraint);
                if (count($errorList) == 0) {
                
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($requestEntity);
                    $em->flush();
        
                    $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
                    
                    $form = $this->createForm(RequestType::class, new RequestEntity());
                } else {
                    $request->getSession()->getFlashBag()->add('error', $errorList);
                }
            }
        }

        return $this->render('RJSiteContactBundle:Page:request.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
