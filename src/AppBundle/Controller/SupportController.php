<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SupportController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //dump($request);

        $form = $this->createFormBuilder()
            ->add('from', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $message = \Swift_Message::newInstance()
                ->setSubject('Contact Form Submission')
                ->setFrom($form->getData()['from'])
                ->setTo('figlerrenata85@gmail.com')
                ->setBody($form->getData()['message'],
                    'text/plain');

            $this->get('mailer')->send($message);
//             $ourFormData = $form->getData();
            //dump($ourFormData);
//            $from = $ourFormData['from'];
//            $message = $ourFormData['message'];
            //dump($from, $message);
        }

        return $this->render('support/index.html.twig', ['our_form' => $form->createView(),]);
    }
}
