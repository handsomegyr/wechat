<?php
namespace Weixin\Manager;

use Weixin\Client;

/**
 * 用户标签管理接口
 * 开发者可以使用接口，
 * 对公众平台的分组进行查询、创建、修改操作，
 * 也可以使用接口在需要时移动用户到某个标签。
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Tags
{

    private $_client;

    private $_request;

    private $_url = 'https://api.weixin.qq.com/cgi-bin/';

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取公众号已创建的标签
     */
    public function get()
    {
        $rst = $this->_request->get($this->_url.'tags/get');
        return $this->_client->rst($rst);
    }

    /**
     * 创建标签
     * 一个公众号，最多可以创建100个标签。
     */
    public function create($name)
    {
        $params = array(
            "tag" => array(
                "name" => $name
            )
        );
        $rst = $this->_request->post($this->_url.'tags/create', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 编辑标签
     */
    public function update($id, $name)
    {
        $params = array();
        $params['tag']['id'] = $id;
        $params['tag']['name'] = $name;
        
        $rst = $this->_request->post($this->_url.'tags/update', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 删除标签
     * 请注意，当某个标签下的粉丝超过10w时，后台不可直接删除标签。
     * 此时，开发者可以对该标签下的openid列表，先进行取消标签的操作，直到粉丝数不超过10w后，才可直接删除该标签。
     */
    public function delete($id){
        $params = array(
            "tag" => array(
                "id" => $id
            )
        );
        $rst = $this->_request->post($this->_url.'tags/delete', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 获取标签下的粉丝
     * "tagid" : 134,
     * "next_openid":""//第一个拉取的OPENID，不填默认从头开始拉取
     */
    public function tagUser($tagID,$next_openid){
        $params = array(
            "tagid" => $tagID,
            "next_openid" => $next_openid,
        );
        $rst = $this->_request->post($this->_url.'user/tag/get', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 批量为用户打标签
     * 标签功能目前支持公众号为用户打上最多三个标签。
     * {
     *   "openid_list" : [//粉丝列表
     *   "ocYxcuAEy30bX0NXmGn4ypqx3tI0",
     *   "ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"
     *   ],
     *   "tagid" : 134
     */
    public function batchtagging($tagid,$openidList){
        $params = array(
            "openid_list" => $openidList,
            'tagid'=>$tagid
        );
        $rst = $this->_request->post($this->_url.'tags/members/batchtagging', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 批量为用户取消标签
     *
     *   {
     *   "openid_list" : [//粉丝列表
     *   "ocYxcuAEy30bX0NXmGn4ypqx3tI0",
     *   "ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"
     *   ],
     *   "tagid" : 134
     *   }
     */
    public function batchuntagging($tagid,$openidList){
        $params = array(
            "openid_list" => $openidList,
            'tagid'=>$tagid
        );
        $rst = $this->_request->post($this->_url.'tags/members/batchuntagging', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 获取用户身上的标签列表
     *
     */
    public function userTagList($openid){
        $params = array(
            "openid" => $openid,
        );
        $rst = $this->_request->post($this->_url.'tags/getidlist', $params);
        return $this->_client->rst($rst);
    }
}
