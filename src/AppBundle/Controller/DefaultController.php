<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $post = false;
        if ($request->getMethod() == 'POST'){
            $name = $request->request->get('name');
            $phone = $request->request->get('phone');
            $msg = $request->request->get('message');
            $file = $request->files->get('file');

            $message = new Message();
            $message->setName($name);
            $message->setPhone($phone);
            $message->setBody($msg);
            if ($file){
                $filename = time().'.'.$file->guessExtension();
                $file->move('/var/www/portfolio/', $filename);
                $message->setFile('/upload/'.$filename);
            }
            $this->getDoctrine()->getManager()->persist($message);
            $this->getDoctrine()->getManager()->flush($message);
            $post = true;
        }
        return ['post' => $post];
    }

    /**
     * @Route("/test", name="test")
     * @Template()
     */
    public function testAction(Request $request)
    {
        return [];
    }
}
