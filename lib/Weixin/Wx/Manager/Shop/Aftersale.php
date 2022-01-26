<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 售后接口
 *
 * @author guoyongrong
 *        
 */
class Aftersale
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/aftersale/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 创建售后
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/aftersale/add.html
     * 接口调用请求说明
     * 订单原始状态为10, 200, 250时会返回错误码100000
     *
     * finish_all_aftersale = 1时订单状态会流转到200（全部售后结束，不可继续售后）
     *
     * 此接口支持按售后单号重入
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/aftersale/add?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "out_order_id": "xxxxx",
     * "out_aftersale_id": "xxxxxx", // 商家售后ID
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * "type": 1, // 1:退款,2:退款退货,3:换货
     * "create_time": "2020-12-01 00:00:00",
     * "status": 1,
     * "finish_all_aftersale": 0,
     * "path": "/pages/aftersale.html?out_aftersale_id=xxxxx",
     * "refund": 100,
     * "product_infos":
     * [
     * {
     * "out_product_id": "234245",
     * "out_sku_id": "23424",
     * "product_cnt": 5
     * },
     * ...
     * ]
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * out_order_id string 是 商家自定义订单ID
     * out_aftersale_id string 是 商家自定义售后ID
     * path string 是 商家小程序该售后单的页面path，不存在则使用订单path
     * refund number 是 退款金额,单位：分
     * openid string 是 用户的openid
     * type number 是 售后类型，1:退款,2:退款退货,3:换货
     * create_time string 是 发起申请时间，yyyy-MM-dd HH:mm:ss
     * status number 是 0:未受理,1:用户取消,2:商家受理中,3:商家逾期未处理,4:商家拒绝退款,5:商家拒绝退货退款,6:待买家退货,7:退货退款关闭,8:待商家收货,11:商家退款中,12:商家逾期未退款,13:退款完成,14:退货退款完成,15:换货完成,16:待商家发货,17:待用户确认收货,18:商家拒绝换货,19:商家已收到货
     * finish_all_aftersale number 是 0:订单可继续售后, 1:订单无继续售后
     * product_infos object array 是 退货相关商品列表
     * product_infos[].out_product_id string 是 商家自定义商品ID
     * product_infos[].out_sku_id string 是 商家自定义sku ID, 如果没有则不填
     * product_infos[].product_cnt number product_infos存在时必填 参与售后的商品数量
     * refund_reason string 否 退款原因
     * refund_address string 否 买家收货地址
     * orderamt number 否 退款金额
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function add(\Weixin\Wx\Model\Shop\Aftersale $aftersale)
    {
        $params = $aftersale->getParams();
        $rst = $this->_request->post($this->_url . 'add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取订单下售后单
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/aftersale/get.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/aftersale/get?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "order_id":32434234, // 发起售后的订单ID
     * "out_order_id": "xxxxx",
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "aftersale_infos": [
     * {
     * "out_order_id": "xxxxx",
     * "out_aftersale_id": "xxxxxx",
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * "type": 1,
     * "create_time": "2020-12-01 00:00:00",
     * "path": "/pages/order.html?out_order_id=xxxxx",
     * "status": 1,
     * "refund": 100,
     * "product_infos": [
     * {
     * "out_product_id": "234245",
     * "out_sku_id": "23424",
     * "product_cnt": 5
     * },
     * ...
     * ]
     * }
     * ]
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * out_order_id string 否 商家自定义订单ID，与 order_id 二选一
     * openid string 是 用户的openid
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * aftersale_infos[].out_aftersale_id string 商家自定义售后ID，与aftersale_id二选一
     * aftersale_infos[].path string 商家小程序该售后单的页面path，不存在则使用订单path
     * aftersale_infos[].openid string 用户的openid
     * aftersale_infos[].type number 售后类型，1:退款,2:退款退货,3:换货
     * aftersale_infos[].status number 0:未受理,1:用户取消,2:商家受理中,3:商家逾期未处理,4:商家拒绝退款,5:商家拒绝退货退款,6:待买aftersale_infos[].家退货,7:退货退款关闭,8:待商家收货,11:商家退款中,12:商家逾期未退款,13:退款完成,14:退货退款完成
     * aftersale_infos[].product_infos object array 退货相关商品列表
     * aftersale_infos[].product_infos[].out_product_id string 商家自定义商品ID
     * aftersale_infos[].product_infos[].out_sku_id string 商家自定义sku ID
     * aftersale_infos[].product_infos[].product_cnt number product_infos存在时必填
     * aftersale_infos[].refund number 退款金额,单位：分
     * aftersale_infos[].refund_reason string 退款原因
     * aftersale_infos[].refund_address string 买家收货地址
     * aftersale_infos[].orderamt number 退款金额
     */
    public function get($openid, $order_id = "", $out_order_id = "")
    {
        $params = array();
        if (!empty($order_id)) {
            $params['order_id'] = $order_id;
        }
        if (!empty($out_order_id)) {
            $params['out_order_id'] = $out_order_id;
        }
        $params['openid'] = $openid;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 更新售后
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/aftersale/update.html
     * 只能更新售后状态
     *
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/aftersale/update?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "out_order_id": "xxxxx",
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * "out_aftersale_id": "xxxxxx", // 商家售后Id
     * "status": 1, // 0:未受理,1:用户取消,2:商家受理中,3:商家逾期未处理,4:商家拒绝退款,5:商家拒绝退货退款,6:待买家退货,7:退货退款关闭,8:待商家收货,11:商家退款中,12:商家逾期未退款,13:退款完成,14:退货退款完成,15:换货完成,16:待商家发货,17:待用户确认收货,18:商家拒绝换货,19:商家已收到货
     * "finish_all_aftersale": 0, // 0:售后未结束, 1:售后结束且订单状态流转
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * out_order_id string 是 商家自定义订单ID，与 order_id 二选一
     * out_aftersale_id string 是 商家自定义售后ID
     * openid string 是 用户的openid
     * status number 是 0:未受理,1:用户取消,2:商家受理中,3:商家逾期未处理,4:商家拒绝退款,5:商家拒绝退货退款,6:待买家退货,7:退货退款关闭,8:待商家收货,11:商家退款中,12:商家逾期未退款,13:退款完成,14:退货退款完成,15:换货完成,16:待商家发货,17:待用户确认收货,18:商家拒绝换货,19:商家已收到货
     * finish_all_aftersale number 是 0:售后未结束, 1:售后结束且订单状态流转
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function update($openid, $out_order_id, $out_aftersale_id, $status, $finish_all_aftersale)
    {
        $params = array();
        $params['out_order_id'] = $out_order_id;
        $params['openid'] = $openid;
        $params['out_aftersale_id'] = $out_aftersale_id;
        $params['status'] = $status;
        $params['finish_all_aftersale'] = $finish_all_aftersale;
        $rst = $this->_request->post($this->_url . 'update', $params);
        return $this->_client->rst($rst);
    }
}
