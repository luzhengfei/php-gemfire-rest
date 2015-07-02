<?php
/**
 * author: lzf
 * createTime: 15/7/1 21:49
 * description: Geode api class
 */

spl_autoload_register(function($class){
    $className = str_replace('\\','/',$class).'.php';
    require_once $className;
});

class PHPGeodeClient{
    private $_host; /* Geode服务主机地址 */

    private $_port; /* Geode服务端口 */

    private $_apiurl = '/gemfire-api/v1'; /* Geode服务Rest地址,固定 */

    private $_http;

    public function __construct($host = '127.0.0.1', $port = '8080'){
        $this->_host = $host;
        $this->_port = $port;
        $this->_http = new \Core\Http\HttpClient();
        $this->_http->setRespondModel(new \Core\Model\CommonModel());
    }

    /**
     * 列出所有可使用的域
     * @return mixed
     */
    public function list_all_regions(){
        $requestUrl = $this->_make_request_url();

        return $this->_http->sendRequest($requestUrl);
    }

    /**
     * 获取域的所有数据
     * @param string $regionName
     * @return mixed
     */
    public function get_region_all($regionName = ''){
        $paramsFormat = sprintf('/%s?limit=ALL',$regionName);
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl);
    }

    /**
     * 获取所有域的key值
     * @param string $regionName
     * @return mixed
     */
    public function get_region_keys($regionName = ''){
        $paramsFormat = sprintf('/%s/keys',$regionName);
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl);
    }

    /**
     * 根据key，获取实体数据，
     * @param string $regionName
     * @param array $keys，可以逗号分割的字符串
     * @return mixed
     */
    public function get_entries_by_keys($regionName = '',$keys = array()){
        $paramsFormat = sprintf('/%s/%s',$regionName,implode(',',$keys));
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl);
    }

    /**
     * 创建实体
     * @param $regionName
     * @param $key
     * @param $value  数据为一维关联数组
     * @return mixed
     */
    public function create($regionName,$key,$value){
        $paramsFormat = sprintf('/%s?key=%s',$regionName,$key);
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl,'POST',$value);
    }

    /**
     * 更新实体
     * @param $regionName
     * @param $key
     * @param $value
     * @return mixed
     */
    public function update($regionName,$key,$value){
        $paramsFormat = sprintf('/%s/%s?op=REPLACE',$regionName,$key);
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl,'PUT',$value);
    }

    /**
     * 删除域
     * @param string $regionName
     * @return mixed
     */
    public function delete_region($regionName = ''){
        $paramsFormat = sprintf('/%s',$regionName);
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl,'DELETE');
    }

    /**
     * 删除实体
     * @param string $regionName
     * @param array $keys
     * @return mixed
     */
    public function delete_entries_by_keys($regionName = '',$keys = array()){
        $paramsFormat = sprintf('/%s/%s',$regionName,implode(',',$keys));
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl,'DELETE');
    }

    /**
     * 列出所有查询
     * @return mixed
     */
    public function list_queries(){
        $paramsFormat = sprintf('/queries');
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl,'GET');
    }

    /**
     * 创建查询
     * @param $queryId
     * @param $queryOQL
     * @return mixed
     */
    public function create_queries($queryId,$queryOQL){
        $paramsFormat = sprintf('/queries?id=%s&q=%s',$queryId,urlencode($queryOQL));
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl,'POST');
    }

    /**
     * 更新查询
     * @param $queryId
     * @param $queryOQL
     * @return mixed
     */
    public function update_queries($queryId,$queryOQL){
        $paramsFormat = sprintf('/queries/%s?q=%s',$queryId,urlencode($queryOQL));
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl,'PUT');
    }

    /**
     * 执行查询
     * @param $queryId
     * @return mixed
     */
    public function execute_queries($queryId){
        $paramsFormat = sprintf('/queries/%s',$queryId);
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl,'POST',array('@type' => 'int','@value' => 0));
    }

    /**
     * 删除查询
     * @param $queryId
     * @return mixed
     */
    public function delete_queries($queryId){
        $paramsFormat = sprintf('/queries/%s',$queryId);
        $requestUrl = $this->_make_request_url($paramsFormat);

        return $this->_http->sendRequest($requestUrl,'DELETE');
    }


    private function _make_request_url($params = ''){
        $url = sprintf('http://%s:%d%s%s',$this->_host,$this->_port,$this->_apiurl,$params);
        return $url;
    }
}