<?php

namespace Rkmaier\Pubgapi;
use IlluminateAgnostic\Collection\Support\Collection;

class PubgApiService
{
    protected $pubgApi;
    protected $url = "https://api.playbattlegrounds.com/shards/";
    protected $shard = "pc-eu";
    protected $query = "";
    protected $limit = false;
    protected $offset = false;
    protected $headers = false;
    protected $access_token = "";
    
    public function __construct($data =[''])
    {
        $this->pubgApi = new \Ixudra\Curl\CurlService();
        $this->url = isset($data['uri']) ? $data['uri'] : $this->url;
        $this->access_token = isset($data['access_token']) ? $data['access_token'] : "";
		$this->shard = isset($data['shards']['eu']) ? $data['shards']['eu'] : 'pc-eu';
		$this->response = "";
        $this->query = "";
    }
        
    /**
     * Set query data for the url
     */
    public function setUrl($url ="")
    {
		$this->query = $this->query.$url;
    }

    /**
     * Set Pubg API region
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
     *  Set headers
     */
	public function setCustomHeaders()
	{
		$token = "Bearer $this->access_token";
		$this->headers = array("Authorization: $token",'Accept: application/vnd.api+json');
	}

    public function limit($limit)
    {
        $this->setLimit($limit);
        return $this;
    }

    public function offset($limit)
    {
        $this->setOffset($limit);
        return $this;
    }

    public function players($palyer)
    {
		$this->setUrl("/players?filter[playerNames]=$palyer");
        return $this;
    }

    public function player($palyerID)
    {
		$this->setUrl("/players/$palyerID");
        return $this;
    }

    
    public function region( $shard = "pc-eu")
    {
        $this->setShard($shard);
        return $this;
    }

    public function sort( $field)
    {
        $this->setSortBy($field);
        return $this;
    }

    public function match($matchID = "")
    {
		$this->setUrl("/matches/$matchID");
        return $this;
    }

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

    /**
     * Return 
     */
    public function data()
    {
        $url = $this->buildQuery();
        return $this->get()['data'];
    }

    public function attributes()
    {
        $url = $this->buildQuery();
        return $this->get()['data']->attributes;
    }

    public function relationships()
    {
        $url = $this->buildQuery();
        return $this->get()['data']->relationships;
    }

    public function rosters()
    {
        $url = $this->buildQuery();
        return $this->get()['data']->relationships->rosters->data;
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

    
    public function get()
    {
        $url = $this->buildQuery();
        return collect($this->pubgApi->to($url)->withHeaders($this->headers)->asJsonResponse()->get());
    }

    /**
     * Build query url for the api call
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
        return $this->url;
    }

    public function expandUrl($str)
    {
        if (strpos($str, '?') !== false) {
           return "&";
        }
        return "?";
    }
	
}
