<?php
namespace Weixin\Manager\Shakearound;

use Weixin\Client;

/**
 * 设备信息
 *
 * @author happy
 *
 */
class Page
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shakearound/page/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }
    public function search($type,$begin=0,$count=0,array $page_ids=[]){

        if($type==1){
            $params=array(
                'type'=>1,
                'page_ids'=>$page_ids,
            );
        }else{
            $params=array(
                'type'=>2,
                "begin"=>$begin,
                "count"=>$count
            );
        }
        $rst = $this->_request->post($this->_url . 'search', $params);
        return $this->_client->rst($rst);
    }

}
