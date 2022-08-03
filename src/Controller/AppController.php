<?php

namespace App\Controller;

use App\Entity\AppList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class AppController extends AbstractController
{
    
    #[Route('/app', name: 'app_list', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $items = $doctrine->getRepository(AppList::class)->findAll();
       
        foreach($items as $i){
            $item[] = [
                'id' => $i->getId(),
                'name' => $i->getName(),
                'description' => $i->getDescription()
            ];      
        }
         return $this->json($item);     
    }

    #[Route('/app/get/{id}', name: 'app_read', methods: ['GET'])]
    public function read($id, ManagerRegistry $doctrine): Response
    {
        $item = $doctrine->getRepository(AppList::class)->find($id);
   
        $item = [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'description' => $item->getDescription()
        ];

        return $this->json($item);
       
    }

    #[Route('/app/post', name: 'app_post', methods: ['POST'])]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $app = new AppList();
        $data = json_decode($request->getContent(), true);

        $app->setName($data['name']);
        $app->setDescription($data['description']);

        $em = $doctrine->getManager();
        $em->persist($app);
        $em->flush();

        return $this->json([
            'create done'], 200);
    }

    #[Route('/app/update/{id}', name: 'app_update', methods: ['PUT'])]
    public function update(Request $request, $id, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $update = $doctrine->getRepository(AppList::class)->find($id);

        $data = json_decode($request->getContent(), true);

        $update->setName($data['name']);
        $update->setDescription($data['description']);

        $em = $doctrine->getManager();
        $em->persist($update);
        $em->flush();

        return $this->json([
            'updated'], 200);
    }

    #[Route('/app/delete/{id}', name: 'app_delete', methods: ['DELETE'])]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $data = $doctrine->getRepository(AppList::class)->find($id); 

        $em = $doctrine->getManager();
        $em->remove($data);
        $em->flush();

        return $this->json([
            'deleted'], 200);
    }

}
