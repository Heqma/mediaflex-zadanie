<?php

namespace App\Controller\Admin;

use App\Entity\AppList;
use App\Form\AppFormType;
use App\Repository\AppListRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAppController extends AbstractController
{
    private $AppListRepository;
    public function __construct(AppListRepository $AppListRepository, ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();

        $this->AppListRepository = $AppListRepository;
    }

    #[Route('/admin/app', name: 'admin_app_list')]
    public function index(): Response
    {
     
        $applists = $this->AppListRepository->findAll();  
        
        return $this->render('admin/app/index.html.twig', [
            'applists' => $applists
        ]);
    }

    #[Route('/admin/app/create', name: 'admin_app_create')]
    public function create(Request $request): Response
    {
        $applist = new AppList();

        $form = $this->createForm(AppFormType::class, $applist);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newApp = $form->getData();

            $this->em->persist($newApp);
            $this->em->flush();

            return $this->redirectToRoute('admin_app_list');
        }

        return $this->render('admin/app/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/app/update/{id}', name: 'admin_app_update')]
    public function update($id, Request $request): Response
    {
        $applist = $this->AppListRepository->find($id);
        $form = $this->createForm(AppFormType::class, $applist);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            
            $applist->setName($form->get('name')->getData());
            $applist->setDescription($form->get('description')->getData());

            $this->em->flush();
            return $this->redirectToRoute('admin_app_list');
        }      

        return $this->render('admin/app/update.html.twig', [
            'applist' => $applist,
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/app/delete/{id}', methods:['GET','DELETE'], name: 'admin_app_delete')]
    public function delete($id): Response
    {
        $applist = $this->AppListRepository->find($id);
        $this->em->remove($applist);
        $this->em->flush();

        return $this->redirectToRoute('admin_app_list');
     
    }
}
