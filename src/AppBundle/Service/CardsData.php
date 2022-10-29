<?php

namespace AppBundle\Service;

use AppBundle\Entity\Card;
use AppBundle\Entity\Cycle;
use AppBundle\Entity\Mwl;
use AppBundle\Entity\Pack;
use AppBundle\Entity\Review;
use AppBundle\Entity\Ruling;
use AppBundle\Entity\Rotation;
use AppBundle\Service\RotationService;
use AppBundle\Repository\PackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;



class CardsData
{
    public static $faction_letters = [
        'haas-bioroid'       => 'h',
        'weyland-consortium' => 'w',
        'anarch'             => 'a',
        'shaper'             => 's',
        'criminal'           => 'c',
        'jinteki'            => 'j',
        'nbn'                => 'n',
        'neutral-corp'       => '-',
        'neutral-runner'     => '-',
        'apex'               => 'p',
        'adam'               => 'd',
        'sunny-lebeau'       => 'u',
    ];

    public static $reboot_changed_codes = array('09019', '01055', '04052', '01018', '09037', '08003', '10011', '01047', '01097', '01057', '10097', '01079', '05041', '03008', '08073', '04087', '02038', '08091', '08048', '08112', '02083', '06080', '09029', '09030', '07044', '07001', '01053', '06064', '06079', '01081', '03040', '06119', '01025', '06076', '08093', '08099', '06012', '10056', '01042', '10098', '02035', '10050', '03013', '01059', '04021', '06053', '04085', '04089', '04090', '03050', '06055', '08049', '09039', '08010', '02014', '01082', '04112', '05043', '07016', '02073', '02119', '06037', '08018', '04114', '04068', '10022', '01074', '06094', '06099', '06096', '05013', '03001', '03009', '06069', '02046', '04014', '10010', '07017', '10089', '02036', '02060', '07045', '08044', '08111', '01075', '04055', '08055', '03038', '10049', '08001', '06115', '06116', '08027', '02025', '07008', '04025', '10037', '04113', '01065', '02120', '02005', '01030', '02089', '08046', '03002', '06013', '01005', '08050', '04086', '06098', '06033', '02102', '02096', '02103', '01076', '03027', '08107', '07036', '08103', '02118', '02072', '07026', '10017', '04042', '02108', '08072', '01003', '01024', '02048', '03010', '02061', '10021', '01009', '06072', '05055', '02064', '09042', '02020', '04103', '02028', '05032', '08095', '06120', '02053', '07028', '06093', '10112', '06042', '04037', '09053', '06024', '09033', '08089', '08005', '06102', '04027', '02092', '10092', '02039', '04084', '03030', '01066', '04045', '03032', '08119', '08075', '05033', '04106', '04007', '08061', '05034', '04071', '06075', '02032', '08086', '07018', '07004', '02117', '02062', '01020', '04001', '08114', '10045', '03033', '02040', '10108', '01017', '08067', '04065', '06084', '08013', '04017', '01087', '05044', '09026', '02077', '02070', '04046', '04020', '04097', '04099', '09050', '09049', '09048', '05024', '04110', '03011', '01054', '02010', '06071', '01102', '04023', '05001', '10032', '01061', '03015', '06023', '06101', '04031', '04082', '10004', '02095', '04004', '02071', '03016', '02085', '04051', '01112', '08070', '05028', '10109', '03017', '10105', '05016', '06113', '09038', '02106', '02068', '10016', '04016', '04057', '04050', '06103', '08090', '07033', '06114', '04015', '02012', '10006', '08012', '01067', '01033', '05029', '02090', '08052', '06063', '06031', '08104', '10104', '04063', '06095', '01023', '04064', '04026', '03024', '06085', '08057', '06039', '05037', '08029', '06089', '10103', '06065', '08074', '04116', '04095', '06104', '05051', '01089', '10007', '05014', '01108', '07046', '10114', '02113', '02116', '06007', '03018', '03036', '02004', '02105', '04035', '08068', '10018', '10055', '10036', '02044', '10019', '05015', '06004', '04119', '06017', '01080', '02114', '06005', '08019', '05021', '10040', '02041', '06038', '02075', '01072', '01077', '09002', '09014', '09009', '03003', '06002', '01027', '05002', '01001', '08053', '04038', '08097', '04088', '03039', '05054', '06058', '10080', '05053', '08076', '10038', '04108', '10031', '10030', '06015', '01012', '07021', '10063', '04002', '02006', '06062', '10066', '02086', '01046', '05023', '05036', '10051', '10043', '10026', '06044', '01095', '06016', '08101', '01073', '08017', '06006', '01106', '02059', '04010', '01069', '03006', '02050', '05038', '10090', '05047', '06060', '05025', '04049', '09012', '09006', '04024', '01091', '10093', '10041', '10033', '01105', '09015', '02016', '02093', '04070', '08088', '04003', '01064', '04077', '02111', '04044', '09025', '08054', '07050', '10044', '06117', '06082', '03047', '02098', '03054', '01092', '07023', '02023', '04105', '01099', '06034', '07019', '09046', '01096', '06112', '02034', '10053', '03007', '03025', '01104', '06050', '06092', '02030', '04115', '05019', '06107', '07034', '05030', '02099', '04101', '08042', '06090', '04056', '02027', '02015', '06018', '09003', '09016', '08004', '02002', '10064', '04069', '07051', '04091', '08038', '08028', '03014', '06087', '04018', '08007', '04083', '06009', '08110', '10023', '10082', '05012', '02047', '04075', '09022', '07011', '04036', '06021', '08120', '05007', '02008', '01040', '03029', '06008', '01041', '10085', '05049', '03012', '06035', '07003', '09017', '02017', '04047', '05022', '06078', '08008', '05050', '06108', '04074', '06106', '03022', '02078', '08030', '08080', '07053', '05039', '06036', '02074', '06110', '07030', '10061', '02021', '10095', '04080', '09011', '07047', '01063', '03019', '06109', '10048', '04098', '10091', '01078', '06047', '02076', '02001', '06032', '05040', '08108', '04118', '04048', '02057', '08116', '04030', '01016', '01013', '01014', '01071', '03020', '06097', '02007', '50003', '50006', '50007', '50011', '50013', '50014', '50017', '50022', '50025', '50026', '50030');

    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var PackRepository $packRepository */
    private $packRepository;

