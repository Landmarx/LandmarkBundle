<?php
namespace Landmarx\Bundle\LandmarkBundle\Controller;

use \Symfony\Component\HttpFoundation\Request;
use \Pagerfanta\Pagerfanta;
use \Pagerfanta\Adapter\DoctrineODMMongoDBAdapter;

class TypeController extends \Landmarx\Bundle\CoreBundle\Controller\Controller
{
    /**
     * Construct
     */
    public function __construct()
    {
        $this->breadcrumbs->add('landmarks', 'landmarx_landmark_index');
        $this->breadcrumbs->add('types', 'landmarx_landmark_type_index');
    }
    
    /**
     * Index action
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        // Create pager
        $pager = new Pagerfanta(
            new DoctrineODMMongoDBAdapter(
                $this->getRepository()->FindAll()
            )
        );
        
        // Configure pager
        $pager->setMaxPerPage($this->getRequest()->get('pageMax', 10));
        $pager->setCurrentPage($this->getRequest()->get('page', 1));

        return $this->render(
            'LandmarxLandmarkBundle:Type:index.html.twig',
            array(
                'results' => $pager->getCurrentPageResults(),
                'pager' => $pager
            )
        );
    }

    /**
     * Show action
     * @param Request $request
     * @return Response
     */
    public function showAction(Request $request)
    {
        $type = $this->getRepository()
            ->findOneBySlug($request-get('slug'));

        if (!$type) {
            $this->get('session')->getFlashBag()->add(
                'error',
                'no matching type found.'
            );
            $this->redirect($this->generateUrl('landmarx_landmark_type_index'));
        }

        return $this-render(
            'LandmarxLandmarkBundle:Type:show.html.twig',
            array('type' => $type)
        );
    }

    /**
     * New action
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $type = new \Landmarx\Bundle\LandmarkBundle\Model\Type();
        $form = $this->createForm(new \Landmarx\Bundle\LandmarkBundle\Form\Type\TypeFormType(), $type);

        if ("POST" == $request->getMethod()) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $dm = $this->get('doctrine_mongodb')->getManager();
                $dm->persist($type);
                $dm->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'landmark type added.'
                );

                return $this->render(
                    'LandmarxLandmarkBundle:Type:show.html.twig',
                    array('type' => $type)
                );
            }

            return $this-render(
                'LandmarxLandmarkBundle:Type:new.html.twig',
                array('form' => $form->createView())
            );
        }
    }
}
