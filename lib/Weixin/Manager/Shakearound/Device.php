<?php
namespace Weixin\Manager\Shakearound;

use Weixin\Client;

/**
 * 设备信息
 *
 * @author happy
 *
 */
class Device
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shakearound/device/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 新建设备分组，每个帐号下最多只有1000个分组。
     */
    public function groupAdd($group_name){
        $params=array(
            'group_name'=>$group_name
        );
        $rst = $this->_request->post($this->_url . 'group/add', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 编辑设备分组信息，目前只能修改分组名。
     */
    public function groupUpdate($group_id,$group_name){
        $params=array(
            'group_id'=>$group_id,
            'group_name'=>$group_name
        );
        $rst = $this->_request->post($this->_url . 'group/update', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 编辑设备分组信息，目前只能修改分组名。
     */
    public function groupDelete($group_id){
        $params=array(
            'group_id'=>$group_id
        );
        $rst = $this->_request->post($this->_url . 'group/delete', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 查询账号下所有的分组。
     * begin 分组列表的起始索引值
     * count 待查询的分组数量，不能超过1000个
     */
    public function groupGetlist($begin=0,$count=1000){
        $params=array(
            'begin'=>$begin,
            'count'=>$count,
        );
        $rst = $this->_request->post($this->_url . 'group/getlist', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 查询分组详情，包括分组名，分组id，分组里的设备列表。
     * begin 分组里设备的起始索引值
     * count 待查询的分组里设备的数量，不能超过1000个
     * group_id 分组唯一标识，全局唯一
     */
    public function groupGetdetail($group_id,$begin=0,$count=1000){
        $params=array(
            'begin'=>$begin,
            'count'=>$count,
            'group_id'=>$group_id,
        );
        $rst = $this->_request->post($this->_url . 'group/getdetail', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 添加设备到分组。
     * 添加设备到分组，每个分组能够持有的设备上限为10000，并且每次添加操作的添加上限为1000。只有在摇周边申请的设备才能添加到分组。
     */
    public function groupAdddevice($group_id,array $device_identifiers){
        $params=array(
            'group_id'=>$group_id,
            'device_identifiers'=>$device_identifiers
        );
        $rst = $this->_request->post($this->_url . 'group/adddevice', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 从分组中移除设备
     * 从分组中移除设备，每次删除操作的上限为1000。
     */
    public function groupDeletedevice($group_id,array $device_identifiers){
        $params=array(
            'group_id'=>$group_id,
            'device_identifiers'=>$device_identifiers
        );
        $rst = $this->_request->post($this->_url . 'group/deletedevice', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 设备申请
     */
    public function applyid($quantity,$apply_reason,$comment,$poi_id){
        $params=array(
            'quantity'=>$quantity,
            'apply_reason'=>$apply_reason,
            'comment'=>$comment,
            'poi_id'=>$poi_id,
        );
        $rst = $this->_request->post($this->_url . 'applyid', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 查询设备ID申请的审核状态
     */
    public function applyStatus($apply_id){
        $params=array(
            'apply_id'=>$apply_id,
        );
        $rst = $this->_request->post($this->_url . 'applystatus', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 查询所有设备
     */
    public function search($type,$device_identifiers,$device_id,$UUID,$major,$minor,$apply_id,$last_seen,$count){
        $params=array(
            'type'=>$type,
            'device_identifiers'=>$device_identifiers,
            'device_id'=>$device_id,
            'UUID'=>$UUID,
            'major'=>$major,
            'minor'=>$minor,
            'apply_id'=>$apply_id,
            'last_seen'=>$last_seen,
            'count'=>$count,
        );
        $rst = $this->_request->post($this->_url . 'search', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 配置设备与页面的关联关系
     */
    public function bindpage($device_id=null,array $page_ids,$uuid="",$major="",$minor=""){
        $params=array(
            'device_identifier'=>[
                "uuid"=>$uuid,
                "major"=>$major,
                "minor"=>$minor
            ],
            'page_ids'=>$page_ids,
        );
        $device_id=intval($device_id);
        if($device_id>0){
            $params['device_identifier']['device_id']=$device_id;
        }
        $rst = $this->_request->post($this->_url . 'bindpage', $params);
        return $this->_client->rst($rst);
    }
}