    /** @var RouterInterface $router */
    private $router;

    /** @var Packages $packages */
    private $packages;

    public function __construct(
        EntityManagerInterface $entityManager,
        RepositoryFactory $repositoryFactory,
        RouterInterface $router,
        Packages $packages
    ) {
        $this->entityManager = $entityManager;
        $this->packRepository = $repositoryFactory->getPackRepository();
        $this->router = $router;
        $this->packages = $packages;
    }

    /**
     * Searches for and replaces symbol tokens with markup in a given text.
     * @param string $text
     * @return string
     */
    public function replaceSymbols(string $text)
    {
        $map = [
            '[subroutine]'         => '<span class="icon icon-subroutine" aria-hidden="true"></span><span class="icon-fallback">subroutine</span>',
            '[credit]'             => '<span class="icon icon-credit" aria-hidden="true"></span><span class="icon-fallback">credit</span>',
            '[trash]'              => '<span class="icon icon-trash" aria-hidden="true"></span><span class="icon-fallback">trash</span>',
            '[click]'              => '<span class="icon icon-click" aria-hidden="true"></span><span class="icon-fallback">click</span>',
            '[recurring-credit]'   => '<span class="icon icon-recurring-credit" aria-hidden="true"></span><span class="icon-fallback">recurring credit</span>',
            '[mu]'                 => '<span class="icon icon-mu" aria-hidden="true"></span><span class="icon-fallback">memory unit</span>',
            '[link]'               => '<span class="icon icon-link" aria-hidden="true"></span><span class="icon-fallback">link</span>',
            '[anarch]'             => '<span class="icon icon-anarch" aria-hidden="true"></span><span class="icon-fallback">anarch</span>',
            '[criminal]'           => '<span class="icon icon-criminal" aria-hidden="true"></span><span class="icon-fallback">criminal</span>',
            '[shaper]'             => '<span class="icon icon-shaper" aria-hidden="true"></span><span class="icon-fallback">shaper</span>',
            '[jinteki]'            => '<span class="icon icon-jinteki" aria-hidden="true"></span><span class="icon-fallback">jinteki</span>',
            '[haas-bioroid]'       => '<span class="icon icon-haas-bioroid" aria-hidden="true"></span><span class="icon-fallback">haas bioroid</span>',
            '[nbn]'                => '<span class="icon icon-nbn" aria-hidden="true"></span><span class="icon-fallback">nbn</span>',
            '[weyland-consortium]' => '<span class="icon icon-weyland-consortium" aria-hidden="true"></span><span class="icon-fallback">weyland consortium</span>',
            '[interrupt]'          => '<span class="icon icon-interrupt" aria-hidden="true"></span><span class="icon-fallback">interrupt</span>',
        ];

        return str_replace(array_keys($map), array_values($map), $text);
    }

    public function allsetsnocycledata()
    {
        $list_packs = $this->packRepository->findBy([], ["dateRelease" => "ASC", "position" => "ASC"]);
        $packs = [];
        foreach ($list_packs as $pack) {
            $real = $pack->getCards()->count();
            $max = $pack->getSize();
            $packs[] = [
                "name"      => $pack->getName(),
                "code"      => $pack->getCode(),
                "number"    => $pack->getPosition(),
                "available" => $pack->getDateRelease() ? $pack->getDateRelease()->format('Y-m-d') : '',
                "known"     => intval($real),
                "total"     => $max,
                "url"       => $this->router->generate('cards_list', ['pack_code' => $pack->getCode()], UrlGeneratorInterface::RELATIVE_PATH),
            ];
        }

        return $packs;
    }

