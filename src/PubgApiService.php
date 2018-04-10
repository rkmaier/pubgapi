<?php

namespace Rkmaier\Pubgapi;

use IlluminateAgnostic\Collection\Support\Collection;

class PubgApiService
{
    protected $pubgApi;
    protected $url = "https://api.playbattlegrounds.com/shards/";
    protected $shard = "pc-eu";
    protected $query;
    protected $limit = false;
    protected $offset = false;
    protected $headers = false;
    protected $access_token = "";

    /**
     * Set CurlService parameters
     */
    public function __construct($data =[''])
    {
        $this->pubgApi = new \Ixudra\Curl\CurlService();
        $this->url = isset($data['uri']) ? $data['uri'] : $this->url;
        $this->access_token = isset($data['access_token']) ? $data['access_token'] : "";
        $this->shard = isset($data['region']) ? $data['region'] : 'pc-eu';
        $this->query = "";
    }
        
    /**
     * Append current url string
     */
    public function setUrl($url ="")
    {
        $this->query .= $url;
    }
    
    /**
     * Set region shard
     */
    public function setShard($shard = "")
    {
        $this->shard = $shard;
    }
    
    /**
     * Set pagination limit
     */
    public function setLimit($limit = false)
    {
        $this->limit = $limit;
    }

    /**
     * Set pagination offset
     */
    public function setOffset($offset = false)
    {
        $this->offset = $offset;
    }
    
    /**
     * Set custom headers before making an api call
     */
    public function setCustomHeaders()
    {
        $token = "Bearer $this->access_token";
        $this->headers = array("Authorization: $token",'Accept: application/vnd.api+json');
    }

    /**
     * Limit results
     */
    public function limit($limit)
    {
        $this->setLimit($limit);
        return $this;
    }

    /**
     * Offset results
     */
    public function offset($limit)
    {
        $this->setOffset($limit);
        return $this;
    }

    /**
     * Filter players by player names
     */
    public function players($palyer)
    {
        $this->setUrl("/players?filter[playerNames]=$palyer");
        return $this;
    }
    /**
     * Get player by playerID
     */
    public function player($palyerID)
    {
        $this->setUrl("/players/$palyerID");
        return $this;
    }

    /**
     * Set region
     */
    public function region($shard = "pc-eu")
    {
        $this->setShard($shard);
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
        $this->setUrl("/matches/$matchID");
        return $this;
    }
    /**
     * Set matches query
     */
    public function matches()
    {
        $this->setUrl("/matches");
        return $this;
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

    public function links()
    {
        $url = $this->createQuery();
        return $this->get()['links'];
    }

    public function meta()
    {
        $url = $this->buildQuery();
        return $this->get()['meta'];
    }

    /**
     * Get query results
     */
    public function get()
    {
        $url = $this->buildQuery();
        try {
            $result =  $this->pubgApi->to($url)->withHeaders($this->headers)->asJsonResponse()->get();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
        return collect($result);
    }

    /**
     * Build query
     */
    protected function buildQuery()
    {
        $this->setCustomHeaders();
        $url = $this->url.$this->shard.$this->query;
        $arr=['page[limit]'=>$this->limit ? $this->limit :0,'page[offset]' => $this->offset ?  $this->offset : 0];
        $filter = $url.$this->expandUrl($url). http_build_query($arr);
        $url = $this->limit || $this->offset ? $filter : $url;
        return $url;
    }
    
    /**
     * Return url
     */
    public function url()
    {
        return $this->url.$this->query;
    }

    /**
     *  Expand url with additional params
     */
    public function expandUrl($str)
    {
        if (strpos($str, '?') !== false) {
            return "&";
        }
        return "?";
    }
}
