<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\TypeService;

/**
 * TypeService controller.
 *
 * @Route("/typeservice")
 */
class TypeServiceController extends Controller
{
    /**
     * Lists all TypeService entities.
     *
     * @Route("/", name="typeservice")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:TypeService')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($typeServices, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('typeservice/index.html.twig', array(
            'typeServices' => $typeServices,
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
        $filterForm = $this->createForm('AppBundle\Form\TypeServiceFilterType');

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
            return $me->generateUrl('typeservice', $requestParams);
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
     * Displays a form to create a new TypeService entity.
     *
     * @Route("/new", name="typeservice_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $typeService = new TypeService();
        $form   = $this->createForm('AppBundle\Form\TypeServiceType', $typeService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeService);
            $em->flush();
            
            $editLink = $this->generateUrl('typeservice_edit', array('id' => $typeService->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New typeService was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'typeservice' : 'typeservice_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('typeservice/new.html.twig', array(
            'typeService' => $typeService,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a TypeService entity.
     *
     * @Route("/{id}", name="typeservice_show")
     * @Method("GET")
     */
    public function showAction(TypeService $typeService)
    {
        $deleteForm = $this->createDeleteForm($typeService);
        return $this->render('typeservice/show.html.twig', array(
            'typeService' => $typeService,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing TypeService entity.
     *
     * @Route("/{id}/edit", name="typeservice_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeService $typeService)
    {
        $deleteForm = $this->createDeleteForm($typeService);
        $editForm = $this->createForm('AppBundle\Form\TypeServiceType', $typeService);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeService);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('typeservice_edit', array('id' => $typeService->getId()));
        }
        return $this->render('typeservice/edit.html.twig', array(
            'typeService' => $typeService,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a TypeService entity.
     *
     * @Route("/{id}", name="typeservice_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeService $typeService)
    {
    
        $form = $this->createDeleteForm($typeService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeService);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The TypeService was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the TypeService');
        }
        
        return $this->redirectToRoute('typeservice');
    }
    
    /**
     * Creates a form to delete a TypeService entity.
     *
     * @param TypeService $typeService The TypeService entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeService $typeService)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typeservice_delete', array('id' => $typeService->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete TypeService by id
     *
     * @Route("/delete/{id}", name="typeservice_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(TypeService $typeService){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($typeService);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The TypeService was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the TypeService');
        }

        return $this->redirect($this->generateUrl('typeservice'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="typeservice_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:TypeService');

                foreach ($ids as $id) {
                    $typeService = $repository->find($id);
                    $em->remove($typeService);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'typeServices was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the typeServices ');
            }
        }

        return $this->redirect($this->generateUrl('typeservice'));
    }
    

}
