<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\ShortCode;

/**
 * ShortCode controller.
 *
 * @Route("/shortcode")
 */
class ShortCodeController extends Controller
{
    /**
     * Lists all ShortCode entities.
     *
     * @Route("/", name="shortcode")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:ShortCode')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($shortCodes, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('@App/ShortCode/index.html.twig', array(
            'shortCodes' => $shortCodes,
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
        $filterForm = $this->createForm('AppBundle\Form\ShortCodeFilterType');

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
            return $me->generateUrl('shortcode', $requestParams);
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
     * Displays a form to create a new ShortCode entity.
     *
     * @Route("/new", name="shortcode_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $shortCode = new ShortCode();
        $form   = $this->createForm('AppBundle\Form\ShortCodeType', $shortCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($shortCode);
            $em->flush();
            
            $editLink = $this->generateUrl('shortcode_edit', array('id' => $shortCode->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New shortCode was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'shortcode' : 'shortcode_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('@App/ShortCode/new.html.twig', array(
            'shortCode' => $shortCode,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a ShortCode entity.
     *
     * @Route("/{id}", name="shortcode_show")
     * @Method("GET")
     */
    public function showAction(ShortCode $shortCode)
    {
        $deleteForm = $this->createDeleteForm($shortCode);
        return $this->render('@App/ShortCode/show.html.twig', array(
            'shortCode' => $shortCode,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing ShortCode entity.
     *
     * @Route("/{id}/edit", name="shortcode_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ShortCode $shortCode)
    {
        $deleteForm = $this->createDeleteForm($shortCode);
        $editForm = $this->createForm('AppBundle\Form\ShortCodeType', $shortCode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($shortCode);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('shortcode_edit', array('id' => $shortCode->getId()));
        }
        return $this->render('@App/ShortCode/edit.html.twig', array(
            'shortCode' => $shortCode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a ShortCode entity.
     *
     * @Route("/{id}", name="shortcode_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ShortCode $shortCode)
    {
    
        $form = $this->createDeleteForm($shortCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($shortCode);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The ShortCode was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the ShortCode');
        }
        
        return $this->redirectToRoute('shortcode');
    }
    
    /**
     * Creates a form to delete a ShortCode entity.
     *
     * @param ShortCode $shortCode The ShortCode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ShortCode $shortCode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('shortcode_delete', array('id' => $shortCode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete ShortCode by id
     *
     * @Route("/delete/{id}", name="shortcode_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(ShortCode $shortCode){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($shortCode);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The ShortCode was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the ShortCode');
        }

        return $this->redirect($this->generateUrl('shortcode'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="shortcode_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:ShortCode');

                foreach ($ids as $id) {
                    $shortCode = $repository->find($id);
                    $em->remove($shortCode);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'shortCodes was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the shortCodes ');
            }
        }

        return $this->redirect($this->generateUrl('shortcode'));
    }
    

}
