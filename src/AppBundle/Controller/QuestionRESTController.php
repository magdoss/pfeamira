<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Question;
use AppBundle\Form\QuestionType;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View as FOSView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Voryx\RESTGeneratorBundle\Controller\VoryxController;

/**
 * Question controller.
 *
 * @RouteResource("Question")
 */
class QuestionRESTController extends VoryxController
{
    /**
     * Get a Question entity
     *
     * @View(
     *   serializerGroups={"Default"},
     *   serializerEnableMaxDepthChecks=true
     * )
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response|Question
     */
    public function getAction(Request $request, Question $entity)
    {
        return $entity;
    }

    /**
     * Get all Question entities.
     *
     * @View(
     *   serializerGroups={"Default"},
     *   serializerEnableMaxDepthChecks=true
     * )
     *
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return FOSView|Response
     *
     * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing entities.")
     * @QueryParam(name="limit", requirements="\d+", default="20", description="How many entities to return.")
     * @QueryParam(name="order_by", nullable=true, map=true, description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC")
     * @QueryParam(name="filters", nullable=true, map=true, description="Filter by fields. Must be an array ie. &filters[id]=3")
     */
    public function cgetAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        try {
            $offset = $paramFetcher->get('offset');
            $limit = $paramFetcher->get('limit');
            $order_by = !is_null($paramFetcher->get('order_by')) ? $paramFetcher->get('order_by') : array();
            $filters = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('filters') : array();

            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('AppBundle:Question')->findBy($filters, $order_by, $limit, $offset);
            if ($entities) {
                return $entities;
            }
            return FOSView::create('Not Found', Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a Question entity.
     *
     * @View(
     *   serializerGroups={"Default"},
     *   statusCode=201,
     *   serializerEnableMaxDepthChecks=true
     * )
     *
     * @param Request $request
     *
     * @return FOSView|Response|Question
     */
    public function postAction(Request $request)
    {
        $entity = new Question();
        $form = $this->createForm(QuestionType::class, $entity, array("method" => $request->getMethod()));
        $this->removeExtraFields($request, $form);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $entity;
        }

        return FOSView::create(array('errors' => $form->getErrors()), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Update a Question entity.
     *
     * @View(
     *   serializerGroups={"Default"},
     *   serializerEnableMaxDepthChecks=true
     * )
     *
     * @param Request $request
     * @param $entity
     *
     * @return FOSView|Response|Question
     */
    public function putAction(Request $request, Question $entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $request->setMethod('PATCH'); //Treat all PUTs as PATCH
            $form = $this->createForm(QuestionType::class, $entity, array("method" => $request->getMethod()));
            $this->removeExtraFields($request, $form);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();

                return $entity;
            }

            return FOSView::create(array('errors' => $form->getErrors()), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Partial Update to a Question entity.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @param $entity
     *
     * @return Response
     */
    public function patchAction(Request $request, Question $entity)
    {
        return $this->putAction($request, $entity);
    }

    /**
     * Delete a Question entity.
     *
     * @View(statusCode=204)
     *
     * @param Request $request
     * @param $entity
     *
     * @return FOSView|Response
     */
    public function deleteAction(Request $request, Question $entity)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();

            return null;
        } catch (\Exception $e) {
            return FOSView::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
