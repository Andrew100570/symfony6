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
use App\Repository\HistoryRepository;

class ExchangeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    //post
    #[Route('/exchange/values', name: 'app_exchange_post', methods: ['POST'])]
    public function postHistory(Request $request): Response
    {

        $firstIn  = json_decode($request->getContent(), true)['firstIn'];
        $secondIn = json_decode($request->getContent(), true)['secondIn'];

        $SearchRes = $this->entityManager->createQuery('SELECT h From App\Entity\History h WHERE h.firstIn = '.$firstIn);
        $results = $SearchRes->getResult();

        foreach ($results as $result) {
            $currentHistory = $this->entityManager->getRepository(History::class)->find($result->getId());
            $currentHistory->setFirstIn($secondIn)
                ->setSecondIn($firstIn)
                ->setFirstOut($currentHistory->getFirstOut())
                ->setSecondOut($currentHistory->getSecondOut())
                ->setDataUtworzenia(($currentHistory->getDataUtworzenia()))
                ->setDataAktualizacji(new DateTimeImmutable());
            $this->entityManager->persist($currentHistory);
            $this->entityManager->flush();

        }

        return JsonResponse::fromJsonString('Wartości secondIn i firstIn są zamieniane');
    }

    #[Route('/values', name: 'app_exchange_all', methods: ['GET'])]
    public function getAllHistory(HistoryRepository $historyRepository): Response
    {
        $histories = $historyRepository->findAll();


        return $this->render('history/all.html.twig', [
            'histories' => $histories
        ]);
    }
}
