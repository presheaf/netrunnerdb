<?php

namespace AppBundle\Entity;

use AppBundle\Behavior\Entity\NormalizableInterface;
use AppBundle\Behavior\Entity\TimestampableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

const reboot_changed_codes = array('09019', '01055', '04052', '01018', '09037', '08003', '10011', '01047', '01097', '01057', '10097', '01079', '05041', '03008', '08073', '04087', '02038', '08091', '08048', '08112', '02083', '06080', '09029', '09030', '07044', '07001', '01053', '06064', '06079', '01081', '03040', '06119', '01025', '06076', '08093', '08099', '06012', '10056', '01042', '10098', '02035', '10050', '03013', '01059', '04021', '06053', '04085', '04089', '04090', '03050', '06055', '08049', '09039', '08010', '02014', '01082', '04112', '05043', '07016', '02073', '02119', '06037', '08018', '04114', '04068', '10022', '01074', '06094', '06099', '06096', '05013', '03001', '03009', '06069', '02046', '04014', '10010', '07017', '10089', '02036', '02060', '07045', '08044', '08111', '01075', '04055', '08055', '03038', '10049', '08001', '06115', '06116', '08027', '02025', '07008', '04025', '10037', '04113', '01065', '02120', '02005', '01030', '02089', '08046', '03002', '06013', '01005', '08050', '04086', '06098', '06033', '02102', '02096', '02103', '01076', '03027', '08107', '07036', '08103', '02118', '02072', '07026', '10017', '04042', '02108', '08072', '01003', '01024', '02048', '03010', '02061', '10021', '01009', '06072', '05055', '02064', '09042', '02020', '04103', '02028', '05032', '08095', '06120', '02053', '07028', '06093', '10112', '06042', '04037', '09053', '06024', '09033', '08089', '08005', '06102', '04027', '02092', '10092', '02039', '04084', '03030', '01066', '04045', '03032', '08119', '08075', '05033', '04106', '04007', '08061', '05034', '04071', '06075', '02032', '08086', '07018', '07004', '02117', '02062', '01020', '04001', '08114', '10045', '03033', '02040', '10108', '01017', '08067', '04065', '06084', '08013', '04017', '01087', '05044', '09026', '02077', '02070', '04046', '04020', '04097', '04099', '09050', '09049', '09048', '05024', '04110', '03011', '01054', '02010', '06071', '01102', '04023', '05001', '10032', '01061', '03015', '06023', '06101', '04031', '04082', '10004', '02095', '04004', '02071', '03016', '02085', '04051', '01112', '08070', '05028', '10109', '03017', '10105', '05016', '06113', '09038', '02106', '02068', '10016', '04016', '04057', '04050', '06103', '08090', '07033', '06114', '04015', '02012', '10006', '08012', '01067', '01033', '05029', '02090', '08052', '06063', '06031', '08104', '10104', '04063', '06095', '01023', '04064', '04026', '03024', '06085', '08057', '06039', '05037', '08029', '06089', '10103', '06065', '08074', '04116', '04095', '06104', '05051', '01089', '10007', '05014', '01108', '07046', '10114', '02113', '02116', '06007', '03018', '03036', '02004', '02105', '04035', '08068', '10018', '10055', '10036', '02044', '10019', '05015', '06004', '04119', '06017', '01080', '02114', '06005', '08019', '05021', '10040', '02041', '06038', '02075', '01072', '01077', '09002', '09014', '09009', '03003', '06002', '01027', '05002', '01001', '08053', '04038', '08097', '04088', '03039', '05054', '06058', '10080', '05053', '08076', '10038', '04108', '10031', '10030', '06015', '01012', '07021', '10063', '04002', '02006', '06062', '10066', '02086', '01046', '05023', '05036', '10051', '10043', '10026', '06044', '01095', '06016', '08101', '01073', '08017', '06006', '01106', '02059', '04010', '01069', '03006', '02050', '05038', '10090', '05047', '06060', '05025', '04049', '09012', '09006', '04024', '01091', '10093', '10041', '10033', '01105', '09015', '02016', '02093', '04070', '08088', '04003', '01064', '04077', '02111', '04044', '09025', '08054', '07050', '10044', '06117', '06082', '03047', '02098', '03054', '01092', '07023', '02023', '04105', '01099', '06034', '07019', '09046', '01096', '06112', '02034', '10053', '03007', '03025', '01104', '06050', '06092', '02030', '04115', '05019', '06107', '07034', '05030', '02099', '04101', '08042', '06090', '04056', '02027', '02015', '06018', '09003', '09016', '08004', '02002', '10064', '04069', '07051', '04091', '08038', '08028', '03014', '06087', '04018', '08007', '04083', '06009', '08110', '10023', '10082', '05012', '02047', '04075', '09022', '07011', '04036', '06021', '08120', '05007', '02008', '01040', '03029', '06008', '01041', '10085', '05049', '03012', '06035', '07003', '09017', '02017', '04047', '05022', '06078', '08008', '05050', '06108', '04074', '06106', '03022', '02078', '08030', '08080', '07053', '05039', '06036', '02074', '06110', '07030', '10061', '02021', '10095', '04080', '09011', '07047', '01063', '03019', '06109', '10048', '04098', '10091', '01078', '06047', '02076', '02001', '06032', '05040', '08108', '04118', '04048', '02057', '08116', '04030', '01016', '01013', '01014', '01071', '03020', '06097', '02007');

