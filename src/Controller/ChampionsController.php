<?php

namespace App\Controller;

use RiotAPI\LeagueAPI\LeagueAPI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChampionsController extends AbstractController
{
    public function __construct(
        private readonly LeagueAPI $leagueApi
    ) {
    }

    #[Route("/champions", name: "champions")]
    public function index(): Response
    {
        return $this->render('champions/index.html.twig');
    }

    #[Route("/champions/list", name: "champions.list")]
    public function list(Request $request): Response
    {
        $sortType = (int) $request->query->get('sortType', 1);
        $filterName = $request->query->get('filterName');

        $champions = $this->leagueApi->getStaticChampions()->data;

        if ($filterName !== null) {
            $champions = array_filter($champions, static function ($champion) use ($filterName) {
                return str_contains(strtolower($champion->name), strtolower($filterName));
            });
        }

        usort($champions, static function ($a, $b) use ($sortType) {
            return match ($sortType) {
                1 => $a->name >= $b->name,
                2 => $a->name <= $b->name,
                3 => $a->key >= $b->key,
                4 => $a->key <= $b->key,
                default => 0
            };
        });

        return $this->render('champions/list.html.twig', [
            'champions' => $champions
        ]);
    }
}
