<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of ContactController
 *
 * @author louis
 */
class ContactController extends AbstractController {
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer) : Response {
        $contact = new Contact();
        $formContact = $this->createForm(ContactType::class, $contact);
        $formContact->handleRequest($request);
        
        if($formContact->isSubmitted()&&$formContact->isValid()) {
            $this->sendEmail($mailer, $contact);
            $this->addFlash("succes", "Message envoyé !");
            return $this->redirectToRoute('contact');
        }
        
        return $this->render("pages/contact.html.twig", [
            'contact' => $contact,
            'formcontact' => $formContact->createView()
        ]);
    }
    
    public function sendEmail (MailerInterface $mailer, Contact $contact) {
        $email = (new Email())
                ->from($contact->getEmail())
                ->to('contact@mesvoyages.com')
                ->subject('Message du site de voyages')
                ->html($this->renderView(
                        'pages/_email.html.twig', [
                            'contact' => $contact
                        ]
                    ),
                    'utf-8'
                )
            ;
            $mailer->send($email);
    }
}
