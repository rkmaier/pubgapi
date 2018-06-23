<?php

namespace Rkmaier\Pubgapi;

use IlluminateAgnostic\Collection\Support\Collection;

class BaseService
{
    public $pubgApi;
    public $url = "https://api.playbattlegrounds.com/shards/";
    public $shard = "pc-eu";
    public $query;
    public $limit = false;
    public $offset = false;
    public $headers = false;
    public $access_token = "";

    /**
     * Set CurlService parameters
     */
    public function __construct($data =[''])
    {
       
        $this->pubgApi = new \Ixudra\Curl\CurlService();
        $this->url = isset($data['uri']) ? $data['uri'] : $this->url;
        $this->access_token = isset($data['access_token']) ? $data['access_token'] :"";
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
    public function buildQuery()
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

    public function clearUrl()
    {
        $this->url = "";
    }

    public function clearQuery()
    {
        $this->setPlayer = false;
        $this->query = "";
    }

}
