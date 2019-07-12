<?php

namespace App\Controller;

use App\Entity\Message;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailController extends AbstractController
{
    /**
     * @param Swift_Mailer $mailer
     * @param Request $request
     * @param Message $message
     * @return Response
     */
    public function index(Swift_Mailer $mailer, Request $request, Message $message)
    {
        $request->request = $message;
        $message->getMail();
        // Création du mail
        $mail = new Swift_Message();
        $mail->setSubject('Envoi de mail depuis SF4');
        $mail->setTo('alexendrain1412@gmail.com');
        $mail->setBody(
            $this->renderView($message),
            'text/html'
        );
        // Envoi du mail
        $mailer->send($mail);

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}
