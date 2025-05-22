<?php

namespace Weixin\Wx\Express\Business\Model\Order;

/**
 * 服务类型
 */
class Service extends \Weixin\Model\Base
{
    // service_type	number	是	服务类型ID，详见已经支持的快递公司基本信息
    public $service_type = NULL;
    // service_name	string	是	服务名称，详见已经支持的快递公司基本信息
    public $service_name = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // service_type	number	是	服务类型ID，详见已经支持的快递公司基本信息
        if ($this->isNotNull($this->service_type)) {
            $params['service_type'] = $this->service_type;
        }
        // service_name	string	是	服务名称，详见已经支持的快递公司基本信息
        if ($this->isNotNull($this->service_name)) {
            $params['service_name'] = $this->service_name;
        }
        return $params;
    }
}
