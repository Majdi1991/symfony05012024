<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Form;


class RegistrationController extends AbstractController
{
    #[Route("/registration/{id}/delete", name: "user_delete", methods: ["GET"], requirements: ["id" => "\d+"])]
    public function delete($id , Request $request,UserRepository $userRepository, EntityManagerInterface $em)
    : Response 
    {
        $user = $userRepository->find((int)$id);
        $form = $this->createForm(RegistrationFormType::class, $user);
        if ($request->query->get('method')==='DELETE'){
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute('app_user');
        }
        return $this->render('registration/register.html.twig', [
            "user"=> $user,
            "registrationForm" => $form->createView()
        ]);
    }

    #[Route("/registration/{id}/edit", name: "user_edit", requirements: ["id" => "\d+"])]
    public function edit($id, Request $request, EntityManagerInterface $em, UserRepository $userRepository)
    {
        $user = $userRepository->find((int)$id);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $em->flush();
        }
        return $this->render("registration/register.html.twig", [
            "registrationForm" => $form->createView()
        ]);
        dd($form);
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request,  EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $data = $form->getData();
           $user = new User();
           $user->setName($data["name"]);
           $user->setLastname($data["lastname"]);
           $user->setEmail($data["email"]);
           $user->setPassword($data["plainPassword"]);
           $em -> persist($user);
           $em -> flush();
           dd($data,$user);

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
  
}