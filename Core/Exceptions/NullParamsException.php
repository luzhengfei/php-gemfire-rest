<?php
/**
 * author: lzf
 * createTime: 15/7/2 22:32
 * description:
 */

namespace Core\Exceptions;

class NullParamsException extends \Exception{
    public function errorMessage(){
        return '抱歉，参数格式不正确';
    }
}