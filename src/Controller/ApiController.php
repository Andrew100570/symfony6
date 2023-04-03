<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\History;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;

class ApiController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/history', name: 'api_post', methods: ['POST'])]
    public function getApi(Request $request): Response
    {

        //Oczekiwanie requesty z danymi podawanymi w JSON(key-histories)
//
//        $data = '{
//        "histories":
//        [{
//          "firstIn":"1",
//          "secondIn":"1",
//          "firstOut":"1",
//          "secondOut":"1",
//          "data_utworzenia":"2000-01-01",
//          "data_aktualizacji":"2000-01-01"
//        },
//        {
//          "firstIn":"1",
//          "secondIn":"1",
//          "firstOut":"1",
//          "secondOut":"1",
//          "data_utworzenia":"2000-01-01",
//          "data_aktualizacji":"2000-01-01"
//        }]
//        }';

        //Dodanie nagłówka(x-auth-token), po którym sprawdzimy dostęp do zapisu danych przez API
        if ($request->headers->get('x-auth-token') !== 'dplp31qppIkvoxr3lIqsX77BrUrhDhsg9GFk9atO') {
            return JsonResponse::fromJsonString("HTTP_PRECONDITION_FAILED" , JsonResponse::HTTP_PRECONDITION_FAILED );
        }

        $data = json_decode($request->getContent(), true);

        foreach ($data['histories'] as $history) {
            $histories = new History();
            $histories->setFirstIn($history['firstIn'])
                ->setSecondIn($history['secondIn'])
                ->setFirstOut($history['firstOut'])
                ->setSecondOut($history['secondOut'])
                ->setDataUtworzenia($history['data_utworzenia'])
                ->setDataAktualizacji($history['data_aktualizacji']);

            $this->entityManager->persist($histories);
            $this->entityManager->flush();

        };

        return JsonResponse::fromJsonString('Zapisy zapisane!', JsonResponse::HTTP_OK);
    }

}
