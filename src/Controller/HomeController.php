<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactData = $form->getData();

            $email = (new Email())
                ->from($contactData['email'])
                ->to('admin@ssc.com')
                ->subject('Nouveau message de contact')
                ->text(sprintf(
                    "Nom : %s\nPrénom : %s\nEmail : %s\nTéléphone : %s\n\nMessage :\n%s",
                    $contactData['nom'],
                    $contactData['prenom'],
                    $contactData['email'],
                    $contactData['telephone'],
                    $contactData['texte']
                ));

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}