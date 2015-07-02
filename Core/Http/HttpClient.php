<?php
/**
 * author: lzf
 * createTime: 15/7/2 23:11
 * description:
 */

namespace Core\Http;

class HttpClient{
    private $_timeOut = 3;
    private $_respondModel;

    public function sendRequest($sendUrl,$method = 'GET',$postData = array(),$headerData = array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeOut);

        $headerArr = $this->_formatHeader($method,$headerData);
        if($headerArr){
            curl_setopt($ch, CURLOPT_HTTPHEADER ,$headerArr);
        }

        if(count($postData) > 0) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postData));
        }

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        curl_setopt($ch, CURLOPT_URL, $sendUrl);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);
        $this->_respondModel->parse($res);
        return $this->_respondModel;
    }

    public function _formatHeader($method = 'GET',$headerData){
        $result = array();
        $headerData['Method'] = $method;
        $headerData['Content-type'] = 'application/json;';
        foreach($headerData as $key => $body){
            $result[] = $key.':'.$body;
        }
        return $result;
    }

    public function setRespondModel($model){
        $this->_respondModel = $model;
    }

    public function setTimeOut($timeOut = 3){
        $this->_timeOut = $timeOut;
    }
}