/**
 * Card
 */
class Card implements NormalizableInterface, TimestampableInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateUpdate;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string|null
     */
    private $keywords;

    /**
     * @var string
     */
    private $text;

    /**
     * @var integer
     */
    private $advancementCost;

    /**
     * @var integer
     */
    private $agendaPoints;

    /**
     * @var integer
     */
    private $baseLink;

    /**
     * @var integer|null
     */
    private $cost;

    /**
     * @var integer|null
     */
    private $factionCost;

    /**
     * @var string|null
     */
    private $flavor;

    /**
     * @var string
     */
    private $illustrator;

    /**
     * @var integer|null
     */
    private $influenceLimit;

    /**
     * @var integer
     */
    private $memoryCost;

    /**
     * @var integer
     */
    private $minimumDeckSize;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var integer
     */
    private $quantity;

    /**
     * @var integer
     */
    private $strength;

    /**
     * @var integer|null
     */
    private $trashCost;

    /**
     * @var boolean
     */
    private $uniqueness;

    /**
     * @var integer
     */
    private $deckLimit;

    /**
     * @var Collection
     */
    private $decklists;

    /**
     * @var Pack
     */
    private $pack;

    /**
     * @var Type
     */
    private $type;

    /**
     * @var Faction
     */
    private $faction;

    /**
     * @var Side
     */
    private $side;

    /**
     * @var string|null
     */
    private $imageUrl;

    /**
     * @var Collection
     */
    private $reviews;

    /**
     * @var Collection
     */
    private $rulings;

    /**
     * @var \DateTime
     */
    private $dateCreation;

    /**
     * @var int|null
     */
    private $globalPenalty;

    /**
     * @var int|null
     */
    private $universalFactionCost;

    /**
     * @var bool
     */
    private $isRestricted;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->decklists = new ArrayCollection();
        $this->dateUpdate = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->code . ' ' . $this->title;
    }

    /**
     * @return array
     */
    public function normalize()
    {
        if (empty($this->code)) {
            return [];
        }

        $normalized = [];

        $mandatoryFields = [
                'code',
                'title',
                'position',
                'uniqueness',
                'deck_limit',
                'quantity',
        ];
        if (substr($this->faction->getCode(), 0, 7) === 'neutral' && $this->type->getCode() !== 'identity') {
            $mandatoryFields[] = 'faction_cost';
        }

        $optionalFields = [
                'illustrator',
                'flavor',
                'keywords',
                'text',
                'cost',
                'faction_cost',
                'trash_cost',
                'image_url'
        ];

        $externalFields = [
                'faction',
                'pack',
                'side',
                'type'
        ];

        switch ($this->type->getCode()) {
            case 'identity':
                $mandatoryFields[] = 'influence_limit';
                $mandatoryFields[] = 'minimum_deck_size';
                if ($this->side->getCode() === 'runner') {
                    $mandatoryFields[] = 'base_link';
                }
                break;
            case 'agenda':
                $mandatoryFields[] = 'advancement_cost';
                $mandatoryFields[] = 'agenda_points';
                break;
            case 'asset':
            case 'upgrade':
                $mandatoryFields[] = 'cost';
                $mandatoryFields[] = 'faction_cost';
                $mandatoryFields[] = 'trash_cost';
                break;
            case 'ice':
                $mandatoryFields[] = 'cost';
                $mandatoryFields[] = 'faction_cost';
                $mandatoryFields[] = 'strength';
                break;
            case 'operation':
            case 'event':
            case 'hardware':
            case 'resource':
                $mandatoryFields[] = 'cost';
                $mandatoryFields[] = 'faction_cost';
                break;
            case 'program':
                $mandatoryFields[] = 'cost';
                $mandatoryFields[] = 'faction_cost';
                $mandatoryFields[] = 'memory_cost';
                if (strstr($this->keywords, 'Icebreaker') !== false) {
                    $mandatoryFields[] = 'strength';
                }
                break;
        }

        foreach ($optionalFields as $optionalField) {
            $getter = $this->snakeToCamel('get_' . $optionalField);
            $normalized[$optionalField] = $this->$getter();

            if (!isset($normalized[$optionalField]) || $normalized[$optionalField] === '') {
                unset($normalized[$optionalField]);
            }
        }

        foreach ($mandatoryFields as $mandatoryField) {
            $getter = $this->snakeToCamel('get_' . $mandatoryField);
            $normalized[$mandatoryField] = $this->$getter();
        }

        foreach ($externalFields as $externalField) {
            $getter = $this->snakeToCamel('get_' . $externalField);
            $normalized[$externalField.'_code'] = $this->$getter()->getCode();
        }

        ksort($normalized);
        return $normalized;
    }

    /**
     * @param string $snake
     * @return string
     */
    private function snakeToCamel(string $snake)
    {
        $parts = explode('_', $snake);
        return implode('', array_map('ucfirst', $parts));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * @param \DateTime $dateUpdate
     * @return $this
     */
    public function setDateUpdate(\DateTime $dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param string|null $keywords
     * @return $this
     */
    public function setKeywords(string $keywords = null)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return int
     */
    public function getAdvancementCost()
    {
        return $this->advancementCost;
    }

    /**
     * @param int $advancementCost
     * @return $this
     */
    public function setAdvancementCost(int $advancementCost)
    {
        $this->advancementCost = $advancementCost;

        return $this;
    }

    /**
     * @return int
     */
    public function getAgendaPoints()
    {
        return $this->agendaPoints;
    }

    /**
     * @param int $agendaPoints
     * @return $this
     */
    public function setAgendaPoints(int $agendaPoints)
    {
        $this->agendaPoints = $agendaPoints;

        return $this;
    }

    /**
     * @return int
     */
    public function getBaseLink()
    {
        return $this->baseLink;
    }

    /**
     * @param int $baseLink
     * @return $this
     */
    public function setBaseLink(int $baseLink)
    {
        $this->baseLink = $baseLink;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param int|null $cost
     * @return $this
     */
    public function setCost(int $cost = null)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getFactionCost()
    {
        return $this->factionCost === null ? 0 : $this->factionCost;
    }

    /**
     * @param int|null $factionCost
     * @return $this
     */
    public function setFactionCost(int $factionCost = null)
    {
        $this->factionCost = $factionCost;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFlavor()
    {
        return $this->flavor;
    }

    /**
     * @param string|null $flavor
     * @return $this
     */
    public function setFlavor(string $flavor = null)
    {
        $this->flavor = $flavor;

        return $this;
    }

    /**
     * @return string
     */
    public function getIllustrator()
    {
        return $this->illustrator;
    }

    /**
     * @param string $illustrator
     * @return $this
     */
    public function setIllustrator(string $illustrator)
    {
        $this->illustrator = $illustrator;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getInfluenceLimit()
    {
        return $this->influenceLimit;
    }

    /**
     * @param int|null $influenceLimit
     * @return $this
     */
    public function setInfluenceLimit(int $influenceLimit = null)
    {
        $this->influenceLimit = $influenceLimit;

        return $this;
    }

    /**
     * @return int
     */
    public function getMemoryCost()
    {
        return $this->memoryCost;
    }

    /**
     * @param int $memoryCost
     * @return $this
     */
    public function setMemoryCost(int $memoryCost)
    {
        $this->memoryCost = $memoryCost;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinimumDeckSize()
    {
        return $this->minimumDeckSize;
    }

    /**
     * @param int $minimumDeckSize
     * @return $this
     */
    public function setMinimumDeckSize(int $minimumDeckSize)
    {
        $this->minimumDeckSize = $minimumDeckSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     * @return $this
     */
    public function setPosition(int $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * @param int $strength
     * @return $this
     */
    public function setStrength(int $strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTrashCost()
    {
        return $this->trashCost;
    }

    /**
     * @param int|null $trashCost
     * @return $this
     */
    public function setTrashCost(int $trashCost = null)
    {
        $this->trashCost = $trashCost;

        return $this;
    }

    /**
     * @return bool
     */
    public function getUniqueness()
    {
        return $this->uniqueness;
    }

    /**
     * @param bool $uniqueness
     * @return $this
     */
    public function setUniqueness(bool $uniqueness)
    {
        $this->uniqueness = $uniqueness;

        return $this;
    }

    /**
     * @return int
     */
    public function getDeckLimit()
    {
        return $this->deckLimit;
    }

    /**
     * @param int $deckLimit
     * @return $this
     */
    public function setDeckLimit(int $deckLimit)
    {
        $this->deckLimit = $deckLimit;

        return $this;
    }

    /**
     * @param Decklist $decklists
     * @return $this
     */
    public function addDecklist(Decklist $decklists)
    {
        $this->decklists[] = $decklists;

        return $this;
    }

    /**
     * @param Decklist $decklists
     */
    public function removeDecklist(Decklist $decklists)
    {
        $this->decklists->removeElement($decklists);
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getDecklists()
    {
        return $this->decklists;
    }

    /**
     * @return Pack
     */
    public function getPack()
    {
        return $this->pack;
    }

    /**
     * @param Pack $pack
     * @return $this
     */
    public function setPack(Pack $pack)
    {
        $this->pack = $pack;

        return $this;
    }

    /**
     * @param Review $reviews
     * @return $this
     */
    public function addReview(Review $reviews)
    {
        $this->reviews[] = $reviews;

        return $this;
    }

    /**
     * @param Review $reviews
     */
    public function removeReview(Review $reviews)
    {
        $this->reviews->removeElement($reviews);
    }

    /**
     * @return Collection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * @param Ruling $rulings
     * @return $this
     */
    public function addRuling(Ruling $rulings)
    {
        $this->rulings[] = $rulings;

        return $this;
    }

    /**
     * @param Ruling $rulings
     */
    public function removeRuling(Ruling $rulings)
    {
        $this->rulings->removeElement($rulings);
    }

    /**
     * @return Collection
     */
    public function getRulings()
    {
        return $this->rulings;
    }

    /**
     * @return string
     */
    public function getAncurLink()
    {
        $title = $this->title;
        if ($this->getType()->getName() == "Identity") {
            if ($this->getSide()->getName() == "Runner") {
                $title = preg_replace('/: .*/', '', $title);
            } else {
                if (strstr($title, $this->getFaction()->getName()) === 0) {
                    $title = preg_replace('/.*: /', '', $title);
                } else {
                    $title = preg_replace('/: .*/', '', $title);
                }
            }
        }
        $title_url = preg_replace('/ /', '_', $title);
        return "http://ancur.wikia.com/wiki/".urlencode($title_url);
    }

    /**
     * @return Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param Type $type
     * @return $this
     */
    public function setType(Type $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Side
     */
    public function getSide()
    {
        return $this->side;
    }

    /**
     * @param Side $side
     * @return $this
     */
    public function setSide(Side $side)
    {
        $this->side = $side;

        return $this;
    }

    /**
     * @return Faction
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * @param Faction $faction
     * @return $this
     */
    public function setFaction(Faction $faction)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdentityShortTitle()
    {
        $parts = explode(': ', $this->title);
        if (count($parts) > 1 && $parts[0] === $this->faction->getName()) {
            return $parts[1];
        }
        return $parts[0];
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     * @return $this
     */
    public function setDateCreation(\DateTime $dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getGlobalPenalty()
    {
        return $this->globalPenalty;
    }

    /**
     * @param int|null $globalPenalty
     * @return $this
     */
    public function setGlobalPenalty(int $globalPenalty = null)
    {
        $this->globalPenalty = $globalPenalty;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getUniversalFactionCost()
    {
        return $this->universalFactionCost;
    }

    /**
     * @param int|null $universalFactionCost
     * @return $this
     */
    public function setUniversalFactionCost(int $universalFactionCost = null)
    {
        $this->universalFactionCost = $universalFactionCost;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRestricted()
    {
        return $this->isRestricted;
    }

    /**
     * @param bool $isRestricted
     * @return $this
     */
    public function setIsRestricted(bool $isRestricted)
    {
        $this->isRestricted = $isRestricted;

        return $this;
    }

    /**
     * @return string
     */
    public function getTinyImagePath()
    {
      return '/tiny/' . $this->code . '.jpg';
    }

    /**
     * @return string
     */
    public function getSmallImagePath()
    {
      return '/small/' . $this->code . '.jpg';
    }

    /**
     * @return string
     */
    public function getMediumImagePath()
    {
      return '/medium/' . $this->code . '.jpg';
    }

    /**
     * @return string
     */
    public function getLargeImagePath()
    {
      return '/large/' . $this->code . '.jpg';
    }

    /**
     * @return bool
     */
    public function isRebootChanged()
    {
      return in_array($this->code, $reboot_changed_codes);
    }

    /**
     * @return null|string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string|null $imageUrl
     * @return $this
     */
    public function setImageUrl(string $imageUrl = null)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
