<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;
use App\Entity\ChambreHote;
use App\Form\ClientType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;






class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

 
/**
 * @Route("/add", name="add_client")
 */
public function ajouter2(Request $request)
{
    $client = new Client();
    $form = $this->createForm(ClientType::class, $client);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();

        return $this->redirectToRoute('HOMECLIENT');
    }

    return $this->render('client/add.html.twig', [
        'f' => $form->createView(),
    ]);
}



       // home
/**
 * @Route("/ClientH", name="HOMECLIENT")
 */
public function home1(Request $request)
{
    // Création du champ critère
    $form = $this->createFormBuilder()
        ->add("critere", TextType::class)
        ->add('valider', SubmitType::class)
        ->getForm();

    $form->handleRequest($request);

    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository(Client::class);
    $lesClients = $repo->findAll(); // Initialisation à tous les clients par défaut

    // Lancer la recherche quand on clique sur le bouton
    if ($form->isSubmitted()) {
        $data = $form->getData();
        $lesClients = $repo->recherche($data['critere']);
    }

    return $this->render('client/ClientH.html.twig', [
        'lesClients' => $lesClients,
        'form' => $form->createView()
    ]);
}



}
