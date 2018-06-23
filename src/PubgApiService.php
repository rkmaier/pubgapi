<?php

namespace Rkmaier\Pubgapi;

use IlluminateAgnostic\Collection\Support\Collection;
use Rkmaier\PubgapiBaseService;


class PubgApiService extends BaseService
{
    public $setPlayer = false;
    
    /**
     * Set CurlService parameters
     */
    public function __construct($data =[''])
    {
        parent::__construct($data);
    }
        
    /**
     * Append current url string
     */
    public function appendUrl($url ="")
    {
        $this->query .= $url;
    }

    public function setUrl($url ="")
    {
        $this->query = $url;
    }

    /**
     * Filter players by player names
     */
    public function players($player)
    {
        $this->appendUrl("/players?filter[playerNames]=$player");
        return $this;
    }
    /**
     * Get player by playerID
     */
    public function player($playerName)
    {
        $playerID = $this->getPlayerAccountID($playerName);
        $this->appendUrl("/players/$playerID");
        $this->setPlayer = true;
        return $this;
    }

    /**
     * Find Player Account ID
     */
    public function getPlayerAccountID($playerID)
    {
        $response  = $this->players($playerID)->get();
        $this->clearQuery();
        return $response['data'][0]->id;
    }

    /**
     * Retrieve Player Account ID 
     */
    public function getPlayerAccount($playerID)
    {
        if (!str_contains($playerID,"account")) {
            return $this->getPlayerAccountID($playerID);
        }
        return $playerID;
    }

    /**
     * Get current player Season 
     */
    public function getCurrentSeason()
    {
        $response  = $this->seasons()->data();
        $this->clearQuery();
        foreach ($response as $season) {
            if ($season->attributes->isCurrentSeason) {
                $seasonID = $season->id;
            }
        }
        return $seasonID;
    }


    public function playerStats($playerID, $seasonID = "")
    {
        $seasonID = !empty($season) ? $seasonID : $this->getCurrentSeason();
        $playerID = $this->getPlayerAccount($playerID);
        $this->setUrl("/players/$playerID/seasons/$seasonID");
        return $this;
    }


    /**
     * Get player Seasons
     */
    public function seasons()
    {
        $this->appendUrl("/seasons");
        return $this;
    }

    /**
     * Set region
     */
    public function region($ss = "pc-eu")
    {
        $this->setShard($ss);
        return $this;
    }

    public function sort($field)
    {
        $this->setSortBy($field);
        return $this;
    }

    /**
     * Set match query
     */
    public function match($matchID = "")
    {
        $this->appendUrl("/matches/$matchID");
        return $this;
    }
    /**
     * Set matches query
     */
    public function matches()
    {
        if($this->setPlayer)
        {
           return $this->data()->relationships->matches->data;
        }
        return false;
    }


    /**
     * Get API Status
     */
    public function status()
    {
        $api_url = "https://api.playbattlegrounds.com/status";
        return $this->pubgApi->to($api_url)->withHeader('Accept: application/vnd.api+json')->asJsonResponse()->get();
    }

    public function data()
    {
        $url = $this->buildQuery();
        return $this->get()['data'];
    }

    public function attributes()
    {
        $url = $this->buildQuery();
        return $this->data()->attributes;
    }

    public function relationships()
    {
        $url = $this->buildQuery();
        return $this->data()->relationships;
    }

    public function rosters()
    {
        $url = $this->buildQuery();
        return $this->data()->relationships->rosters->data;
    }

    public function included()
    {
        $url = $this->buildQuery();
        return $this->get()['included'];
    }

    public function stats($filter = "")
    {
        $url = $this->buildQuery();
        return empty($filter)  ? $this->data()->attributes->gameModeStats : $this->data()->attributes->gameModeStats->{$filter};
    }


    public function links()
    {
        $url = $this->buildQuery();
        return $this->get()['links'];
    }

    public function meta()
    {
        $url = $this->buildQuery();
        return $this->get()['meta'];
    }
}
