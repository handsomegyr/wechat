<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * SPU接口
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/spu_readme.html
 *
 * @author guoyongrong
 *        
 */
class Spu
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/spu/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 添加商品
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/add_spu.html
     * 新增成功后会直接提交审核，可通过商品审核回调，或者通过get接口的edit_status查看是否通过审核。
     *
     * 商品有2份数据，草稿和线上数据。
     *
     * 调用接口新增或修改商品数据后，影响的只是草稿数据，审核通过后草稿数据才会覆盖线上数据，正式生效。
     *
     * 注意：
     *
     * third_cat_id请根据获取类目接口拿到，并确定其qualification_type类目资质是否为必填，若为必填，那么要先调类目资质审核接口进行该third_cat_id的资质审核；
     * qualification_pics请根据获取类目接口中对应third_cat_id的product_qualification_type为依据，若为必填，那么该字段需要加上该商品的资质图片；
     * 若需要上传某品牌商品，需要按照微信小商店开通规则开通对应品牌使用权限。微信小商店品牌开通规则：点击跳转，若无品牌可指定无品牌(无品牌brand_id: 2100000000)。
     * 库存字段stock_num注意如果是0则无法在视频号直播上架该商品。
     * 部分特殊品类商品标题需要按照规范上传，请仔细阅读，避免审核不通过。商品标题规则：点击跳转。
     * 商品详情字段desc_info.desc desc_info.imgs 虽然非必填，但一些特殊品类仍然需要上传商品详情，请仔细阅读，避免审核不通过。商品详情规则：点击跳转。
     * 图片需使用图片上传接口换取临时链接用于上传，上传后微信侧会转为永久链接。临时链接在微信侧永久有效，商家侧可以存储临时链接，避免重复换取链接。微信侧组件图片域名，store.mp.video.tencent-cloud.com,mmbizurl.cn,mmecimage.cn/p/。
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/spu/add?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "out_product_id": "1234566",
     * "title": "任天堂 Nintendo Switch 国行续航增强版 NS家用体感游戏机掌机 便携掌上游戏机 红蓝主机",
     * "path": "pages/productDetail/productDetail?productId=2176180",
     * "head_img":
     * [
     * "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg"
     * ],
     * "qualification_pics": [
     * "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg"
     * ],
     * "desc_info":
     * {
     * "desc": "xxxxx",
     * "imgs":
     * [
     * "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg"
     * ]
     * },
     * "third_cat_id": 6666,
     * "brand_id": 2100000000,
     * "info_version": "xxx",
     * "skus":
     * [
     * {
     * "out_product_id": "1234566",
     * "out_sku_id": "1024",
     * "thumb_img": "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg",
     * "sale_price": 1300,
     * "market_price": 1500,
     * "stock_num": 100,
     * "sku_code": "A24525252",
     * "barcode": "13251454",
     * "sku_attrs":
     * [
     * {
     * "attr_key": "选择颜色",
     * "attr_value": "红蓝主机"
     * },
     * {
     * "attr_key": "选择套装",
     * "attr_value": "主机+保护套"
     * }
     * ]
     * }
     * ]
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "data":
     * {
     * "product_id": 23423523452345235,
     * "out_product_id": "1234566",
     * "create_time": "2020-03-25 12:05:25",
     * "skus":
     * [
     * {
     * "sku_id": 123,
     * "out_sku_id": "1024"
     * },
     * ...
     * ]
     * }
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * out_product_id string 是 商家自定义商品ID
     * title string 是 标题
     * path string 是 绑定的小程序商品路径
     * head_img string array 是 主图,多张,列表
     * qualification_pics string array 否 商品资质图片
     * desc_info.desc string 否 商品详情图文
     * desc_info.imgs string array 否 商品详情图片
     * third_cat_id number 是 第三级类目ID
     * brand_id number 是 品牌id
     * info_version string 否 预留字段，用于版本控制
     * skus[] object array 是 sku数组
     * skus[].out_product_id string 是 商家自定义商品ID
     * skus[].out_sku_id string 是 商家自定义skuID
     * skus[].thumb_img string 是 sku小图
     * skus[].sale_price number 是 售卖价格,以分为单位
     * skus[].market_price number 是 市场价格,以分为单位
     * skus[].stock_num number 是 库存
     * skus[].barcode string 否 条形码
     * skus[].sku_code string 否 商品编码
     * skus[].sku_attrs[].attr_key string 是 销售属性key（自定义）
     * skus[].sku_attrs[].attr_value string 是 销售属性value（自定义）
     * supplier string 否 供应商名称
     * express_fee number 否 快递费用,以分为单位
     * product_type string 否 商品属性，如：1、预售商品，2、虚拟电子凭证商品，3、自定义
     * sell_time string 否 定时上架时间
     * pick_up_type string array 否 配送方式 1快递 2同城 3上门自提 4点餐
     * onsale number 否 0-不在售 1-在售
     * unitname string 否 商品单位
     * unitfactor number 否 包装因子
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data.product_id number(uint64) 交易组件平台内部商品ID
     * data.out_product_id string 商家自定义商品ID
     * data.create_time string 创建时间
     * data.skus object array sku数组
     * data.skus[].sku_id string 交易组件平台自定义skuID
     * data.skus[].out_sku_id string 商家自定义skuID
     */
    public function add(\Weixin\Wx\Model\Shop\Spu $spu)
    {
        $params = $spu->getParams();
        $rst = $this->_request->post($this->_url . 'add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除商品
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/del_spu.html
     * 接口调用请求说明
     * 从初始值/上架/若干下架状态转换成逻辑删除（删除后不可恢复）
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/spu/del?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "product_id": 324545,
     * "out_product_id": "51514515"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * product_id number(uint64) 否 交易组件平台内部商品ID，与out_product_id二选一
     * out_product_id string 否 商家自定义商品ID，与product_id二选一
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function del($product_id = "", $out_product_id = "")
    {
        $params = array();
        if (!empty($product_id)) {
            $params['product_id'] = $product_id;
        }
        if (!empty($out_product_id)) {
            $params['out_product_id'] = $out_product_id;
        }
        $rst = $this->_request->post($this->_url . 'del', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 撤回商品审核
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/del_spu_audit.html
     * 接口调用请求说明
     * 对于审核中（edit_status=2）的商品无法重复提交，需要调用此接口，使商品流转进入未审核的状态（edit_status=1）,即可重新提交商品。
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/spu/del_audit?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "product_id": 324545,
     * "out_product_id": "51514515"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * product_id number(uint64) 否 交易组件平台内部商品ID，与out_product_id二选一
     * out_product_id string 否 商家自定义商品ID，与product_id二选一
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function delAudit($product_id = "", $out_product_id = "")
    {
        $params = array();
        if (!empty($product_id)) {
            $params['product_id'] = $product_id;
        }
        if (!empty($out_product_id)) {
            $params['out_product_id'] = $out_product_id;
        }
        $rst = $this->_request->post($this->_url . 'del_audit', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取商品
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/get_spu.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/spu/get?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "product_id": 324545,
     * "out_product_id": "51514515",
     * "need_edit_spu": 1
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "spu":
     * {
     * "out_product_id": "1234566",
     * "title": "任天堂 Nintendo Switch 国行续航增强版 NS家用体感游戏机掌机 便携掌上游戏机 红蓝主机",
     * "path": "plugin-private://wx34345ae5855f892d/pages/productDetail/productDetail?productId=2176180",
     * "head_img":
     * [
     * "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg"
     * ],
     * "desc_info":
     * {
     * "desc": "xxxx",
     * "imgs":
     * [
     * "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg"
     * ]
     * },
     * "audit_info": {
     * "submit_time" : "2021-03-09 15:14:08",
     * "audit_time": "2021-03-09 15:16:08",
     * "reject_reason": "不通过",
     * },
     * "third_cat_id": 6666,
     * "brand_id": 2100000000,
     * "info_version": "xxx",
     * "create_time": "2020-12-25 00:00:00",
     * "update_time": "2020-12-26 00:00:00",
     * "skus":
     * [
     * {
     * "out_product_id": "1234566",
     * "out_sku_id": "1024",
     * "thumb_img": "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg",
     * "sale_price": 1300,
     * "market_price": 1500,
     * "stock_num": 100,
     * "sku_code": "A24525252",
     * "barcode": "13251454",
     * "sku_attrs":
     * [
     * {
     * "attr_key": "选择颜色",
     * "attr_value": "红蓝主机"
     * },
     * {
     * "attr_key": "选择套装",
     * "attr_value": "主机+保护套"
     * }
     * ]
     * }
     * ]
     * }
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * out_product_id string 否 商家自定义商品ID，与product_id二选一
     * product_id number 否 交易组件平台内部商品ID，与out_product_id二选一
     * need_edit_spu number 否 默认0:获取线上数据, 1:获取草稿数据
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * spu.product_id number 交易组件平台内部商品ID
     * spu.out_product_id string 商家自定义商品ID
     * spu.title string 标题
     * spu.path string 绑定的小程序商品路径
     * spu.head_img string array 主图,多张,列表
     * spu.desc_info.desc string 商品详情图文
     * spu.desc_info.imgs string array 商品详情图片
     * spu.audit_info object 商品审核信息
     * spu.audit_info.submit_time string 上一次提交时间, yyyy-MM-dd HH:mm:ss
     * spu.audit_info.audit_time string 上一次审核时间, yyyy-MM-dd HH:mm:ss
     * spu.audit_info.reject_reason string 拒绝理由，只有edit_status为3时出现
     * spu.audit_info.audit_id string 审核单id
     * spu.status number 商品线上状态
     * spu.edit_status number 商品草稿状态
     * spu.third_cat_id number 第三级类目ID
     * spu.brand_id number 品牌id
     * spu.create_time string 创建时间
     * spu.update_time string 更新时间
     * spu.info_version string 预留字段，用于版本控制
     * spu.skus[] object array sku数组
     * spu.skus[].out_product_id string 商家自定义商品ID
     * spu.skus[].out_sku_id string 商家自定义skuID
     * spu.skus[].thumb_img string sku小图
     * spu.skus[].sale_price number 售卖价格,以分为单位
     * spu.skus[].market_price number 市场价格,以分为单位
     * spu.skus[].stock_num number 库存
     * spu.skus[].barcode string 条形码
     * spu.skus[].sku_code string 商品编码
     * spu.skus[].sku_attrs[].attr_key string 销售属性key（自定义）
     * spu.skus[].sku_attrs[].attr_value string 销售属性value（自定义）
     * spu.supplier string 供应商名称
     * spu.express_fee number 快递费用,以分为单位
     * spu.product_type string 商品属性，如：1、预售商品，2、虚拟电子凭证商品，3、自定义
     * spu.sell_time string 定时上架时间
     * spu.pick_up_type string array 配送方式 1快递 2同城 3上门自提 4点餐
     * spu.onsale number 0-不在售 1-在售
     * spu.unitname string 商品单位
     * spu.unitfactor number 包装因子
     * 枚举-edit_status
     * 枚举值 描述
     * 1 未审核
     * 2 审核中
     * 3 审核失败
     * 4 审核成功
     * 枚举-status
     * 枚举值 描述
     * 0 初始值
     * 5 上架
     * 11 自主下架
     * 13 违规下架/风控系统下架
     */
    public function get($product_id = "", $out_product_id = "", $need_edit_spu = 0)
    {
        $params = array();
        if (!empty($product_id)) {
            $params['product_id'] = $product_id;
        }
        if (!empty($out_product_id)) {
            $params['out_product_id'] = $out_product_id;
        }
        $params['need_edit_spu'] = $need_edit_spu;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取商品列表
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/get_spu_list.html
     * 接口调用请求说明
     * 时间范围 create_time 和 update_time 同时存在时，以 create_time 的范围为准
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/spu/get_list?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "status": 5, // 选填，不填时获取所有状态商品
     * "start_create_time": "2020-12-25 00:00:00", // 选填，与end_create_time成对
     * "end_create_time": "2020-12-26 00:00:00", // 选填，与start_create_time成对
     * "start_update_time": "2020-12-25 00:00:00", // 选填，与end_update_time成对
     * "end_update_time": "2020-12-26 00:00:00", // 选填，与start_update_time成对
     * "page": 1,
     * "page_size": 10, // 不超过100
     * "need_edit_spu": 1 // 默认0:获取线上数据, 1:获取草稿数据
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "total_num": 20,
     * "spus":
     * [
     * {
     * "out_product_id": "1234566",
     * "title": "任天堂 Nintendo Switch 国行续航增强版 NS家用体感游戏机掌机 便携掌上游戏机 红蓝主机",
     * "path": "pages/productDetail/productDetail?productId=2176180",
     * "head_img":
     * [
     * "http://img10.360buyimg.com/n1/s450x450_jfs/t1/85865/39/13611/488083/5e590a40E4bdf69c0/55c9bf645ea2b727.jpg"
     * ],
     * "desc_info":
     * {
     * "desc": "xxxxx",
     * "imgs":
     * [
     * "http://img10.360buyimg.com/n1/s450x450_jfs/t1/85865/39/13611/488083/5e590a40E4bdf69c0/55c9bf645ea2b727.jpg"
     * ]
     * },
     * "audit_info": {
     * "submit_time" : "2021-03-09 15:14:08",
     * "audit_time": "2021-03-09 15:16:08",
     * "reject_reason": "不通过"
     * },
     * "third_cat_id": 6666,
     * "brand_id": 2100000000,
     * "info_version": "xxx",
     * "create_time": "2020-12-25 00:00:00",
     * "update_time": "2020-12-26 00:00:00",
     * "skus":
     * [
     * {
     * "out_product_id": "1234566",
     * "out_sku_id": "1024",
     * "thumb_img": "http://img10.360buyimg.com/n1/s450x450_jfs/t1/100778/17/13648/424215/5e590a40E2d68e774/e171d222a0c9b763.jpg",
     * "sale_price": 1300,
     * "market_price": 1500,
     * "stock_num": 100,
     * "sku_code": "A24525252",
     * "barcode": "13251454",
     * "sku_attrs":
     * [
     * {
     * "attr_key": "选择颜色",
     * "attr_value": "红蓝主机"
     * },
     * {
     * "attr_key": "选择套装",
     * "attr_value": "主机+保护套"
     * }
     * ]
     * }
     * ]
     * },
     * ...
     * ]
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * status number 是 商品状态
     * start_create_time string 否 开始创建时间
     * end_create_time string 否 结束创建时间
     * start_update_time string 否 开始更新时间
     * end_update_time string 否 结束更新时间
     * need_edit_spu number 否 默认0:获取线上数据, 1:获取草稿数据
     * page number 是 页号
     * page_size number 是 页面大小
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * total_num number 总数
     * spus[] object array spu数组
     * spus[].product_id number(uint64) 交易组件平台内部商品ID
     * spus[].out_product_id string 商家自定义商品ID
     * spus[].title string 标题
     * spus[].path string 绑定的小程序商品路径
     * spus[].head_img string array 主图,多张,列表
     * spus[].desc_info.desc string 商品详情图文
     * spus[].desc_info.imgs string array 商品详情图片
     * spus[].audit_info object 商品审核信息，可能为空
     * spus[].audit_info.submit_time string 上一次提交时间, yyyy-MM-dd HH:mm:ss
     * spus[].audit_info.audit_time string 上一次审核时间, yyyy-MM-dd HH:mm:ss
     * spus[].audit_info.reject_reason string 拒绝理由
     * spus[].status number 商品线上状态
     * spus[].edit_status number 商品草稿状态
     * spus[].third_cat_id number 第三级类目ID
     * spus[].brand_id number 品牌id
     * spus[].create_time string 创建时间
     * spus[].update_time string 更新时间
     * spus[].info_version string 预留字段，用于版本控制
     * spus[].skus[] object array sku数组
     * spus[].skus[].out_product_id string 商家自定义商品ID
     * spus[].skus[].out_sku_id string 商家自定义skuID
     * spus[].skus[].thumb_img string sku小图
     * spus[].skus[].sale_price number 售卖价格,以分为单位
     * spus[].skus[].market_price number 市场价格,以分为单位
     * spus[].skus[].stock_num number 库存
     * spus[].skus[].barcode string 条形码
     * spus[].skus[].sku_code string 商品编码
     * spus[].skus[].sku_attrs[].attr_key string 销售属性key（自定义）
     * spus[].skus[].sku_attrs[].attr_value string 销售属性value（自定义）
     * 枚举-edit_status
     * 枚举值 描述
     * 0 初始值
     * 1 编辑中
     * 2 审核中
     * 3 审核失败
     * 4 审核成功
     * 枚举-status
     * 枚举值 描述
     * 0 初始值
     * 5 上架
     * 11 自主下架
     * 13 违规下架/风控系统下架
     * 返回码
     * 返回码 错误类型
     * -1 系统异常
     * -2 token太长
     * 9401020 参数有误
     * 9401021 无权限调用该api
     * 9401002 SPU不存在
     * 9401001 SPU已经存在
     * 9401023 SPU不允许编辑
     */
    public function getList($page = 1, $page_size = 100, $status = 0, $need_edit_spu = 0, $start_create_time = "", $end_create_time = "", $start_update_time = "", $end_update_time = "")
    {
        $params = array();
        $params['status'] = $status;
        if (!empty($start_create_time)) {
            $params['start_create_time'] = $start_create_time;
        }
        if (!empty($end_create_time)) {
            $params['end_create_time'] = $end_create_time;
        }
        if (!empty($start_update_time)) {
            $params['start_update_time'] = $start_update_time;
        }
        if (!empty($end_update_time)) {
            $params['end_update_time'] = $end_update_time;
        }
        $params['page'] = $page;
        $params['page_size'] = $page_size;
        $params['need_edit_spu'] = $need_edit_spu;
        $rst = $this->_request->post($this->_url . 'get_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 更新商品
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/update_spu.html
     * 注意：更新成功后会更新到草稿数据并直接提交审核，审核完成后有回调，也可通过get接口的edit_status查看是否通过审核。
     *
     * 商品有两份数据，草稿和线上数据。
     *
     * 调用接口新增或修改商品数据后，影响的只是草稿数据，审核通过草稿数据才会覆盖线上数据正式生效。
     *
     * 注意： 注意：
     *
     * third_cat_id请根据获取类目接口拿到，并确定其qualification_type类目资质是否为必填，若为必填，那么要先调类目资质审核接口进行该third_cat_id的资质审核；
     * qualification_pics请根据获取类目接口中对应third_cat_id的product_qualification_type为依据，若为必填，那么该字段需要加上该商品的资质图片；
     * 若需要上传某品牌商品，需要按照微信小商店开通规则开通对应品牌使用权限。微信小商店品牌开通规则：点击跳转，若无品牌可指定无品牌(无品牌brand_id: 2100000000)。
     * 库存字段stock_num注意如果是0则无法在视频号直播上架该商品。
     * 部分特殊品类商品标题需要按照规范上传，请仔细阅读，避免审核不通过。商品标题规则：点击跳转。
     * 商品详情字段desc_info.desc desc_info.imgs 虽然非必填，但一些特殊品类仍然需要上传商品详情，请仔细阅读，避免审核不通过。商品详情规则：点击跳转。
     * 图片需使用图片上传接口换取临时链接用于上传，上传后微信侧会转为永久链接。临时链接在微信侧永久有效，商家侧可以存储临时链接，避免重复换取链接。微信侧组件图片域名，store.mp.video.tencent-cloud.com,mmbizurl.cn,mmecimage.cn/p/。
     * 若仅修改了价格和库存字段，商品提交审核后会快速通过。
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/spu/update?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "out_product_id": "1234566",
     * "product_id": 1234566,
     * "title": "任天堂 Nintendo Switch 国行续航增强版 NS家用体感游戏机掌机 便携掌上游戏机 红蓝主机",
     * "path": "pages/productDetail/productDetail?productId=2176180",
     * "head_img":
     * [
     * "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg"
     * ],
     * "qualification_pics": [
     * "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg"
     * ],
     * "desc_info":
     * {
     * "desc": "xxxxx",
     * "imgs":
     * [
     * "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg"
     * ]
     * },
     * "third_cat_id": 6666,
     * "brand_id": 2100000000,
     * "info_version": "xxx",
     * "skus":
     * [
     * {
     * "out_product_id": "1234566",
     * "out_sku_id": "1024",
     * "thumb_img": "https://mmecimage.cn/p/wx77e672d6d34a4bed/HNTiaPWTllJ5R2pq9Jv9jRD5bZOWmq2svUUzJcZbcg",
     * "sale_price": 1300,
     * "market_price": 1500,
     * "stock_num": 100,
     * "sku_code": "A24525252",
     * "barcode": "13251454",
     * "sku_attrs":
     * [
     * {
     * "attr_key": "选择颜色",
     * "attr_value": "红蓝主机"
     * },
     * {
     * "attr_key": "选择套装",
     * "attr_value": "主机+保护套"
     * }
     * ]
     * }
     * ]
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "data":
     * {
     * "product_id": 1234566,
     * "out_product_id": "1234566",
     * "update_time": "2020-03-25 12:05:25",
     * "skus":
     * [
     * {
     * "sku_id": 123,
     * "out_sku_id": "1024"
     * }
     * ]
     * }
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * out_product_id string 是 商家自定义商品ID，与product_id二选一
     * product_id number(uint64) 是 交易组件平台内部商品ID，与out_product_id二选一
     * title string 是 标题
     * path string 是 绑定的小程序商品路径
     * head_img string array 是 主图,多张,列表
     * qualification_pics string array 否 商品资质图片
     * desc_info.desc string 否 商品详情图文
     * desc_info.imgs string array 否 商品详情图片
     * third_cat_id number 是 第三级类目ID
     * brand_id number 是 品牌id
     * info_version string 否 预留字段，用于版本控制
     * skus[] object array 是 sku数组
     * skus[].out_product_id string 是 商家自定义商品ID
     * skus[].out_sku_id string 是 商家自定义skuID
     * skus[].thumb_img string 是 sku小图
     * skus[].sale_price number 是 售卖价格,以分为单位
     * skus[].market_price number 是 市场价格,以分为单位
     * skus[].stock_num number 是 库存
     * skus[].barcode string 否 条形码
     * skus[].sku_code string 否 商品编码
     * skus[].sku_attrs[].attr_key string 是 销售属性key（自定义）
     * skus[].sku_attrs[].attr_value string 是 销售属性value（自定义）
     * supplier string 否 供应商名称
     * express_fee number 否 快递费用,以分为单位
     * product_type string 否 商品属性，如：1、预售商品，2、虚拟电子凭证商品，3、自定义
     * sell_time string 否 定时上架时间
     * pick_up_type string array 否 配送方式 1快递 2同城 3上门自提 4点餐
     * onsale number 否 0-不在售 1-在售
     * unitname string 否 商品单位
     * unitfactor number 否 包装因子
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data.product_id number(uint64) 交易组件平台内部商品ID
     * data.out_product_id string 商家自定义商品ID
     * data.update_time string 更新时间
     * data.skus object array sku数组
     * data.skus[].sku_id string 交易组件平台自定义skuID
     * data.skus[].out_sku_id string 商家自定义skuID
     */
    public function update(\Weixin\Wx\Model\Shop\Spu $spu)
    {
        $params = $spu->getParams();
        $rst = $this->_request->post($this->_url . 'update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 上架商品
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/listing_spu.html
     * 接口调用请求说明
     * 如果该商品处于自主下架状态，调用此接口可把直接把商品重新上架 该接口不影响已经在审核流程的草稿数据
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/spu/listing?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "product_id": 324545,
     * "out_product_id": "51514515"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * product_id number(uint64) 否 交易组件平台内部商品ID，与out_product_id二选一
     * out_product_id string 否 商家自定义商品ID，与product_id二选一
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function listing($product_id = "", $out_product_id = "")
    {
        $params = array();
        if (!empty($product_id)) {
            $params['product_id'] = $product_id;
        }
        if (!empty($out_product_id)) {
            $params['out_product_id'] = $out_product_id;
        }
        $rst = $this->_request->post($this->_url . 'listing', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 下架商品
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/delisting_spu.html
     * 接口调用请求说明
     * 从初始值/上架状态转换成自主下架状态
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/spu/delisting?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "product_id": 324545,
     * "out_product_id": "51514515"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * product_id number(uint64) 否 交易组件平台内部商品ID，与out_product_id二选一
     * out_product_id string 否 商家自定义商品ID，与product_id二选一
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function delisting($product_id = "", $out_product_id = "")
    {
        $params = array();
        if (!empty($product_id)) {
            $params['product_id'] = $product_id;
        }
        if (!empty($out_product_id)) {
            $params['out_product_id'] = $out_product_id;
        }
        $rst = $this->_request->post($this->_url . 'delisting', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 更新商品
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/SPU/update_spu_without_audit.html
     * 注意：该免审接口只能更新部分商品字段，影响草稿数据和线上数据，且请求包中的sku必须已经存在于原本的在线数据中（比如out_sku_id="123"如果不在原本的线上数据的sku列表中，将返回错误1000004）
     *
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/spu/update_without_audit?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "out_product_id": "1234566",
     * "product_id": 1234566,
     * "skus":
     * [
     * {
     * "out_sku_id": "1024",
     * "sale_price": 1300,
     * "market_price": 1500,
     * "stock_num": 100,
     * "sku_code": "A24525252",
     * "barcode": "13251454"
     * }
     * ]
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "data":
     * {
     * "product_id": 1234566,
     * "out_product_id": "1234566",
     * "update_time": "2020-03-25 12:05:25"
     * }
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * out_product_id string 是 商家自定义商品ID，与product_id二选一
     * product_id number(uint64) 是 商家自定义商品ID，与product_id二选一
     * skus[] object array 否 sku数组
     * skus[].out_sku_id string skus存在时必填 商家自定义skuID
     * skus[].sale_price number 否 售卖价格,以分为单位
     * skus[].market_price number 否 市场价格,以分为单位
     * skus[].stock_num number 否 库存
     * skus[].barcode string 否 条形码
     * skus[].sku_code string 否 商品编码
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data.product_id number 交易组件平台内部商品ID
     * data.out_product_id string 商家自定义商品ID
     * data.update_time string 更新时间
     * data.skus object array sku数组
     * data.skus[].sku_id string 交易组件平台自定义skuID
     * data.skus[].out_sku_id string 商家自定义skuID
     */
    public function updateWithoutAudit(\Weixin\Wx\Model\Shop\Spu $spu, $product_id = "", $out_product_id = "")
    {
        $params = $spu->getParams();
        if (!empty($product_id)) {
            $params['product_id'] = $product_id;
        }
        if (!empty($out_product_id)) {
            $params['out_product_id'] = $out_product_id;
        }
        $rst = $this->_request->post($this->_url . 'update_without_audit', $params);
        return $this->_client->rst($rst);
    }
}
