<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Repository\ProductRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  /**
   * @Route("/", name="home")
   * @return Response
   */
  public function home(ProductRepository $productRepository):Response
  {
    return $this->render('index.html.twig', [
      'products' => $productRepository->findBy(
        ['firstpage' => true, 'active' => true],
        ['price' => 'ASC']),
      'active' => 'home'
  ]);
  }

  /**
   * @Route("/about", name="about")
   * @return Response
   */
  public function about():Response
  {
    return $this->render('about/index.html.twig', [
      'active' => 'about'
    ]);
  }

  /**
   * @Route("/contact", name="contact")
   * @return Response
   */
  public function contact(Request $request, MailerInterface $mailer):Response
  {
      $form = $this->createForm(ContactFormType::class);

      $contact = $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
        $email = (new TemplatedEmail())
          ->from($contact->get('email')->getData())
          ->to(new Address('maildemo@la-boutique-design.site', 'LaBoutiqueDesign'))
          ->subject('Demande d\'information')
          ->htmlTemplate('contact/email.html.twig')
          ->context([
            'firstname' => $contact->get('firstname')->getData(),
            'lastname' => $contact->get('lastname')->getData(),
            'mail' => $contact->get('email')->getData(),
            'message' => $contact->get('message')->getData()
          ]);
        $mailer->send($email);

        $this->addFlash('message_email', 'Votre email a bien été envoyé, nous vous recontacterons prochainement.');

        return $this->redirectToRoute('contact');
      }

      return $this->render('contact/index.html.twig', [
          'formContact' => $form->createView(),
          'active' => 'contact'
      ]);
  }
}
