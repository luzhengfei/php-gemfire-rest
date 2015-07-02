<?php
/**
 * author: lzf
 * createTime: 15/7/2 22:26
 * description:
 */

namespace Core\Exceptions;

class NullRegionNameException extends \Exception{
    public function errorMessage(){
        return '抱歉，域名称不正确';
    }
}