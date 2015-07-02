<?php
/**
 * author: lzf
 * createTime: 15/7/2 23:36
 * description:
 */

namespace Core\Model;

class CommonModel{
    private $_respondData = array();

    public function parse($json){
        $this->_respondData = json_decode($json,true);
    }

    public function getRespondData(){
        return $this->_respondData;
    }
}