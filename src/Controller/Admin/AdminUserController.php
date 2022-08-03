<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    private $userRepository;
    public function __construct(UserRepository $userRepository, ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();

        $this->userRepository = $userRepository;
    }

    #[Route('/admin/users', name: 'admin_user_list')]
    public function index(): Response
    {
        $users = $this->userRepository->findAll();  

        // dd($users[0]->getUserApp()->toArray());

        return $this->render('admin/users/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/admin/users/create', name: 'admin_user_create')]
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new User();

        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newUser = $form->getData();

            $this->em->persist($newUser);
            $this->em->flush();

            return $this->redirectToRoute('admin_user_list');
        }

        return $this->render('admin/users/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/user/read/{id}', name: 'admin_user_read')]
    public function read($id): Response
    {
        $user = $this->userRepository->find($id); 

        return $this->render('admin/users/read.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/admin/user/update/{id}', name: 'admin_user_update')]
    public function update($id, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $this->userRepository->find($id);
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $user->setEmail($form->get('email')->getData());
            $user->setPassword($form->get('password')->getData());
            $user->setRole($form->get('role')->getData());
            $user->setIsVerified($form->get('isVerified')->getData());

            $this->em->flush();
            return $this->redirectToRoute('admin_user_list');
        }      

        return $this->render('admin/users/update.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/user/delete/{id}', methods:['GET','DELETE'], name: 'admin_user_delete')]
    public function delete($id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = $this->userRepository->find($id);
        $this->em->remove($user);
        $this->em->flush();

        return $this->redirectToRoute('admin_user_list');
     
    }
}
