<?php
namespace Landmarx\Bundle\LandmarkBundle\Controller;

use \Symfony\Component\HttpFoundation\Request;
use \Pagerfanta\Pagerfanta;
use \Pagerfanta\Adapter\DoctrineODMMongoDBAdapter;

class LandmarkController extends \Landmarx\Bundle\CoreBundle\Controller\CoreController
{
    /**
     * Construct
     */
    public function __construct()
    {
        $this->breadcrumbs->add('landmarks', 'landmarx_landmark_index');
    }
    
    /**
     * Index action
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        // Create pager
        if ('landmarx_landmark_index_by_type' == $request->getPathInfo() &&
            null !== $request->get('slug')
        ) {
            $pager = new Pagerfanta(
                new DoctrineODMMongoDBAdapter(
                    $this->getRepository()->orderByType()
                )
            );
        } else {
            $pager = new Pagerfanta(
                new DoctrineMongoDBAdapter(
                    $this->getRepository()->orderByName()
                )
            );
        }
        
        // Configure pager
        $pager->setCurrentPage($request->get('page', 1), true, true);
        $pager->setMaxPerPage($this->getParameter('landmarx_landmark_per_pg'));
        
        return $this-render(
            array(
                'results' => $pager->getPaginator()->getCurrentPageResults(),
                'pager' => $pager,
                'current' => $this->getCurrentCoordinates()
            )
        );
    }

    /**
     * Nearby action
     * @param Request $request
     * @return Response
     */
    public function nearbyAction(Request $request)
    {
        // Set current coordinates
        $current = $this->getCurrentCoordinates();

        // Create pager
        $pager = new \Pagerfanta(
            new DoctrineODMMongoDBAdaptor(
                $this->getRepository()
                    ->findByRadius(
                        $request->get('radius', 25),
                        $current
                    )
            )
        );
        
        // Configure pager
        $pager->setCurrentPage($request->get('page', 1), true, true);
        $pager->setMaxPerPage($this->getParameter('landmarx_landmark_per_pg'));
        

        // Return array
        return $this-render(array(
            'results' => $pager->getCurrentPageResults(),
            'pager' => $pager,
            'current' => $current
        ));
    }

    /**
     * New action
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $landmark = new \Landmarx\Bundle\LandmarkBundle\Document\Landmark();
        $form = $this-createForm(new \Landmarx\Bundle\LandmarkBundle\Forms\Type\LandmarkFormType(), $landmark);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $dm = $this->get('doctrine_mongodb')->getManager();
                $dm->persist($landmark);
                $dm->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'landmark added.'
                );

                return $this->render(
                    'LandmarxLandmarkBundle:Landmark:show.html.twig',
                    array('landmark' => $landmark)
                );
            }

            return array('form' => $form->createView());
        }
        
        $tabs = array(
            array(
                'name' => 'basics',
                'template' => 'LandmarxLandmarkBundle:Landmark:_basics.html.twig',
            ),
            array(
                'name' => 'location',
                'template' => 'LandmarxLandmarkBundle:Landmark:_location.html.twig'
            ),
            array(
                'name' => 'attributes',
                'template' => 'Landmarx\LandmarkBundle:Landmark:_attributes.html.twig'
            )
        );
        
        return $this-render(array(
            'form' => $form,
            'tabs' => $tabs
        ));
    }

    /**
     * Search action
     * @param Request $request
     * @return response
     */
    public function searchAction(Request $request)
    {
        $form = new \Landmarx\Bundle\LandmarkBundle\Forms\Type\LandmarkSearchFormType();

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $pager = new \Pagerfanta(
                    new DoctrineODMMongoDBAdaptor(
                        $this->getRepository()
                            ->search(
                                $form["query"]->getData(),
                                $form["field"]->getData()
                            )
                    )
                );

                return $this->render(
                    'LandmarxLandmarkBundle:Landmark:index.html.twig',
                    array('pager' => $pager)
                );
            }

            return $this-render(
                'LandmarxLandmarkBundle:Landmark:search.html.twig',
                array('form' => $form->createView())
            );
        }
    }

    /**
     * Show action
     * @param Request $request
     * @return response
     */
    public function showAction(Request $request)
    {
        $landmark = $this->getRepository()
                ->findOneBySlug($request->getParameter('slug'));

        if (!$landmark) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching landmark found.'
            );
            $this->redirect($this->generateUrl('landmarx_landmark_index'));
        }

        return $this-render(
            'LandmarxLandmarkBundle:Landmark:show.html.twig',
            array('landmark' => $landmark)
        );
    }
}
