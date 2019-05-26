<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Lot;

/**
 * Lot controller.
 *
 * @Route("/lot")
 */
class LotController extends Controller
{
    /**
     * Lists all Lot entities.
     *
     * @Route("/", name="lot")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Lot')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($lots, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('lot/index.html.twig', array(
            'lots' => $lots,
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
        $filterForm = $this->createForm('AppBundle\Form\LotFilterType');

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
            return $me->generateUrl('lot', $requestParams);
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
     * Displays a form to create a new Lot entity.
     *
     * @Route("/new", name="lot_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $lot = new Lot();
        $form   = $this->createForm('AppBundle\Form\LotType', $lot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lot);
            $em->flush();
            
            $editLink = $this->generateUrl('lot_edit', array('id' => $lot->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New lot was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'lot' : 'lot_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('lot/new.html.twig', array(
            'lot' => $lot,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Lot entity.
     *
     * @Route("/{id}", name="lot_show")
     * @Method("GET")
     */
    public function showAction(Lot $lot)
    {
        $deleteForm = $this->createDeleteForm($lot);
        return $this->render('lot/show.html.twig', array(
            'lot' => $lot,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Lot entity.
     *
     * @Route("/{id}/edit", name="lot_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lot $lot)
    {
        $deleteForm = $this->createDeleteForm($lot);
        $editForm = $this->createForm('AppBundle\Form\LotType', $lot);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lot);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('lot_edit', array('id' => $lot->getId()));
        }
        return $this->render('lot/edit.html.twig', array(
            'lot' => $lot,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Lot entity.
     *
     * @Route("/{id}", name="lot_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lot $lot)
    {
    
        $form = $this->createDeleteForm($lot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lot);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Lot was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Lot');
        }
        
        return $this->redirectToRoute('lot');
    }
    
    /**
     * Creates a form to delete a Lot entity.
     *
     * @param Lot $lot The Lot entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lot $lot)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lot_delete', array('id' => $lot->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Lot by id
     *
     * @Route("/delete/{id}", name="lot_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Lot $lot){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($lot);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Lot was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Lot');
        }

        return $this->redirect($this->generateUrl('lot'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="lot_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Lot');

                foreach ($ids as $id) {
                    $lot = $repository->find($id);
                    $em->remove($lot);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'lots was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the lots ');
            }
        }

        return $this->redirect($this->generateUrl('lot'));
    }
    

}