    public function allsetsdata()
    {
        /** @var Cycle[] $list_cycles */
        $list_cycles = $this->entityManager->getRepository(Cycle::class)->findBy([], ["position" => "ASC"]);
        $cycles = [];
        foreach ($list_cycles as $cycle) {
            $packs = [];
            $sreal = 0;
            $smax = 0;

            foreach ($this->packRepository->findByCycleWithCardCount($cycle) as $pack) {
                $sreal += $pack->getCardCount();
                $max = $pack->getSize();
                $smax += $max;
                $packs[] = [
                    "name"      => $pack->getName(),
                    "code"      => $pack->getCode(),
                    "available" => $pack->getDateRelease() ? $pack->getDateRelease()->format('Y-m-d') : '',
                    "known"     => $pack->getCardCount(),
                    "total"     => $max,
                    "url"       => $this->router->generate('cards_list', ['pack_code' => $pack->getCode()], UrlGeneratorInterface::RELATIVE_PATH),
                    "search"    => "e:" . $pack->getCode(),
                    "icon"      => $pack->getCycle()->getCode(),
                ];
            }

            if ($cycle->getSize() === 1) {
                $cycles[] = $packs[0];
            } else {
                $cycles[] = [
                    "name"   => $cycle->getName(),
                    "code"   => $cycle->getCode(),
                    "available"  => $packs[0]["available"],
                    "known"  => intval($sreal),
                    "total"  => $smax,
                    "url"    => $this->router->generate('cards_cycle', ['cycle_code' => $cycle->getCode()], UrlGeneratorInterface::RELATIVE_PATH),
                    "search" => 'c:' . $cycle->getCode(),
                    "packs"  => $packs,
                    "icon"   => $cycle->getCode(),
                ];
            }
        }

        return $cycles;
    }

