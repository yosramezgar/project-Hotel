<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\ChambreHote;
use App\Entity\Client;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;



class ChambreHoteController extends AbstractController
{
    #[Route('/chambre/hote', name: 'app_chambre_hote')]
    public function index(): Response
    {
        return $this->render('chambre_hote/index.html.twig', [
            'controller_name' => 'ChambreHoteController',
        ]);
    }

     /**
* @Route("/Ajouter", name="Ajouter")
*/
 public function ajouter(Request $request)
 {
 $chambre_hote = new ChambreHote();
 $fb = $this->createFormBuilder($chambre_hote)
 ->add('nom_chambre', TextType::class)
 ->add('capacite', IntegerType::class, array("label" => "Capacité"))
 ->add('price', NumberType::class)
 ->add('Valider', SubmitType:: class);
 // générer le formulaire à partir du FormBuilder
 $form = $fb->getForm();
 $form->handleRequest($request);
 if($form->isSubmitted()){
     $em=$this->getDoctrine()->getManager();
     $em->persist($chambre_hote);
     $em->flush();
     return $this->redirectToRoute('HOME');
 }
 // Utiliser la methode createView() pour que l'objet soit exploitable par la vue
 return $this->render('chambre_hote/ajouter.html.twig',
 ['f' => $form->createView()] );
 }




 /**
* @Route("/", name="HOME")
*/
public function home(Request $request)
{
    //creation du champ critere
    $form = $this->createFormBuilder()
    ->add("critere",TextType::class)
    ->add('valider',SubmitType::class)
    ->getForm();
    $form->handleRequest($request);

   $em = $this ->getDoctrine()->getManager();
   $repo = $em ->getRepository(ChambreHote::class);
   $lesChambres = $repo ->findAll();

    // lancer la recherche quand on clique sur le boutton
    if ($form->isSubmitted())
    {
        $data = $form->getData();
        $lesChambres = $repo->recherche($data['critere']);
    }

   return $this->render('chambre_hote/home.html.twig',
   ['lesChambres' => $lesChambres,'form' =>$form->createView()]);

}

/**
* @Route("/editU/{id}", name="edit_user")
* Method({"GET","POST"})
*/
public function edit(Request $request, $id)
{ $chambre_hote = new ChambreHote();
$chambre_hote = $this->getDoctrine()
->getRepository(ChambreHote::class)
->find($id);
if (!$chambre_hote ) {
throw $this->createNotFoundException(
'No chambre_hote found for id '.$id
);
}
$fb = $this->createFormBuilder($chambre_hote)
 ->add('nom_chambre', TextType::class)
 ->add('capacite', IntegerType::class, array("label" => "Capacité"))
 ->add('price', NumberType::class)
 ->add('Valider', SubmitType:: class);
// générer le formulaire à partir du FormBuilder
$form = $fb->getForm();
$form->handleRequest($request);
if ($form->isSubmitted()) {
$entityManager = $this->getDoctrine()->getManager();
$entityManager->flush();
return $this->redirectToRoute('HOME');
}
return $this->render('chambre_hote/ajouter.html.twig',
['f' => $form->createView()] );
}

/**
* @Route("/supp/{id}", name="cand_delete")
*/
public function delete(Request $request,$id):Response
{
    $c = $this->getDoctrine()
    ->getRepository(ChambreHote::class)
    ->find($id);
    if(!$c)
    {
        throw $this->createNotFoundException('No chambre_hote found for id'.$id);
    }
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($c);
    $entityManager->flush();
    return $this->redirectToRoute('HOME');
}



}
