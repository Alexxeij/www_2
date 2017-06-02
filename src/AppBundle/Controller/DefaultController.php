<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {

        $news = $this->get('doctrine')->getRepository('AppBundle:BlogPost')->findAll();
        $category = $this->get('doctrine')->getRepository('AppBundle:Category')->findAll();
        //dump($category);
        return ['news' => $news, 'category' => $category];
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
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('AppBundle:Comment')->findBy(array('id'=>$id));

        $blog = $this
            ->get('doctrine')
            ->getRepository('AppBundle:BlogPost')
            ->findBy(array('id' => $id));

        $comment = new Comment();
        $form = $this->createForm('AppBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('one_posts', array('id' => $comment->getId()));
        }
        dump($comments);
        return ['blog' => $blog,'comment' => $comment,'comments'=>$comments,
            'form' => $form->createView(),];
    }

    /**
     *
     * @Route("/it", name="it_posts")
     * @Template()
     */
    public function itAction()
    {
        $it_posts = $this->get('doctrine')->getRepository('AppBundle:BlogPost')->findBy(['category' => 1]);

        //dump($it_posts);
        return ['it_posts' => $it_posts];
    }

    /**
     *
     * @Route("/formula-one", name="formula_posts")
     * @Template()
     */
    public function formulaOneAction()
    {
        $it_posts = $this->get('doctrine')->getRepository('AppBundle:BlogPost')->findBy(['category' => 3]);

        //dump($it_posts);
        return ['it_posts' => $it_posts];
    }

    /**
     *
     * @Route("/discovery", name="discovery_posts")
     * @Template()
     */
    public function discoveryAction()
    {
        $it_posts = $this->get('doctrine')->getRepository('AppBundle:BlogPost')->findBy(['category' => 2]);

        //dump($it_posts);
        return ['it_posts' => $it_posts];
    }

}
