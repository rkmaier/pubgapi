<?php
namespace Rkmaier\Pubgapi;



class PubgApi {

    public $content = "";
    public $pubgApi = null;

    public function __construct()
    {
        $this->pubgApi = resolve('pubgapi');
    }
    

    public function players($player ="")
    {
     
        $this->content =  $this->pubgApi->players("$player");
        return $this->content;

    }

    public function player($playerID ="")
    {
     
        $this->content =  $this->pubgApi->player("$player");
        return $this->content;

    }

    public function limit($limit)
    {
        $this->content = $this->pubgApi->setOffset($limit);
        return $this->content;
    }

    public function sort($field)
    {
        $this->content = $this->pubgApi->setSortby($field);
        return $this->content;
    }

    public function offset($offset)
    {
        $this->content = $this->pubgApi->setLimit($offset);
        return $this->content;
    }

    public function match($matchID)
    {
        $this->content =  $this->pubgApi->match("$matchID");
        return $this->content;
    }

    public function matches()
    {
        $this->content =  $this->pubgApi->matches();
        return $this->content;
    }


    public function region($shard ="")
    {
        $this->content =  $this->pubgApi->shard("$shard");
        return $this->content;
    }

    public function get()
    {
        $this->content =  $this->pubgApi->get();
        return $this->content;
    }

    public function status()
    {
        $this->content =  $this->pubgApi->status();
        return $this->content;
    }


    public function url()
    {
        $this->content =  $this->pubgApi->url();
        return $this->content;
    }

}