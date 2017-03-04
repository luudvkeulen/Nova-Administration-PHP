<?php

class Player
{
    public $id;
    public $steamid;
    public $nickname;

    public function __construct($data = null)
    {
        if(is_array($data)) {
            if(isset($data['id'])) $this->id = $data['id'];

            $this->steamid = $data['steamid'];
            $this->nickname = $data['nickname'];
        }
    }
}