<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Service;
use App\Form\MessageType;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class ServiceController extends AbstractController
{
    /**
     * @param ServiceRepository $serviceRepository
     * @return Response
     */
    public function liste(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/index.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    /**
     * @param Request $request
     * @param ObjectManager $entityManager
     * @param UserInterface $user
     * @return Response
     */
    public function new(Request $request, ObjectManager $entityManager, UserInterface $user): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->setPublisher($user);
            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('success', 'le produit a bien était ajouté');

            return $this->redirectToRoute('app_services_liste');
        }

        return $this->render('service/new.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Service $service
     * @param Request $request
     * @param Message $message
     * @param Swift_Mailer $mailer
     * @return Response
     */
    public function show(Service $service, Request $request, Message $message, Swift_Mailer $mailer, UserInterface $user): Response
    {

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setPublisher($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            $this->email($mailer, $message);
        }

        return $this->render('service/show.html.twig', [
            'service' => $service,
            'messageForm' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Service $service
     * @return Response
     */
    public function edit(Request $request, Service $service): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app_services_liste', [
                'id' => $service->getId(),
            ]);
        }

        return $this->render('service/edit.html.twig', [
            'service' => $service,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Service $service
     * @return Response
     */
    public function delete(Request $request, Service $service): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_services_liste');
    }

    /**
     * @param Swift_Mailer $mailer
     * @param Message $message
     * @return Response
     */
    public function email(Swift_Mailer $mailer, Message $message): Response
    {
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
    }
}