    public function get_search_rows(array $conditions, string $sortorder, string $locale)
    {
        $i = 0;

        // Construction of the sql request
        $init = $this->entityManager->createQueryBuilder();
        $qb = $init->select('c', 'p', 'y', 't', 'f', 's')
           ->from(Card::class, 'c')
           ->leftJoin('c.pack', 'p')
           ->leftJoin('p.cycle', 'y')
           ->leftJoin('c.type', 't')
           ->leftJoin('c.faction', 'f')
           ->leftJoin('c.side', 's');

        $qb2 = null;
        $qb3 = null;
        $clauses = [];
        $parameters = [];

        foreach ($conditions as $condition) {
            $type = array_shift($condition);
            $operator = array_shift($condition);
            switch ($type) {
                case '': // title or index
                    $or = [];
                    foreach ($condition as $arg) {
                        $code = preg_match('/^\d\d\d\d\d$/u', $arg);
                        $acronym = preg_match('/^[A-Z]{2,}$/', $arg);
                        if ($code) {
                            $or[] = "(c.code = ?$i)";
                            $parameters[$i++] = $arg;
                        } elseif ($acronym) {
                            $or[] = "(BINARY(c.title) like ?$i)";
                            $parameters[$i++] = "%$arg%";
                            $like = implode('% ', str_split($arg));
                            $or[] = "(REPLACE(c.title, '-', ' ') like ?$i)";
                            $parameters[$i++] = "$like%";
                        } else {
                            if ($arg == 'Franklin') {
                                $arg = 'Crick';
                            } // easter egg
                            $or[] = "(c.title like ?$i)";
                            $parameters[$i++] = "%$arg%";
                        }
                    }
                    $clauses[] = implode(" or ", $or);
                    break;
                case 'x': // text
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(c.text like ?$i)";
                                break;
                            case '!':
                                $or[] = "(c.text not like ?$i)";
                                break;
                        }
                        $parameters[$i++] = "%$arg%";
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'a': // flavor
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(c.flavor like ?$i)";
                                break;
                            case '!':
                                $or[] = "(c.flavor not like ?$i)";
                                break;
                        }
                        $parameters[$i++] = "%$arg%";
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'e': // extension (pack)
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(p.code = ?$i)";
                                break;
                            case '!':
                                $or[] = "(p.code != ?$i)";
                                break;
                            case '<':
                                if (!isset($qb2)) {
                                    $qb2 = $this->entityManager->createQueryBuilder()->select('p2')->from(Pack::class, 'p2');
                                    $or[] = $qb->expr()->lt('p.dateRelease', '(' . $qb2->select('p2.dateRelease')->where("p2.code = ?$i")->getDQL() . ')');
                                }
                                break;
                            case '>':
                                if (!isset($qb3)) {
                                    $qb3 = $this->entityManager->createQueryBuilder()->select('p3')->from(Pack::class, 'p3');
                                    $or[] = $qb->expr()->gt('p.dateRelease', '(' . $qb3->select('p3.dateRelease')->where("p3.code = ?$i")->getDQL() . ')');
                                }
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'c': // cycle (cycle)
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(y.position = ?$i)";
                                break;
                            case '!':
                                $or[] = "(y.position != ?$i)";
                                break;
                            case '<':
                                $or[] = "(y.position < ?$i)";
                                break;
                            case '>':
                                $or[] = "(y.position > ?$i)";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 't': // type
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(t.code = ?$i)";
                                break;
                            case '!':
                                $or[] = "(t.code != ?$i)";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'f': // faction
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(f.code = ?$i)";
                                break;
                            case '!':
                                $or[] = "(f.code != ?$i)";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 's': // subtype (keywords)
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "((c.keywords = ?$i) or (c.keywords like ?" . ($i + 1) . ") or (c.keywords like ?" . ($i + 2) . ") or (c.keywords like ?" . ($i + 3) . "))";
                                $parameters[$i++] = "$arg";
                                $parameters[$i++] = "$arg %";
                                $parameters[$i++] = "% $arg";
                                $parameters[$i++] = "% $arg %";
                                break;
                            case '!':
                                $or[] = "(c.keywords is null or ((c.keywords != ?$i) and (c.keywords not like ?" . ($i + 1) . ") and (c.keywords not like ?" . ($i + 2) . ") and (c.keywords not like ?" . ($i + 3) . ")))";
                                $parameters[$i++] = "$arg";
                                $parameters[$i++] = "$arg %";
                                $parameters[$i++] = "% $arg";
                                $parameters[$i++] = "% $arg %";
                                break;
                        }
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'd': // side
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(SUBSTRING(s.code,1,1) = SUBSTRING(?$i,1,1))";
                                break;
                            case '!':
                                $or[] = "(SUBSTRING(s.code,1,1) != SUBSTRING(?$i,1,1))";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'i': // illustrator
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(c.illustrator = ?$i)";
                                break;
                            case '!':
                                $or[] = "(c.illustrator != ?$i)";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'o': // cost
                    $or = [];
                    foreach ($condition as $arg) {
                        if (($arg === 'x') or ($arg === 'X')) {
                            switch ($operator) {
                                case ':':
                                    $or[] = "(c.cost is null and (t.code not in ('agenda', 'identity')))";
                                    break;
                                case '!':
                                    $or[] = "(c.cost is not null)";
                                    break;
                            }
                        } else {
                            switch ($operator) {
                                case ':':
                                    $or[] = "(c.cost = ?$i)";
                                    break;
                                case '!':
                                    $or[] = "(c.cost != ?$i)";
                                    break;
                                case '<':
                                    $or[] = "(c.cost < ?$i)";
                                    break;
                                case '>':
                                    $or[] = "(c.cost > ?$i)";
                                    break;
                            }
                            $parameters[$i++] = $arg;
                        }
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'g': // advancementcost
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(c.advancementCost = ?$i)";
                                break;
                            case '!':
                                $or[] = "(c.advancementCost != ?$i)";
                                break;
                            case '<':
                                $or[] = "(c.advancementCost < ?$i)";
                                break;
                            case '>':
                                $or[] = "(c.advancementCost > ?$i)";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'm': // memoryunits
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(c.memoryCost = ?$i)";
                                break;
                            case '!':
                                $or[] = "(c.memoryCost != ?$i)";
                                break;
                            case '<':
                                $or[] = "(c.memoryCost < ?$i)";
                                break;
                            case '>':
                                $or[] = "(c.memoryCost > ?$i)";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'n': // influence or influenceLimit
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(c.factionCost = ?$i or c.influenceLimit =?$i)";
                                break;
                            case '!':
                                $or[] = "(c.factionCost != ?$i or c.influenceLimit != ?$i)";
                                break;
                            case '<':
                                $or[] = "(c.factionCost < ?$i or c.influenceLimit < ?$i)";
                                break;
                            case '>':
                                $or[] = "(c.factionCost > ?$i or c.influenceLimit > ?$i)";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'p': // strength
                    $or = [];
                    foreach ($condition as $arg) {
                        if (($arg === 'x') or ($arg === 'X')) {
                            switch ($operator) {
                                case ':':
                                    $or[] = "(c.strength is null and ((t.code = 'ice') or ((c.keywords = ?$i) or (c.keywords like ?" . ($i + 1) . ") or (c.keywords like ?" . ($i + 2) . ") or (c.keywords like ?" . ($i + 3) . "))))";
                                    $ib = "Icebreaker";
                                    $parameters[$i++] = "$ib";
                                    $parameters[$i++] = "$ib %";
                                    $parameters[$i++] = "% $ib";
                                    $parameters[$i++] = "% $ib %";
                                    break;
                                case '!':
                                    $or[] = "(c.strength is not null)";
                                    break;
                            }
                        } else {
                            switch ($operator) {
                                case ':':
                                    $or[] = "(c.strength = ?$i)";
                                    break;
                                case '!':
                                    $or[] = "(c.strength != ?$i)";
                                    break;
                                case '<':
                                    $or[] = "(c.strength < ?$i)";
                                    break;
                                case '>':
                                    $or[] = "(c.strength > ?$i)";
                                    break;
                            }
                            $parameters[$i++] = $arg;
                        }
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'v': // agendapoints
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(c.agendaPoints = ?$i)";
                                break;
                            case '!':
                                $or[] = "(c.agendaPoints != ?$i)";
                                break;
                            case '<':
                                $or[] = "(c.agendaPoints < ?$i)";
                                break;
                            case '>':
                                $or[] = "(c.agendaPoints > ?$i)";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'h': // trashcost
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(c.trashCost = ?$i)";
                                break;
                            case '!':
                                $or[] = "(c.trashCost != ?$i)";
                                break;
                            case '<':
                                $or[] = "(c.trashCost < ?$i)";
                                break;
                            case '>':
                                $or[] = "(c.trashCost > ?$i)";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'y': // quantity
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case ':':
                                $or[] = "(c.quantity = ?$i)";
                                break;
                            case '!':
                                $or[] = "(c.quantity != ?$i)";
                                break;
                            case '<':
                                $or[] = "(c.quantity < ?$i)";
                                break;
                            case '>':
                                $or[] = "(c.quantity > ?$i)";
                                break;
                        }
                        $parameters[$i++] = $arg;
                    }
                    $clauses[] = implode($operator == '!' ? " and " : " or ", $or);
                    break;
                case 'r': // release
                    $or = [];
                    foreach ($condition as $arg) {
                        switch ($operator) {
                            case '<':
                                $or[] = "(p.dateRelease <= ?$i)";
                                break;
                            case '>':
                                $or[] = "(p.dateRelease > ?$i or p.dateRelease IS NULL)";
                                break;
                        }
                        if ($arg == "now") {
                            $parameters[$i++] = new \DateTime();
                        } else {
                            $parameters[$i++] = new \DateTime($arg);
                        }
                    }
                    $clauses[] = implode(" or ", $or);
                    break;
                case 'u': // unique
                    if (($operator == ':' && $condition[0]) || ($operator == '!' && !$condition[0])) {
                        $clauses[] = "(c.uniqueness = 1)";
                    } else {
                        $clauses[] = "(c.uniqueness = 0)";
                    }
                    $i++;
                    break;
                case 'z': // rotation
                    // Instantiate the service only when its needed.
                    $rotationservice = new RotationService($this->entityManager);
                    $rotation = null;
                    if ($condition[0] == "current" || $condition[0] == "latest") {
                        $rotation = $rotationservice->findCurrentRotation();
                    } else {
                        $rotation = $rotationservice->findRotationByCode($condition[0]);
                    }
                    if ($rotation) {
                        // Add the valid cycles for the requested rotation and add them to the WHERE clause for the query.
                        $cycles = $rotation->normalize()["cycles"];
                        $placeholders = array();
                        foreach($cycles as $cycle) {
                        array_push($placeholders, "?$i");
                            $parameters[$i++] = $cycle;
                        }
                        $clauses[] = "(y.code in (" . implode(", ", $placeholders) . "))";
                    }
                    $i++;
                    break;
            }
        }

        if (count($clauses) === 0) {
            return [];
        }

        foreach ($clauses as $clause) {
            if(!empty($clause)) {
                $qb->andWhere($clause);
            }
        }
        foreach ($parameters as $index => $parameter) {
            $qb->setParameter($index, $parameter);
        }

        switch ($sortorder) {
            case 'name':
                $qb->orderBy('c.title');
                break;
            case 'set':
                $qb->orderBy('p.name')->addOrderBy('c.position');
                break;
            case 'release-date':
                $qb->orderBy('y.position')->addOrderBy('p.position')->addOrderBy('c.position');
                break;
            case 'faction':
                $qb->orderBy('c.side', 'DESC')->addOrderBy('c.faction')->addOrderBy('c.type');
                break;
            case 'type':
                $qb->orderBy('c.side', 'DESC')->addOrderBy('c.type')->addOrderBy('c.faction');
                break;
            case 'cost':
                $qb->orderBy('c.type')->addOrderBy('c.cost')->addOrderBy('c.advancementCost');
                break;
            case 'strength':
                $qb->orderBy('c.type')->addOrderBy('c.strength')->addOrderBy('c.agendaPoints')->addOrderBy('c.trashCost');
                break;
        }
        $query = $qb->getQuery();

        $rows = $query->getResult();

        return $rows;
    }

    /**
     * @param Card $card
     * @return array
     */
    public function getCardInfo(Card $card, string $locale)
    {
        static $cache = [];

        if (isset($cache[$card->getId()]) && isset($cache[$card->getId()][$locale])) {
            return $cache[$card->getId()][$locale];
        }

        $cardinfo = [
            "id"                => $card->getId(),
            "code"              => $card->getCode(),
            "title"             => $card->getTitle(),
            "type_name"         => $card->getType()->getName(),
            "type_code"         => $card->getType()->getCode(),
            "subtype"           => $card->getKeywords(),
            "text"              => $card->getText(),
            "advancementcost"   => $card->getAdvancementCost(),
            "agendapoints"      => $card->getAgendaPoints(),
            "baselink"          => $card->getBaseLink(),
            "cost"              => $card->getCost(),
            "faction_name"      => $card->getFaction()->getName(),
            "faction_code"      => $card->getFaction()->getCode(),
            "factioncost"       => $card->getFactionCost(),
            "flavor"            => $card->getFlavor(),
            "illustrator"       => $card->getIllustrator(),
            "influencelimit"    => $card->getInfluenceLimit(),
            "memoryunits"       => $card->getMemoryCost(),
            "minimumdecksize"   => $card->getMinimumDeckSize(),
            "position"          => $card->getPosition(),
            "quantity"          => $card->getQuantity(),
            "pack_name"         => $card->getPack()->getName(),
            "pack_code"         => $card->getPack()->getCode(),
            "side_name"         => $card->getSide()->getName(),
            "side_code"         => $card->getSide()->getCode(),
            "strength"          => $card->getStrength(),
            "trash"             => $card->getTrashCost(),
            "uniqueness"        => $card->getUniqueness(),
            "limited"           => $card->getDeckLimit(),
            "cycle_name"        => $card->getPack()->getCycle()->getName(),
            "cycle_code"        => $card->getPack()->getCycle()->getCode(),
            "ancur_link"        => $card->getAncurLink(),
            "imageUrl"          => $card->getImageUrl(),
            "tiny_image_path"   => $card->getTinyImagePath(),
            "small_image_path"  => $card->getSmallImagePath(),
            "medium_image_path" => $card->getMediumImagePath(),
            "large_image_path"  => $card->getLargeImagePath(),
	    "is_reboot_changed" => in_array($card->getCode(), self::$reboot_changed_codes),
        ];

        // setting the card cost to X if the cost is null and the card is not of a costless type
        if ($cardinfo['cost'] === null && !in_array($cardinfo['type_code'], ['agenda', 'identity'])) {
            $cardinfo['cost'] = 'X';
        }

        // setting the card strength to X if the strength is null and the card is ICE or Program - Icebreaker
        if ($cardinfo['strength'] === null &&
            ($cardinfo['type_code'] === 'ice' ||
             strstr($cardinfo['subtype'], 'Icebreaker') !== false)) {
            $cardinfo['strength'] = 'X';
        }

        $cardinfo['url'] = $this->router->generate('cards_zoom', ['card_code' => $card->getCode(), '_locale' => $locale], UrlGeneratorInterface::RELATIVE_PATH);
        $cardinfo['imageUrl'] = $cardinfo['imageUrl'] ?: $this->packages->getUrl($card->getCode() . ".png", "card_image");

        // replacing <trace>
        $cardinfo['text'] = preg_replace('/<trace>([^<]+) ([X\d]+)<\/trace>/', '<strong>\1 [\2]</strong>–', $cardinfo['text']);

        // replacing <errata>
        $cardinfo['text'] = preg_replace('/<errata>(.+)<\/errata>/', '<em><span class="glyphicon glyphicon-alert"></span> \1</em>', $cardinfo['text']);

        // replacing <champion>
        $cardinfo['flavor'] = preg_replace('/<champion>(.+)<\/champion>/', '<span class="champion">\1</champion>', $cardinfo['flavor']);

        $cardinfo['text'] = $this->replaceSymbols($cardinfo['text']);
        $cardinfo['text'] = str_replace('&', '&amp;', $cardinfo['text']);
        $cardinfo['text'] = implode(array_map(function ($l) {
            return "<p>$l</p>";
        }, explode("\n", $cardinfo['text'])));
        $cardinfo['flavor'] = $this->replaceSymbols($cardinfo['flavor']);
        $cardinfo['flavor'] = str_replace('&', '&amp;', $cardinfo['flavor']);
        $cardinfo['cssfaction'] = str_replace(" ", "-", mb_strtolower($card->getFaction()->getName()));

        $cache[$card->getId()][$locale] = $cardinfo;

        return $cardinfo;
    }

    public function syntax(string $query)
    {
        // renvoie une liste de conditions (array)
        // chaque condition est un tableau à n>1 éléments
        // le premier est le type de condition (0 ou 1 caractère)
        // les suivants sont les arguments, en OR

        $query = preg_replace('/\s+/u', ' ', trim($query));

        $list = [];
        $cond = null;
        // l'automate a 3 états :
        // 1:recherche de type
        // 2:recherche d'argument principal
        // 3:recherche d'argument supplémentaire
        // 4:erreur de parsing, on recherche la prochaine condition
        // s'il tombe sur un argument alors qu'il est en recherche de type, alors le type est vide
        $etat = 1;
        while ($query != "") {
            if ($etat == 1) {
                if (isset($cond) && $etat != 4 && count($cond) > 2) {
                    $list[] = $cond;
                }
                // on commence par rechercher un type de condition
                $match = [];
                if (preg_match('/^(\p{L})([:<>!])(.*)/u', $query, $match)) { // jeton "condition:"
                    $cond = [mb_strtolower($match[1]), $match[2]];
                    $query = $match[3];
                } else {
                    $cond = ["", ":"];
                }
                $etat = 2;
            } else {
                if (preg_match('/^"([^"]*)"(.*)/u', $query, $match) // jeton "texte libre entre guillements"
                    || preg_match('/^([\p{L}\p{N}\-\&\.\!\'\;]+)(.*)/u', $query, $match) // jeton "texte autorisé sans guillements"
                ) {
                    if (($etat == 2 && isset($cond) && count($cond) == 2) || $etat == 3) {
                        $cond[] = $match[1];
                        $query = $match[2];
                        $etat = 2;
                    } else {
                        // erreur
                        $query = $match[2];
                        $etat = 4;
                    }
                } elseif (preg_match('/^\|(.*)/u', $query, $match)) { // jeton "|"
                    if (($cond[1] == ':' || $cond[1] == '!') && (($etat == 2 && isset($cond) && count($cond) > 2) || $etat == 3)) {
                        $query = $match[1];
                        $etat = 3;
                    } else {
                        // erreur
                        $query = $match[1];
                        $etat = 4;
                    }
                } elseif (preg_match('/^ (.*)/u', $query, $match)) { // jeton " "
                    $query = $match[1];
                    $etat = 1;
                } else {
                    // erreur
                    $query = substr($query, 1);
                    $etat = 4;
                }
            }
        }
        if (isset($cond) && $etat != 4 && count($cond) > 2) {
            $list[] = $cond;
        }

        return $list;
    }

    public function validateConditions(array &$conditions)
    {
        // Remove invalid conditions
        $canDoNumeric = ['c', 'e', 'h', 'm', 'n', 'o', 'p', 'r', 'y'];
        $numeric = ['<', '>'];
        foreach ($conditions as $i => $l) {
            if (in_array($l[1], $numeric) && !in_array($l[0], $canDoNumeric)) {
                unset($conditions[$i]);
            }
            if ($l[0] == 'f') {
                $factions = [];
                for ($j = 1; $j < count($l); ++$j) {
                    if (strlen($l[$j]) === 1) {
                        // replace faction letter with full name
                        $keys = array_keys(self::$faction_letters, $l[$j]);
                        if (count($keys)) {
                            array_push($factions, $keys[0]);
                        }
                    } else {
                        array_push($factions, $l[$j]);
                    }
                }
                array_unshift($factions, 'f', $l[1]);
                $conditions[$i] = $factions;
            }
        }
    }

    public function buildQueryFromConditions(array $conditions)
    {
        // reconstruction de la bonne chaine de recherche pour affichage
        return implode(" ", array_map(
            function ($l) {
                return ($l[0] ? $l[0] . $l[1] : "")
                    . implode("|", array_map(
                        function ($s) {
                            return preg_match("/^[\p{L}\p{N}\-\&\.\!\'\;]+$/u", $s) ? $s : "\"$s\"";
                        },
                        array_slice($l, 2)
                    ));
            },
            $conditions
        ));
    }

    public function get_mwl_info(array $cards)
    {
        $response = [];
        $mwls = $this->entityManager->getRepository(Mwl::class)->findBy([], ["dateStart" => "DESC"]);

        foreach ($cards as $card) {
            $card_code = $card->getCode();
            foreach ($mwls as $mwl) {
                $mwl_cards = $mwl->getCards();
                if (isset($mwl_cards[$card_code])) {
                    $card_mwl = $mwl_cards[$card_code];
                    $is_restricted = $card_mwl['is_restricted'] ?? 0;
                    $deck_limit = $card_mwl['deck_limit'] ?? null;
                    // Ceux-ci signifient la même chose
                    $universal_faction_cost = $card_mwl['universal_faction_cost'] ?? $card_mwl['global_penalty'] ?? 0;
                    $response[] = [
                        'mwl_name'               => $mwl->getName(),
                        'active'                 => $mwl->getActive(),
                        'is_restricted'          => $is_restricted,
                        'deck_limit'             => $deck_limit,
                        'universal_faction_cost' => $universal_faction_cost,
                    ];
                }
            }
        }

        return $response;
    }

    public function get_reviews(array $cards)
    {
        $reviews = $this->entityManager->getRepository(Review::class)->findBy(['card' => $cards], ['nbvotes' => 'DESC']);

        $response = [];
        $packs = $this->packRepository->findBy([], ["dateRelease" => "ASC"]);
        foreach ($reviews as $review) {
            /** @var Review $review */
            $user = $review->getUser();

            $response[] = [
                'id'                => $review->getId(),
                'text'              => $review->getText(),
                'author_id'         => $user->getId(),
                'author_name'       => $user->getUsername(),
                'author_reputation' => $user->getReputation(),
                'author_donation'   => $user->getDonation(),
                'author_color'      => $user->getFaction(),
                'date_creation'     => $review->getDateCreation(),
                'nbvotes'           => $review->getNbvotes(),
                'comments'          => $review->getComments(),
                'latestpack'        => $this->last_pack_for_review($packs, $review),
            ];
        }

        return $response;
    }

    public function last_pack_for_review(array $packs, Review $review)
    {
        /** @var Pack $pack */
        foreach (array_reverse($packs) as $pack) {
            if ($pack->getDateRelease() instanceof \DateTime
                && $pack->getDateRelease() < $review->getDateCreation()) {
                return $pack->getName();
            }
        }

        return 'Unknown';
    }

    public function get_rulings(array $cards)
    {
        $rulings = $this->entityManager->getRepository(Ruling::class)->findBy(['card' => $cards], ['dateCreation' => 'ASC']);

        $response = [];
        foreach ($rulings as $ruling) {
            $response[] = [
                'id'      => $ruling->getId(),
                'text'    => $ruling->getText(),
                'rawtext' => $ruling->getRawtext(),
            ];
        }

        return $response;
    }

    /**
     * Searches a Identity card by its partial title
     * @return \AppBundle\Entity\Card
     */
    public function find_identity(string $partialTitle)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('c')->from('AppBundle:Card', 'c')->join('AppBundle:Type', 't', 'WITH', 'c.type = t');
        $qb->where($qb->expr()->eq('t.name', ':typeName'));
        $qb->andWhere($qb->expr()->like('c.title', ':title'));
        $query = $qb->getQuery();
        $query->setParameter('typeName', 'Identity');
        $query->setParameter('title', '%' . $partialTitle . '%');
        $card = $query->getSingleResult();

        return $card;
    }

    /**
     *  Searches for other versions/releases of all cards
     *  @return array
     */
    public function get_versions()
    {
        $cards = $this->entityManager->getRepository(Card::class)->findAll();

        $versions = [];
        foreach ($cards as $card) {
            $versions[$card->getTitle()][] = $card;
        }

        return $versions;
    }

    public function select_only_latest_cards(array $matchingCards)
    {
        $latestCardsByTitle = [];
        foreach ($matchingCards as $card) {
            $latestCard = null;
            $title = $card->getTitle();

            if (isset($latestCardsByTitle[$title])) {
                $latestCard = $latestCardsByTitle[$title];
            }
            if (!$latestCard || $card->getCode() > $latestCard->getCode()) {
                $latestCardsByTitle[$title] = $card;
            }
        }

        return array_values(array_filter($matchingCards, function ($card) use ($latestCardsByTitle) {
            return $card->getCode() == $latestCardsByTitle[$card->getTitle()]->getCode();
        }));
    }

    public function select_only_earliest_cards(array $matchingCards)
    {
        $earliestCardsByTitle = [];
        foreach ($matchingCards as $card) {
            $earliestCard = null;
            $title = $card->getTitle();

            if (isset($earliestCardsByTitle[$title])) {
                $earliestCard = $earliestCardsByTitle[$title];
            }
            if (!$earliestCard || $card->getCode() < $earliestCard->getCode()) {
                $earliestCardsByTitle[$title] = $card;
            }
        }

        return array_values(array_filter($matchingCards, function ($card) use ($earliestCardsByTitle) {
            return $card->getCode() == $earliestCardsByTitle[$card->getTitle()]->getCode();
        }));
    }

    public function get_versions_by_code(array $cards_code)
    {
        $cards = $this->entityManager->getRepository(Card::class)->findBy(['code' => $cards_code]);
        $titles = [];
        foreach ($cards as $card) {
            $titles[] = $card->getTitle();
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb = $qb->select('c')
                 ->from(Card::class, 'c')
                 ->where('c.title in (:titles)')
                 ->setParameter('titles', $titles);
        $query = $qb->getQuery();
        $rows = $query->getResult();

        return $rows;
    }
}
