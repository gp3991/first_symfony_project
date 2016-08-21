<?php
/**
 * Created by PhpStorm.
 * User: piotr
 * Date: 21.08.16
 * Time: 17:39
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class HomeController extends Controller {

    /**
     * @Route("/hello")
     */
    public function helloAction()
    {
        return new Response("Hello, World!");
    }

    /**
     * @Route("/hello/{name}")
     */
    public function helloActionTwo($name)
    {
        return new Response("Hello, ".$name);
    }


    /**
     * @Route("/template/{var}")
     */
    public function templateAction($var)
    {

        return $this->render('test/test.html.twig', [
            'var' => $var,
        ]);

    }

    /**
     * @Route("/api/test", name="test_json_response")
     * @Method("GET")
     */
    public function testJsonAction(){

        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $users = $serializer->serialize($users, 'json');

        return new Response($users);

    }

    /**
     * @Route("/api/seed")
     * @Method("GET")
     */
    public function insertDataAction(){
        $user = new User();

        $user->setLogin('user');

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();


        return new Response('<html><body>user created</body></html>');

    }


} 