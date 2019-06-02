<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Emmision;
use AppBundle\Entity\Quiz;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Service;

/**
 * Service controller.
 *
 * @Route("/service")
 */
class ServiceController extends Controller
{
    /**
     * Lists all Service entities.
     *
     * @Route("/", name="service")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Service')->createQueryBuilder('e');

        list($services, $pagerHtml) = $this->paginator($queryBuilder, $request);

        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);
        $servicesArray = [];
        /**
         * @var Service $service
         */
        foreach ($services as $service) {
            array_push($servicesArray, $service->getQuiz());
            array_push($servicesArray, $service->getEmmision());
            array_push($servicesArray, $service->getArticle());
        }
        $servicesArray = array_filter($servicesArray);
        $serviceData = [];
        foreach ($servicesArray as $sr) {
            $data = [];

            if ($sr instanceof Quiz) {
                /**
                 * @var Quiz $sr
                 */
                $data["type"] = "Quiz";
            } elseif ($sr instanceof Article) {
                /**
                 * @var Article $sr
                 */
                $data["type"] = "Article";
            } else {
                /**
                 * @var Emmision $sr
                 */
                $data["type"] = "Emmission";
            }

            $data["libelle"] = $sr->getLibelle();
            $data["id"] = $sr->getId();
            $data["description"] = $sr->getDescription();
            $data["isActive"] = $sr->getIsActive();
            $data["price"] = $sr->getPrice();
            $data["keyword"] = $sr->getKeyword();
            $data["shortcode"] = $sr->getShortCode()->getCode();
            array_push($serviceData, $data);
        }

        return $this->render('service/index.html.twig', array(
            'services' => $serviceData,
//            'pagerHtml' => $pagerHtml,
//            'totalOfRecordsString' => $totalOfRecordsString

        ));
    }


    /**
     * Get results from paginator and get paginator view.
     *
     */
    protected function paginator($queryBuilder, Request $request)
    {
        //sorting
        $sortCol = $queryBuilder->getRootAlias() . '.' . $request->get('pcg_sort_col', 'id');
        $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'desc'));
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($request->get('pcg_show', 10));

        try {
            $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
        } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
            $pagerfanta->setCurrentPage(1);
        }

        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function ($page) use ($me, $request) {
            $requestParams = $request->query->all();
            $requestParams['pcg_page'] = $page;
            return $me->generateUrl('service', $requestParams);
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
    protected function getTotalOfRecordsString($queryBuilder, $request)
    {
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
     * Finds and displays a Service entity.
     *
     * @Route("/{id}", name="service_show")
     * @Method("GET")
     */
    public function showAction(Service $service)
    {
        return $this->render('service/show.html.twig', array(
            'service' => $service,
        ));
    }


}
