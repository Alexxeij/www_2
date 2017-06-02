<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {

        $news = $this->get('doctrine')->getRepository('AppBundle:BlogPost')->findAll();
        //dump($news);
        return ['news' => $news];
    }

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

    /**
     * Single post - by id
     * @Route("/show/{id}", name="one_posts")
     * @Template()
     */
    public function showAction($id)
    {
        $blog = $this
            ->get('doctrine')
            ->getRepository('AppBundle:BlogPost')
            ->findBy(array('id'=>$id));
        return ['blog' => $blog];
    }
}
