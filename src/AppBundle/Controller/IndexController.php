<?php

namespace AppBundle\Controller;

use AppBundle\Service\DecklistManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param DecklistManager        $decklistManager
     * @return Response
     * @throws \Doctrine\DBAL\DBALException
     */
    public function indexAction(Request $request, EntityManagerInterface $entityManager, DecklistManager $decklistManager)
    {
        $response = new Response();
        $response->setPublic();
        $response->setMaxAge($this->getParameter('short_cache'));

        // decklist of the week
        $dbh = $entityManager->getConnection();
        $rows = $dbh->executeQuery("SELECT decklist FROM highlight WHERE id=?", [1])->fetchAll();
        $decklist = count($rows) ? json_decode($rows[0]['decklist']) : null;

        // recent decklists
        $decklists_recent = $decklistManager->recent(0, 10, false)['decklists'];

        return $this->render(

            'Default/index.html.twig',
            [
                'pagetitle'       => "Netrunner Cards and Deckbuilder",
                'pagedescription' => "Build your deck for a fan-made modification of Android:Netrunner, the LCG by Fantasy Flight Games.",
                'decklists'       => $decklists_recent,
                'decklist'        => $decklist,
                'url'             => $request->getRequestUri(),
            ],

            $response

        );
    }
}
