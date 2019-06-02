<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Service;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Emmision;

/**
 * Emmision controller.
 *
 * @Route("/emmision")
 */
class EmmisionController extends Controller
{
    /**
     * Lists all Emmision entities.
     *
     * @Route("/", name="emmision")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Emmision')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($emmisions, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('emmision/index.html.twig', array(
            'emmisions' => $emmisions,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
            'totalOfRecordsString' => $totalOfRecordsString,

        ));
    }


    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter($queryBuilder, $request)
    {
        $filterForm = $this->createForm('AppBundle\Form\EmmisionFilterType');

        // Bind values from the request
        $filterForm->handleRequest($request);

        if ($filterForm->isValid()) {
            // Build the query from the given form object
            $this->get('petkopara_multi_search.builder')->searchForm( $queryBuilder, $filterForm->get('search'));
        }

        return array($filterForm, $queryBuilder);
    }

    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder, Request $request)
    {
        //sorting
        $sortCol = $queryBuilder->getRootAlias().'.'.$request->get('pcg_sort_col', 'id');
        $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'desc'));
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($request->get('pcg_show' , 10));

        try {
            $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
        } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
            $pagerfanta->setCurrentPage(1);
        }
        
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me, $request)
        {
            $requestParams = $request->query->all();
            $requestParams['pcg_page'] = $page;
            return $me->generateUrl('emmision', $requestParams);
        };

        // Paginator - view
        $view = new TwitterBootstrap3View();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => 'previous',
            'next_message' => 'next',
        ));

        return array($entities, $pagerHtml);
    }
    
    
    
    /*
     * Calculates the total of records string
     */
    protected function getTotalOfRecordsString($queryBuilder, $request) {
        $totalOfRecords = $queryBuilder->select('COUNT(e.id)')->getQuery()->getSingleScalarResult();
        $show = $request->get('pcg_show', 10);
        $page = $request->get('pcg_page', 1);

        $startRecord = ($show * ($page - 1)) + 1;
        $endRecord = $show * $page;

        if ($endRecord > $totalOfRecords) {
            $endRecord = $totalOfRecords;
        }
        return "Showing $startRecord - $endRecord of $totalOfRecords Records.";
    }
    
    

    /**
     * Displays a form to create a new Emmision entity.
     *
     * @Route("/new", name="emmision_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $emmision = new Emmision();
        $form   = $this->createForm('AppBundle\Form\EmmisionType', $emmision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emmision);
            $service = new Service();
            $service->setEmmision($emmision);
            $em->persist($service);
            $em->flush();
            
            $editLink = $this->generateUrl('emmision_edit', array('id' => $emmision->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New emmision was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'emmision' : 'emmision_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('emmision/new.html.twig', array(
            'emmision' => $emmision,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Emmision entity.
     *
     * @Route("/{id}", name="emmision_show")
     * @Method("GET")
     */
    public function showAction(Emmision $emmision)
    {
        $deleteForm = $this->createDeleteForm($emmision);
        return $this->render('emmision/show.html.twig', array(
            'emmision' => $emmision,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Emmision entity.
     *
     * @Route("/{id}/edit", name="emmision_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Emmision $emmision)
    {
        $deleteForm = $this->createDeleteForm($emmision);
        $editForm = $this->createForm('AppBundle\Form\EmmisionType', $emmision);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emmision);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('emmision_edit', array('id' => $emmision->getId()));
        }
        return $this->render('emmision/edit.html.twig', array(
            'emmision' => $emmision,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Emmision entity.
     *
     * @Route("/{id}", name="emmision_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Emmision $emmision)
    {
    
        $form = $this->createDeleteForm($emmision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($emmision);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Emmision was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Emmision');
        }
        
        return $this->redirectToRoute('emmision');
    }
    
    /**
     * Creates a form to delete a Emmision entity.
     *
     * @param Emmision $emmision The Emmision entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Emmision $emmision)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('emmision_delete', array('id' => $emmision->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Emmision by id
     *
     * @Route("/delete/{id}", name="emmision_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Emmision $emmision){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($emmision);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Emmision was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Emmision');
        }

        return $this->redirect($this->generateUrl('emmision'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="emmision_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Emmision');

                foreach ($ids as $id) {
                    $emmision = $repository->find($id);
                    $em->remove($emmision);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'emmisions was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the emmisions ');
            }
        }

        return $this->redirect($this->generateUrl('emmision'));
    }
    

}
