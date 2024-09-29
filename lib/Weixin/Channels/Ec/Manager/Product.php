<?php

namespace Weixin\Channels\Ec\Manager;

use Weixin\Client;

/**
 * 商品管理API
 * https://developers.weixin.qq.com/doc/store/API/product/add.html
 * 
 * @author guoyongrong <handsomegyr@126.com>
 */
class Product
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/channels/ec/product/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 微信小店API /商品管理API /添加商品
     * 添加商品
     * 接口说明
     * 通过该接口可对商品添加进微信小店
     *
     * 注意事项
     * 商品有2份数据，草稿和线上数据，调用接口新增和修改商品数据后，影响的只是草稿数据，要调上架接口，并审核通过，草稿数据才会覆盖线上数据正式生效;
     * 商品sku数量超过25个的情况下，接口会异步更新商品信息;
     * 在上传完成之前调用上架商品接口，会返回10020067，因此如果有更新商品并提交审核的需求，建议直接在本接口将listing参数设置为1，不需要再调用上架商品的接口；
     * 图片相关参数（如head_img、desc_info.imgs、qualifications、product_qua_infos[].qua_url[]、skus[].thumb_img等），请务必使用接口上传图片（参数resp_type=1），并将返回的img_url填入此处，不接受其他任何格式的图片url。若url曾经做过转换（ url前缀为mmecimage.cn/p/），则可以直接提交。
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/add?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * out_product_id string 否 商家自定义商品ID，小店后台不作任何唯一性约束，开发者自行保证，一旦添加成功后该字段无法修改，最多128字符
     * title string 是 标题，应至少含5个有效字符数（中文文字/英文字母/数字，都各算1个有效字符数，且不得仅为数字或英文，不得含非法字符，允许的特殊字符集为：`·~～!@#$%^&()！@#￥%……&*（）-_——=+[]\【】、{} \|｜;'；’:"： ‘“”,./，。、<>?《》？\u00A0\u0020\u3000），最多60字符。
     *
     * 合规商品标题举例：
     * 1.糖醋排骨【预订价10元】；
     * 2.CheddarCheese切达干酪；
     * 3.百岁山天然矿泉水1L*15瓶。
     * 不合规商品标题举例：
     * 1.正宗五指毛桃根√；
     * 2.Classic Whole Wheat；
     * 3.便携式折叠扇第Ⅲ代；
     * 4.iPhone 13；
     * 5.Mac999；
     * 6.[五元]扇子
     * sub_title string 否 副标题，最多18字符
     * head_imgs array[string] 是 主图，多张，列表，最少3张（食品饮料和生鲜类目商品最少4张），最多9张。不得有重复图片。无形状尺寸要求，最终在商详页会显示为正方形
     * deliver_method number 否 发货方式，若为无需快递（仅对部分类目开放），则无需填写运费模版id。0:快递发货（默认），1:无需快递
     * desc_info[] array 否 商品详情信息
     * desc_info[].imgs array[string] 否 商品详情图片（最少1张，最多20张。其中食品饮料和生鲜类目商品最少3张）。不得有重复图片
     * desc_info[].desc string 否 商品详情文本
     * cats[] array 是 商品类目，大小恒等于3（一二三级类目）
     * cats[].cat_id string(uint64) 是 类目ID，需要先通过获取类目接口拿到可用的cat_id；这里的cat_id顺序与一，二，三级类目严格一致，即数组下标为0的是一级类目，数组下标为1的是二级类目，数组下标为2的是三级类目
     * attrs[] array 否 商品参数，部分类目有必填的参数，具体参考文档获取类目信息中的字段attr.product_attr_list[].is_required
     * attrs[].attr_key string 是 属性键key（属性自定义用）
     * attrs[].attr_value string 是 属性值（属性自定义用）。如果添加时没录入，回包可能不包含该字段，参数规则如下：
     * ● 当获取类目信息接口中返回的type：为 select_many，
     * attr_value的格式：多个选项用分号;隔开
     * 示例：某商品的适用人群属性，选择了：青年、中年，则 attr_value的值为：青年;中年
     * ● 当获取类目信息接口中返回的type：为 integer_unit/decimal4_unit
     * attr_value格式：数值 单位，用单个空格隔开
     * 示例：某商品的重量属性，要求integer_unit属性类型，数值部分为 18，单位选择为kg，则 attr_value的值为：18 kg
     * ● 当获取类目信息接口中返回的type：为 integer/decimal4
     * attr_value 的格式：字符串形式的数字
     * spu_code string 否 商品编码
     * brand_id string(uint64) 否 品牌id，无品牌为“2100000000”
     * qualifications array[string] 否 商品资质图片（最多5张）。该字段将被product_qua_infos代替
     * product_qua_infos[] array 否 商品资质列表，取代qualifications，具体参考文档获取类目信息中的字段product_qua_list[]
     * product_qua_infos[].qua_id string(uint64) 否 商品资质id，对应获取类目信息中的字段product_qua_list[].qua_id
     * product_qua_infos[].qua_url[] array(string) 否 商品资质图片列表（单个商品资质id下，最多10张）
     * express_info.template_id string(uint64) 否 运费模板ID（先通过获取运费模板接口拿到），若deliver_method=1，则不用填写
     * express_info.weight number 否 商品重量，单位克，若当前运费模版计价方式为[按重量]，则必填
     * aftersale_desc string 否 售后说明
     * limited_info.period_type number 否 限购周期类型，0:无限购（默认），1:按自然日限购，2:按自然周限购，3:按自然月限购，4:按自然年限购
     * limited_info.limited_buy_num number 否 限购数量
     * extra_service.seven_day_return number 是 是否支持七天无理由退货，0-不支持七天无理由，1-支持七天无理由，2-支持七天无理由(定制商品除外)，3-支持七天无理由(使用后不支持)。管理规则请参见七天无理由退货管理规则。类目是否必须支持七天无理由退货，可参考文档获取类目信息中的字段attr.seven_day_return
     * extra_service.pay_after_use number 是 先用后付，字段已废弃。若店铺已开通先用后付，支持先用后付的类目商品将在上架后自动打开先用后付。管理规则请参见「先用后付」服务商家指南
     * extra_service.freight_insurance number 是 是否支持运费险，0-不支持运费险，1-支持运费险。需要商户开通运费险服务，非必须开通运费险类目的商品依据该字段进行设置，必须开通运费险类目中的商品将默认开启运费险保障，不依据该字段。规则详情请参见 微信小店「运费险」管理规则
     * extra_service.fake_one_pay_three number 否 是否支持假一赔三，0-不支持假一赔三，1-支持假一赔三。
     * extra_service.damage_guarantee number 否 是否支持坏损包退，0-不支持坏损包退，1-支持坏损包退。
     * skus[] array 是 长度最少为1，最大为500
     * skus[].out_sku_id string 否 商家自定义sku_id，小店后台不作任何唯一性约束，开发者自行保证，一旦添加成功后该字段无法修改，最多128字符
     * skus[].thumb_img string 否 sku小图
     * skus[].sale_price number 是 售卖价格，以分为单位，不超过1000000000（1000万元）
     * skus[].stock_num number 是 库存
     * skus[].sku_code string 否 sku编码，最多100字符
     * skus[].sku_attrs[] array 是 销售属性，每个spu下面的第一个sku的sku_attr.key顺序决定商品详情页规格名称的排序。部分类目有必填的销售属性，具体参考文档获取类目信息中的字段attr.sale_attr_list[].is_required
     * skus[].sku_attrs[].attr_key string 是 属性键key，最终展示为商详页sku规格的名称，如“尺码”、“颜色”，最多40字符
     * skus[].sku_attrs[].attr_value string 是 属性值（属性自定义用）。如果添加时没录入，回包可能不包含该字段，参数规则如下：
     * ● 当获取类目信息接口中返回的type：为 select_many，
     * attr_value的格式：多个选项用分号;隔开
     * 示例：某商品的适用人群属性，选择了：青年、中年，则 attr_value的值为：青年;中年
     * ● 当获取类目信息接口中返回的type：为 integer_unit/decimal4_unit
     * attr_value格式：数值 单位，用单个空格隔开
     * 示例：某商品的重量属性，要求integer_unit属性类型，数值部分为 18，单位选择为kg，则 attr_value的值为：18 kg
     * ● 当获取类目信息接口中返回的type：为 integer/decimal4
     * attr_value 的格式：字符串形式的数字
     * skus[].sku_deliver_info.stock_type number 否 sku库存情况。0:现货（默认），1:全款预售。部分类目支持全款预售，具体参考文档获取类目信息中的字段attr.pre_sale
     * skus[].sku_deliver_info.full_payment_presale_delivery_type number 否 sku发货节点，该字段仅对stock_type=1有效。0:付款后n天发货，1:预售结束后n天发货
     * skus[].sku_deliver_info.presale_begin_time number 否 sku预售周期开始时间，秒级时间戳，该字段仅对delivery_type=1有效
     * skus[].sku_deliver_info.presale_end_time number 否 sku预售周期结束时间，秒级时间戳，该字段仅对delivery_type=1有效。限制：预售结束时间距离现在<=30天，即presale_end_time - now <= 2592000。预售时间区间<=15天，即presale_end_time - presale_begin_time <= 1296000
     * skus[].sku_deliver_info.full_payment_presale_delivery_time number 否 sku发货时效，即付款后/预售结束后{full_payment_presale_delivery_time}天内发货，该字段仅对stock_type=1时有效。当发货节点选择“0:付款后n天发货”时，范围是[4, 15]的整数；当发货节点选择“1:预售结束后n天发货”时，范围是[1, 3]的整数
     * listing number 否 添加完成后是否立即上架。1:是；0:否；默认0
     * after_sale_info.after_sale_address_id number 否 售后地址id，使用地址管理相关接口进行添加或获取
     * size_chart.enable bool 否 是否启用尺码表
     * size_chart.specification_list array 否 尺码表，启用尺码表时必填
     * size_chart.specification_list[].name string 是 尺码属性名称
     * size_chart.specification_list[].unit string 是 尺码属性值的单位
     * size_chart.specification_list[].is_range bool 是 尺码属性值是否为区间
     * size_chart.specification_list[].value_list array 是 尺码值与尺码属性值的映射列表
     * size_chart.specification_list[].value_list[].key string 是 尺码值，需与商品属性中的尺码规格保持一致
     * size_chart.specification_list[].value_list[].value string 否 尺码属性值；属性值为单值时填写；不能超过5个字符
     * size_chart.specification_list[].value_list[].left string 否 尺码属性值的左边界，需小于右边界；属性值为区间时填写；不能超过5个字符
     * size_chart.specification_list[].value_list[].right string 否 尺码属性值的右边界，需大于左边界；属性值为区间时填写；不能超过5个字符
     * 请求示例
     * {
     * "title": "任天堂 Nintendo Switch 国行续航增强版 NS家用体感游戏机掌机 便携掌上游戏机 红蓝主机",
     * "sub_title": "随时随地，一起趣玩。",
     * "head_imgs": [
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ"
     * ],
     * "desc_info": {
     * "imgs": [
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ"
     * ],
     * "desc": "物美价廉"
     * },
     * "cats": [
     * {
     * "cat_id": "6033"
     * },
     * {
     * "cat_id": "6057"
     * },
     * {
     * "cat_id": "6091"
     * }
     * ],
     * "attrs": [
     * {
     * "attr_key": "产地",
     * "attr_value": "四川成都"
     * },
     * {
     * "attr_key": "材质",
     * "attr_value": "玻璃"
     * },
     * {
     * "attr_key": "适用人群",
     * "attr_value": "青年;中年"
     * },
     * {
     * "attr_key": "数量",
     * "attr_value": "33"
     * },
     * {
     * "attr_key": "精度",
     * "attr_value": "3.001"
     * },
     * {
     * "attr_key": "重量",
     * "attr_value": "38 mg"
     * },
     * {
     * "attr_key": "毛重",
     * "attr_value": "380 kg"
     * }
     * ],
     * "express_info": {
     * "template_id": "47428464001"
     * },
     * "skus": [
     * {
     * "thumb_img": "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ",
     * "sale_price": 1300,
     * "stock_num": 100,
     * "sku_code": "A24525252",
     * "sku_attrs": [
     * {
     * "attr_key": "产地",
     * "attr_value": "四川成都"
     * },
     * {
     * "attr_key": "材质",
     * "attr_value": "玻璃"
     * },
     * {
     * "attr_key": "适用人群",
     * "attr_value": "青年;中年"
     * },
     * {
     * "attr_key": "数量",
     * "attr_value": "33"
     * },
     * {
     * "attr_key": "精度",
     * "attr_value": "3.001"
     * },
     * {
     * "attr_key": "重量",
     * "attr_value": "38 mg"
     * },
     * {
     * "attr_key": "毛重",
     * "attr_value": "380 kg"
     * }
     * ],
     * "sku_deliver_info": {
     * "stock_type":0
     * }
     * }
     * ],
     * "product_qua_infos": [
     * {
     * "qua_id": "1111488",
     * "qua_url": [
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ",
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn71nCC"
     * ]
     * },
     * {
     * "qua_id": "1111489",
     * "qua_url": [
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ",
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn71nCC"
     * ]
     * }
     * ]
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * product_id string(uint64) 商品ID
     * create_time string 创建时间
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": {
     * "product_id": 23423523452345235,
     * "create_time": "2020-03-25 12:05:25"
     * }
     * }
     */
    public function add(\Weixin\Channels\Ec\Model\Product\Product $product)
    {
        $params = $product->getParams();
        $rst = $this->_request->post($this->_url . 'add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /商品管理API /删除商品
     * 删除商品
     * 接口说明
     * 可通过该接口删除微信小店商品（审核中的商品无法删除）
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/delete?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 商品ID
     * 请求参数示例
     * {
     * "product_id": "324545"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 错误码
     * 错误码 错误描述
     * 公共错误码 -
     * 10020050 无权限调用该api，请获取权限后再试
     * 10020051 参数有误，请按照文档要求传参
     * 10020052 商品不存在
     * 10020049 商品正在审核中，无法编辑或删除，请先调用撤回商品审核接口
     */
    public function delete($product_id)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $rst = $this->_request->post($this->_url . 'delete', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /商品管理API /获取商品
     * 获取商品
     * 接口说明
     * 可通过指定商品ID获取商品具体信息
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 商品ID
     * data_type number 否 默认取1
     * 1:获取线上数据
     * 2:获取草稿数据
     * 3:同时获取线上和草稿数据（注意：上架过的商品才有线上数据）
     * 请求参数示例
     * {
     * "product_id": "324545",
     * "data_type": 1
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * product Objct(Product) 商品线上数据，入参data_type==2时不返回该字段；入参data_type==3且商品从未上架过，不返回该字段，具体参数内容可参考：结构体product
     * edit_product Objct(Product) 商品草稿数据，入参data_type==1时不返回该字段
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "product": {
     * "product_id": "123456789",
     * "out_product_id": "OUT_PRODUCT_ID_TEST",
     * "title": "任天堂 Nintendo Switch 国行续航增强版",
     * "sub_title": "【国行Switch，更安心的保修服务，更快的国行服务器】一台主机三种模式，游戏掌机，随时随地，一起趣玩",
     * "head_imgs": [
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ"
     * ],
     * "desc_info": {
     * "imgs": [
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ"
     * ]
     * },
     * "cats": [
     * {
     * "cat_id": "1"
     * },
     * {
     * "cat_id": "2"
     * },
     * {
     * "cat_id": "3"
     * }
     * ],
     * "attrs": [
     * {
     * "attr_key": "产地",
     * "attr_value": "四川成都"
     * },
     * {
     * "attr_key": "材质",
     * "attr_value": "玻璃"
     * },
     * {
     * "attr_key": "适用人群",
     * "attr_value": "青年;中年"
     * },
     * {
     * "attr_key": "数量",
     * "attr_value": "33"
     * },
     * {
     * "attr_key": "精度",
     * "attr_value": "3.001"
     * },
     * {
     * "attr_key": "重量",
     * "attr_value": "38 mg"
     * },
     * {
     * "attr_key": "毛重",
     * "attr_value": "380 kg"
     * }
     * ],
     * "express_info": {
     * "template_id": "123456"
     * },
     * "status": 5,
     * "edit_status": 2,
     * "skus": [
     * {
     * "sku_id": "123456001",
     * "out_sku_id": "OUT_SKU_ID_TEST",
     * "thumb_img": "",
     * "sale_price": 1,
     * "stock_num": 5,
     * "sku_code": "SKU_CODE_TEST",
     * "sku_attrs": [
     * {
     * "attr_key": "产地",
     * "attr_value": "四川成都"
     * },
     * {
     * "attr_key": "材质",
     * "attr_value": "玻璃"
     * },
     * {
     * "attr_key": "适用人群",
     * "attr_value": "青年;中年"
     * },
     * {
     * "attr_key": "数量",
     * "attr_value": "33"
     * },
     * {
     * "attr_key": "精度",
     * "attr_value": "3.001"
     * },
     * {
     * "attr_key": "重量",
     * "attr_value": "38 mg"
     * },
     * {
     * "attr_key": "毛重",
     * "attr_value": "380 kg"
     * }
     * ],
     * "status": 0
     * }
     * ],
     * "min_price": 1,
     * "spu_code": "SPU_CODE_TEST",
     * "product_qua_infos": [
     * {
     * "qua_id": 1111484,
     * "qua_url": [
     * "https://mmecimage.cn/p/wx2b255582a7b4bfd0/HCnhqIWMZSIAJzzDRNmevAzRXj5ZCAZw8vGKYF1GW8Y"
     * ]
     * },
     * {
     * "qua_id": 1111491,
     * "qua_url": [
     * "https://mmecimage.cn/p/wx2b255582a7b4bfd0/HPySAtxADO1LuDHdmJ7wiSwJzyEicLNTSAE-a10swwM"
     * ]
     * },
     * {
     * "qua_id": 1111492,
     * "qua_url": [
     * "https://mmecimage.cn/p/wx2b255582a7b4bfd0/HGekHKK4yA_s0Ur3wwgil2x_6sZ7RiFpA4JSSfT_gYI",
     * "https://mmecimage.cn/p/wx2b255582a7b4bfd0/HPfiP6fjCN5BeLJ48i9e0zANmKUuv-hyo55nuUk9mBA"
     * ]
     * }
     * ]
     * }
     * }
     */
    public function infoGet($product_id, $data_type = 1)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $params['data_type'] = $data_type;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /商品管理API /获取商品列表
     * 获取商品列表
     * 接口说明
     * 可通过该接口获取微信小店的商品列表
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/list/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * status number 否 商品状态，不填默认拉全部商品（不包含回收站）,具体枚举值请参考status枚举
     * page_size number 是 每页数量（默认10，不超过30）
     * next_key string 否 由上次请求返回，记录翻页的上下文。传入时会从上次返回的结果往后翻一页，不传默认获取第一页数据。
     * 请求参数示例
     * {
     * "status": 5,
     * "page_size": 10,
     * "next_key": "THE_NEXT_KEY"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * product_ids[] string(uint64) array 商品id列表
     * next_key string 本次翻页的上下文，用于请求下一页
     * total_num number 商品总数
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "product_ids": [
     * "1234567001",
     * "1234567002",
     * "1234567003",
     * "1234567004",
     * "1234567005",
     * "1234567006",
     * "1234567007",
     * "1234567008",
     * "1234567009",
     * "1234567010"
     * ],
     * "next_key": "THE_NEXT_KEY_NEW",
     * "total_num": 100
     * }
     */
    public function listGet($status = null, $page_size = 30, $next_key = "")
    {
        $params = array();

        if (isset($status)) {
            $params['status'] = $status;
        }

        $params['page_size'] = $page_size;
        $params['next_key'] = $next_key;
        $rst = $this->_request->post($this->_url . 'list/get', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /商品管理API /更新商品
     * 更新商品
     * 接口说明
     * 该接口用于对微信小店内商品信息的更新
     *
     * 注意事项
     * 商品有2份数据，草稿和线上数据，调用接口新增和修改商品数据后，影响的只是草稿数据，要调用上架商品接口（或本接口参数listing设置为1），并审核通过，草稿数据才会覆盖线上数据正式生效；
     *
     * 商品sku数量超过25个的情况下，接口会异步更新商品信息。在上传完成之前调用上架商品接口，会返回10020067，因此如果有更新商品并提交审核的需求，建议直接在本接口将listing参数设置为1，不需要再调用上架商品的接口；
     *
     * 该接口请求方式和添加商品接口基本一致，区别在于请求该接口时需要带上已存在的product_id；
     *
     * 该接口是覆盖写操作，每次提交后，草稿数据会被整体替换为本次请求上传的数据：
     *
     * 若sku列表中带上已存在的sku_id，则会用新上传的内容更新对应的sku草稿；
     * 若列表中某个的sku没有传入sku_id，则视为新增的sku，分配新的sku_id并插入到商品草稿中；
     * 若原本存在于商品信息中的某个sku_id，在本次更新没有上传，则视为删除，商品草稿将移除该sku，在商品审核通过后，以上变动将作用于线上数据。
     * 图片相关参数（如head_img、desc_info.imgs、qualifications、product_qua_infos[].qua_url[]、skus[].thumb_img等），请务必使用接口上传图片（参数resp_type=1），并将返回的img_url填入此处，不接受其他任何格式的图片url。若url曾经做过转换（ url前缀为mmecimage.cn/p/），则可以直接提交。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/update?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 小店内部商品ID
     * title string 是 标题，应至少含5个有效字符数（中文文字/英文字母/数字，都各算1个有效字符数，且不得仅为数字或英文，不得含非法字符，允许的特殊字符集为：`·~～!@#$%^&()！@#￥%……&*（）-_——=+[]\【】、{} \|｜;'；’:"： ‘“”,./，。、<>?《》？\u00A0\u0020\u3000），最多60字符。
     *
     * 合规商品标题举例：
     * 1.糖醋排骨【预订价10元】；
     * 2.CheddarCheese切达干酪；
     * 3.百岁山天然矿泉水1L*15瓶。
     * 不合规商品标题举例：
     * 1.正宗五指毛桃根√；
     * 2.Classic Whole Wheat；
     * 3.便携式折叠扇第Ⅲ代；
     * 4.iPhone 13；
     * 5.Mac999；
     * 6.[五元]扇子
     * sub_title string 否 副标题，最多18字符
     * head_imgs array[string] 是 主图，多张，列表，最少3张（食品饮料和生鲜类目商品最少4张），最多9张。不得有重复图片。无形状尺寸要求，最终在商详页会显示为正方形
     * deliver_method number 否 发货方式，若为无需快递（仅对部分类目开放），则无需填写运费模版id。0:快递发货（默认），1:无需快递
     * desc_info[] array 否 商品详情信息
     * desc_info[].imgs array[string] 否 商品详情图片（最少1张，最多20张。其中食品饮料和生鲜类目商品最少3张）。不得有重复图片
     * desc_info[].desc string 否 商品详情文本
     * cats[] array 是 商品类目，大小恒等于3（一二三级类目）
     * cats[].cat_id number 是 类目ID，需要先通过获取所有类目接口拿到可用的cat_id；这里的cat_id顺序与一，二，三级类目严格一致，即数组下标为0的是一级类目，数组下标为1的是二级类目，数组下标为2的是三级类目。
     * attrs[] array 否 商品参数，部分类目有必填的参数，具体参考文档获取类目信息中的字段attr.product_attr_list[].is_required
     * attrs[].attr_key string 是 属性键key（属性自定义用）
     * attrs[].attr_value string 是 属性值value（属性自定义用）
     * ● 当获取类目信息接口中返回的type：为 select_many，
     * attr_value的格式：多个选项用分号;隔开
     * 示例：某商品的适用人群属性，选择了：青年、中年，则 attr_value的值为：青年;中年
     * ● 当获取类目信息接口中返回的type：为 integer_unit/decimal4_unit
     * attr_value格式：数值 单位，用单个空格隔开
     * 示例：某商品的重量属性，要求integer_unit属性类型，数值部分为 18，单位选择为kg，则 attr_value的值为：18 kg
     * ● 当获取类目信息接口中返回的type：为 integer/decimal4
     * attr_value 的格式：字符串形式的数字
     * spu_code string 否 商品编码
     * brand_id string(uint64) 否 品牌id，无品牌为“2100000000”
     * qualifications array[string] 否 商品资质图片（最多5张）。该字段将被product_qua_infos代替
     * product_qua_infos[] array 否 商品资质列表，取代qualifications，具体参考文档获取类目信息中的字段product_qua_list[]
     * product_qua_infos[].qua_id string(uint64) 否 商品资质id，对应获取类目信息中的字段product_qua_list[].qua_id
     * product_qua_infos[].qua_url[] array(string) 否 商品资质图片列表（单个商品资质id下，最多10张）
     * express_info.template_id string(uint64) 否 运费模板ID（先通过获取运费模板列表接口拿到），若deliver_method=1，则不用填写
     * express_info.weight number 否 商品重量，单位克，若当前运费模版计价方式为[按重量]，则必填
     * aftersale_desc string 否 售后说明
     * limited_info.period_type number 否 限购周期类型，0:无限购（默认），1:按自然日限购，2:按自然周限购，3:按自然月限购，4:按自然年限购
     * limited_info.limited_buy_num number 否 限购数量
     * extra_service.seven_day_return number 是 是否支持七天无理由退货，0-不支持七天无理由，1-支持七天无理由，2-支持七天无理由(定制商品除外)，3-支持七天无理由(使用后不支持)。管理规则请参见七天无理由退货管理规则。类目是否必须支持七天无理由退货，可参考文档获取类目信息中的字段attr.seven_day_return
     * extra_service.pay_after_use number 是 先用后付，字段已废弃。若店铺已开通先用后付，支持先用后付的类目商品将在上架后自动打开先用后付。管理规则请参见「先用后付」服务商家指南
     * extra_service.freight_insurance number 是 是否支持运费险，0-不支持运费险，1-支持运费险。需要商户开通运费险服务，非必须开通运费险类目的商品依据该字段进行设置，必须开通运费险类目中的商品将默认开启运费险保障，不依据该字段。规则详情请参见 微信小店「运费险」管理规则
     * extra_service.fake_one_pay_three number 否 是否支持假一赔三，0-不支持假一赔三，1-支持假一赔三。
     * extra_service.damage_guarantee number 否 是否支持坏损包退，0-不支持坏损包退，1-支持坏损包退。
     * skus[] array 是 长度最少为1，最大为500
     * skus[].sku_id string(uint64) 否 若填了已存在sku_id，则进行更新sku操作，否则新增sku
     * skus[].out_sku_id string 否 商家自定义sku_id，小店后台不作任何唯一性约束，开发者自行保证，一旦添加成功后该字段无法修改，最多128字符
     * skus[].thumb_img string 否 sku小图
     * skus[].sale_price number 是 售卖价格，以分为单位，不超过1000000000（1000万元）
     * skus[].stock_num number 是 库存
     * skus[].sku_code string 否 sku编码，最多100字符
     * skus[].sku_attrs[] array 是 销售属性，每个spu下面的第一个sku的sku_attr.key顺序决定商品详情页规格名称的排序。部分类目有必填的销售属性，具体参考文档获取类目信息中的字段attr.sale_attr_list[].is_required
     * skus[].sku_attrs[].attr_key string 是 属性键key，最终展示为商详页sku规格的名称，如“尺码”、“颜色”，最多40字符
     * skus[].sku_attrs[].attr_value string 是 属性值value（属性自定义用）
     * ● 当获取类目信息接口中返回的type：为 select_many，
     * attr_value的格式：多个选项用分号;隔开
     * 示例：某商品的适用人群属性，选择了：青年、中年，则 attr_value的值为：青年;中年
     * ● 当获取类目信息接口中返回的type：为 integer_unit/decimal4_unit
     * attr_value格式：数值 单位，用单个空格隔开
     * 示例：某商品的重量属性，要求integer_unit属性类型，数值部分为 18，单位选择为kg，则 attr_value的值为：18 kg
     * ● 当获取类目信息接口中返回的type：为 integer/decimal4
     * attr_value 的格式：字符串形式的数字
     * skus[].sku_deliver_info.stock_type number 否 sku库存情况。0:现货（默认），1:全款预售。部分类目支持全款预售，具体参考文档获取类目信息中的字段attr.pre_sale
     * skus[].sku_deliver_info.full_payment_presale_delivery_type number 否 sku发货节点，该字段仅对stock_type=1有效。0:付款后n天发货，1:预售结束后n天发货
     * skus[].sku_deliver_info.presale_begin_time number 否 sku预售周期开始时间，秒级时间戳，该字段仅对delivery_type=1有效。
     * skus[].sku_deliver_info.presale_end_time number 否 sku预售周期结束时间，秒级时间戳，该字段仅对delivery_type=1有效。限制：预售结束时间距离现在<=30天，即presale_end_time - now <= 2592000。预售时间区间<=15天，即presale_end_time - presale_begin_time <= 1296000
     * skus[].sku_deliver_info.full_payment_presale_delivery_time number 否 sku发货时效，即付款后/预售结束后{full_payment_presale_delivery_time}天内发货，该字段仅对stock_type=1时有效。当发货节点选择“0:付款后n天发货”时，范围是[4, 15]的整数；当发货节点选择“1:预售结束后n天发货”时，范围是[1, 3]的整数
     * listing number 否 更新后是否立即上架。1:是；0:否；默认0
     * after_sale_info.after_sale_address_id number 否 售后地址id，使用地址管理相关接口进行添加或获取
     * size_chart.enable bool 否 是否启用尺码表
     * size_chart.specification_list array 否 尺码表，启用尺码表时必填
     * size_chart.specification_list[].name string 是 尺码属性名称
     * size_chart.specification_list[].unit string 是 尺码属性值的单位
     * size_chart.specification_list[].is_range bool 是 尺码属性值是否为区间
     * size_chart.specification_list[].value_list array 是 尺码值与尺码属性值的映射列表
     * size_chart.specification_list[].value_list[].key string 是 尺码值，需与商品属性中的尺码规格保持一致
     * size_chart.specification_list[].value_list[].value string 否 尺码属性值；属性值为单值时填写；不能超过5个字符
     * size_chart.specification_list[].value_list[].left string 否 尺码属性值的左边界，需小于右边界；属性值为区间时填写；不能超过5个字符
     * size_chart.specification_list[].value_list[].right string 否 尺码属性值的右边界，需大于左边界；属性值为区间时填写；不能超过5个字符
     * 请求参数示例
     * {
     * "product_id": "10000000089215",
     * "title": "任天堂 Nintendo Switch 国行续航增强版 NS家用体感游戏机掌机 便携掌上游戏机 红蓝主机",
     * "sub_title": "随时随地，一起趣玩。【更新】",
     * "head_imgs": [
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ"
     * ],
     * "desc_info": {
     * "imgs": [
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ"
     * ],
     * "desc": "物美价廉"
     * },
     * "cats": [
     * {
     * "cat_id": "6033"
     * },
     * {
     * "cat_id": "6057"
     * },
     * {
     * "cat_id": "6091"
     * }
     * ],
     * "attrs": [
     * {
     * "attr_key": "产地",
     * "attr_value": "四川成都"
     * },
     * {
     * "attr_key": "材质",
     * "attr_value": "玻璃"
     * },
     * {
     * "attr_key": "适用人群",
     * "attr_value": "青年;中年"
     * },
     * {
     * "attr_key": "数量",
     * "attr_value": "33"
     * },
     * {
     * "attr_key": "精度",
     * "attr_value": "3.001"
     * },
     * {
     * "attr_key": "重量",
     * "attr_value": "38 mg"
     * },
     * {
     * "attr_key": "毛重",
     * "attr_value": "380 kg"
     * }
     * ],
     * "express_info": {
     * "template_id": "47428464001"
     * },
     * "skus": [
     * {
     * "sku_id": "462966903",
     * "thumb_img": "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ",
     * "sale_price": 1300,
     * "stock_num": 100,
     * "sku_code": "A24525252",
     * "sku_attrs": [
     * {
     * "attr_key": "产地",
     * "attr_value": "四川成都"
     * },
     * {
     * "attr_key": "材质",
     * "attr_value": "玻璃"
     * },
     * {
     * "attr_key": "适用人群",
     * "attr_value": "青年;中年"
     * },
     * {
     * "attr_key": "数量",
     * "attr_value": "33"
     * },
     * {
     * "attr_key": "精度",
     * "attr_value": "3.001"
     * },
     * {
     * "attr_key": "重量",
     * "attr_value": "38 mg"
     * },
     * {
     * "attr_key": "毛重",
     * "attr_value": "380 kg"
     * }
     * ],
     * "sku_deliver_info": {
     * "stock_type":0
     * }
     * },
     * {
     * "thumb_img": "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ",
     * "sale_price": 1000,
     * "stock_num": 100,
     * "sku_code": "A24525252",
     * "sku_attrs": [
     * {
     * "attr_key": "产地",
     * "attr_value": "四川成都"
     * },
     * {
     * "attr_key": "材质",
     * "attr_value": "玻璃"
     * },
     * {
     * "attr_key": "适用人群",
     * "attr_value": "青年;中年"
     * },
     * {
     * "attr_key": "数量",
     * "attr_value": "33"
     * },
     * {
     * "attr_key": "精度",
     * "attr_value": "3.001"
     * },
     * {
     * "attr_key": "重量",
     * "attr_value": "38 mg"
     * },
     * {
     * "attr_key": "毛重",
     * "attr_value": "380 kg"
     * }
     * ],
     * "sku_deliver_info": {
     * "stock_type":0
     * }
     * }
     * ],
     * "product_qua_infos": [
     * {
     * "qua_id": "1111488",
     * "qua_url": [
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ",
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn71nCC"
     * ]
     * },
     * {
     * "qua_id": "1111489",
     * "qua_url": [
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ",
     * "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn71nCC"
     * ]
     * }
     * ]
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * data.product_id number(uint64) 小店内部商品ID
     * data.update_time string 更新时间
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": {
     * "product_id": "23423523452345235",
     * "update_time": "2020-06-20 10:00:00"
     * }
     * }
     */
    public function update(\Weixin\Channels\Ec\Model\Product\Product $product)
    {
        $params = $product->getParams();
        $rst = $this->_request->post($this->_url . 'update', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /商品管理API /上架商品
     * 上架商品
     * 接口说明
     * 通过该接口可将商品上架到微信小店。
     *
     * 注意事项
     * 商品有2份数据，草稿和线上数据 调用接口新增和修改商品数据后，影响的只是草稿数据，要调上架接口，并审核通过，草稿数据才会覆盖线上数据正式生效;
     * 频繁调用上架接口，会被封禁。建议先检查下商品状态，如果在审核中就不要重复提交了;
     * 当商品处于上传中的状态，即edit_status==7时，调用本接口会返回10020067错误码;
     * 每个小店调用接口新增、更新商品次数会合并计算，频率限制为：每小时200次，每天1000次；
     * 商品新增或更新后撤回均会消耗次数;
     * 已上架的商品仅更新“库存”，不消耗次数。
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/listing?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product string(uint64) 是 商品ID
     * 请求参数示例
     * {
     * "product_id": "1234234"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function listing($product_id)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $rst = $this->_request->post($this->_url . 'listing', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /商品管理API /下架商品
     * 下架商品
     * 接口说明
     * 可通过该接口将商品从微信小店下架
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/delisting?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 商品ID
     * 请求参数示例
     * {
     * "product_id": "1234234"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function delisting($product_id)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $rst = $this->_request->post($this->_url . 'delisting', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /商品管理API /撤回商品审核
     * 撤回商品审核
     * 接口说明
     * 该接口用于撤销微信小店商品审核申请,将商品状态从审核中改为未审核
     *
     * 注意事项
     * 对于审核中（edit_status=2）的商品无法调用更新/删除/上架接口，需要先调用此接口撤回商品审核，使商品流转进入未审核的状态（edit_status=1）。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/audit/cancel?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 商品ID
     * 请求参数示例
     * {
     * "product_id": "324545"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function auditCancel($product_id)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $rst = $this->_request->post($this->_url . 'audit/cancel', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /商品管理API /获取商品H5短链
     * 获取商品H5短链
     * 接口说明
     * 通过该接口可以获取微信小店的商品H5短链
     *
     * 注意事项
     * 本接口只支持对上架销售中的小店自营商品调用。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/h5url/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 商品ID
     * 请求参数示例
     * {
     * "product_id": "324545"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * product_h5url string 商品H5短链
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "product_h5url": "https://channels.weixin.qq.com/shop/a/xsgVVZtSGpqwd45"
     * }
     */
    public function h5urlGet($product_id)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $rst = $this->_request->post($this->_url . 'h5url/get', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /商品管理API /获取商品口令
     * 获取商品口令
     * 接口说明
     * 通过该接口可以获取微信小店的商品微信口令
     *
     * 注意事项
     * 本接口只支持对上架销售中的小店自营商品调用。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/taglink/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 商品ID
     * 请求参数示例
     * {
     * "product_id": "324545"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * product_taglink string 商品微信口令（只支持微信内打开）
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "product_taglink": "#微信小店://微信小店/jMv2lqYonCP1qqv"
     * }
     */
    public function taglinkGet($product_id)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $rst = $this->_request->post($this->_url . 'taglink/get', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /商品管理API /获取商品二维码
     * 获取商品二维码
     * 接口说明
     * 通过该接口可以获取微信小店的商品二维码
     *
     * 注意事项
     * 本接口只支持对上架销售中的小店自营商品调用。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/qrcode/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 商品ID
     * 请求参数示例
     * {
     * "product_id": "324545"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * product_qrcode string 商品二维码链接
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "product_qrcode": "https://store.mp.video.tencent-cloud.com/161/20304/snscosdownload/SH/reserved/642a2b730001a542dbe0b846bcc4b00b002000a1000f4f50"
     * }
     */
    public function qrcodeGet($product_id)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $rst = $this->_request->post($this->_url . 'qrcode/get', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /商品管理API /获取库存
     * 获取库存
     * 接口说明
     * 通过该接口可以获取微信小店的商品库存信息
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/stock/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 内部商品ID
     * sku_id string(uint64) 是 内部sku_id
     * 请求参数示例
     * {
     * "product_id": "10000000088178",
     * "sku_id": "462966239"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * data.normal_stock_num number 通用库存数量
     * data.limited_discount_stock_num string 限时抢购库存数量
     * data.warehouse_stocks[] array[] 区域库存
     * data.warehouse_stocks[].out_warehouse_id string 区域库存外部id
     * data.warehouse_stocks[].num number 区域库存数量
     * data.warehouse_stocks[].lock_stock number 区域库存的锁定库存（已下单未支付的库存）数量
     * data.total_stock_num number 库存总量：通用库存数量 + 限时抢购库存数量 + 区域库存总量
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": {
     * "normal_stock_num": 998,
     * "limited_discount_stock_num": 0,
     * "warehouse_stocks": [{
     * "out_warehouse_id": "test1",
     * "num": 10
     * }, {
     * "out_warehouse_id": "test2",
     * "num": 22
     * }, {
     * "out_warehouse_id": "test3",
     * "num": 33
     * }, {
     * "out_warehouse_id": "test4",
     * "num": 44
     * }],
     * "total_stock_num": 1107
     * }
     * }
     */
    public function stockGet($product_id)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $rst = $this->_request->post($this->_url . 'stock/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /商品管理API /批量获取库存信息
     * 批量获取库存信息
     * 接口说明
     * 通过该接口可以根据商品ID获取当前商品下所有sku的库存
     *
     * 注意事项
     * 单次请求不能超过50个商品ID
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/stock/batchget?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id[] string(uint64) array 是 商品ID列表，上限为50
     * 请求参数示例
     * {
     * "product_id": ["10000017524246"]
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * data.spu_stock_list[] obj array spu库存
     * data.spu_stock_list[].product_id string 商品ID
     * data.spu_stock_list[].sku_stock[] obj array sku库存
     * data.spu_stock_list[].sku_stock[].sku_id string skuID
     * data.spu_stock_list[].sku_stock[].normal_stock_num number 通用库存数量
     * data.spu_stock_list[].sku_stock[].limited_discount_stock_num string 限时抢购库存数量
     * data.spu_stock_list[].sku_stock[].warehouse_stocks[] obj array 区域库存
     * data.spu_stock_list[].sku_stock[].warehouse_stocks[].out_warehouse_id string 区域库存外部id
     * data.spu_stock_list[].sku_stock[].warehouse_stocks[].num number 区域库存数量
     * data.spu_stock_list[].sku_stock[].warehouse_stocks[].lock_stock number 区域库存的锁定库存（已下单未支付的库存）数量
     * data.spu_stock_list[].sku_stock[].finder_total_num number 达人专属计划营销库存
     * data.spu_stock_list[].sku_stock[].total_stock_num number 库存总量：通用库存数量 + 限时抢购库存数量 + 区域库存总量
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": {
     * "spu_stock_list": [{
     * "product_id": "10000017524246",
     * "sku_stock": [{
     * "sku_id": "764787449",
     * "normal_stock_num": 990,
     * "limited_discount_stock_num": 0,
     * "warehouse_stocks": [{
     * "out_warehouse_id": "test4",
     * "num": 44,
     * "lock_stock": 0
     * }, {
     * "out_warehouse_id": "test2",
     * "num": 44,
     * "lock_stock": 0
     * }, {
     * "out_warehouse_id": "test3",
     * "num": 8,
     * "lock_stock": 0
     * }, {
     * "out_warehouse_id": "test1",
     * "num": 80,
     * "lock_stock": 0
     * }],
     * "finder_total_num": 300,
     * "total_stock_num": 1166
     * }]
     * }]
     * }
     * }
     */
    public function stockBatchget(array $product_id)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $rst = $this->_request->post($this->_url . 'stock/batchget', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /商品管理API /获取库存流水
     * 获取库存流水
     * 接口说明
     * 通过该接口可以获取微信小店的商品库存流水
     *
     * 注意事项
     * 最多可以查今天往前180天内的数据。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/stock/getflow?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 内部商品ID
     * sku_id string(uint64) 是 内部sku_id
     * stock_type number 是 库存类型，参考StockType枚举值
     * finder_id string 否 达人的视频号finder_id，若StockType=1则必填
     * begin_time number 是 时间范围开始时间戳，秒级
     * end_time number 是 时间范围结束时间戳，秒级
     * op_type_list array[number] 否 库存事件类型，参考StockFlowOpType枚举值，填空获取全部
     * page_size number 是 每页数量
     * next_key string 否 由上次请求返回，记录翻页的上下文。传入时会从上次返回的结果往后翻一页，不传默认获取第一页数据。
     * 请求参数示例
     * {
     * "product_id": "10000032267694",
     * "sku_id": "1064839936",
     * "stock_type": 0,
     * "begin_time": 1689218360,
     * "end_time": 1689736760,
     * "page_size": 10
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * data.stock_flow_info_list[] obj array 库存流水
     * data.stock_flow_info_list[].amount number 操作数量
     * data.stock_flow_info_list[].beginning_amount number 开始数量
     * data.stock_flow_info_list[].ending_amount number 结束数量
     * data.stock_flow_info_list[].stock_sub_type number 本次开始结束数量的库存子类型，参考StockSubType枚举值
     * data.stock_flow_info_list[].op_type number 库存事件类型，参考StockFlowOpType枚举值
     * data.stock_flow_info_list[].update_time number 流水发生时间，秒级时间戳
     * data.stock_flow_info_list[].ext_info obj 额外信息
     * data.stock_flow_info_list[].ext_info.unmove_from_stock_sub_type number 归还的源库存子类型，参考StockSubType枚举值，该字段仅对仅对op_type=6生效
     * data.stock_flow_info_list[].ext_info.move_to_stock_sub_type number 分配的目标库存子类型，参考StockSubType枚举值，该字段仅对仅对op_type=7生效
     * data.stock_flow_info_list[].ext_info.upload_source number 操作来源，参考UploadSource枚举值，该字段仅对op_type=1/2/3生效
     * data.stock_flow_info_list[].ext_info.order_id string(uint64) 订单id，该字段仅对op_type=4/5生效
     * data.stock_flow_info_list[].ext_info.out_warehouse_id string 区域仓库id，该字段仅对stock_sub_type=3生效
     * data.stock_flow_info_list[].ext_info.limited_discount_id string(uint64) 限时抢购任务id，该字段仅对stock_sub_type=2生效
     * data.stock_flow_info_list[].ext_info.finder_id string 达人的视频号finder_id，该字段仅对move_to_stock_sub_type=4和unmove_from_stock_sub_type=4生效
     * data.next_key string 本次翻页的上下文，用于请求下一页
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": {
     * "stock_flow_info_list": [{
     * "amount": 300,
     * "beginning_amount": 842,
     * "ending_amount": 542,
     * "stock_sub_type": 1,
     * "op_type": 6,
     * "update_time": 1689735682,
     * "ext_info": {
     * "move_to_stock_sub_type": 4,
     * "upload_source": 0,
     * "order_id": "0",
     * "out_warehouse_id": "",
     * "limited_discount_id": "0",
     * "finder_id": "sphn9rhffKDiLAf"
     * }
     * }, {
     * "amount": 1,
     * "beginning_amount": 843,
     * "ending_amount": 842,
     * "stock_sub_type": 1,
     * "op_type": 4,
     * "update_time": 1689520907,
     * "ext_info": {
     * "upload_source": 0,
     * "order_id": "3712984209868589056",
     * "out_warehouse_id": "",
     * "limited_discount_id": "0"
     * }
     * }],
     * "next_key": ""
     * }
     * }
     */
    public function stockGetflow($product_id, $sku_id, $stock_type, $finder_id, $begin_time, $end_time, $op_type_list, $page_size, $next_key = "")
    {
        $params = array();
        $params['product_id'] = $product_id;
        $params['sku_id'] = $sku_id;
        $params['stock_type'] = $stock_type;
        $params['finder_id'] = $finder_id;
        $params['begin_time'] = $begin_time;
        $params['end_time'] = $end_time;
        $params['op_type_list'] = $op_type_list;
        $params['page_size'] = $page_size;
        $params['next_key'] = $next_key;
        $rst = $this->_request->post($this->_url . 'stock/getflow', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /商品管理API /快速更新库存
     * 快速更新库存
     * 接口说明
     * 可通过该接口快速更新微信小店商品的库存
     *
     * 注意事项
     * 该接口仅对曾经上架成功过的商品，且商品草稿状态为非审核中（edit_status != 2 ）适用。本地生活商品不受此规则约束。
     * 调用后立即生效。
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/stock/update?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 内部商品ID
     * sku_id string(uint64) 是 内部sku_id
     * diff_type number 是 修改类型。1: 增加；2:减少；3:设置。
     * 建议使用1或2，不建议使用3，因为使用3在高并发场景可能会出现预期外表现
     * num number 是 增加、减少或者设置的库存值。
     * 请求参数示例
     * {
     * "product_id": "324545",
     * "sku_id": "9328425",
     * "diff_type": 1,
     * "num": 10
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function stockUpdate($product_id, $sku_id, $stock_type, $finder_id, $begin_time, $end_time, $op_type_list, $page_size, $next_key = "")
    {
        $params = array();
        $params['product_id'] = $product_id;
        $params['sku_id'] = $sku_id;
        $params['stock_type'] = $stock_type;
        $params['finder_id'] = $finder_id;
        $params['begin_time'] = $begin_time;
        $params['end_time'] = $end_time;
        $params['op_type_list'] = $op_type_list;
        $params['page_size'] = $page_size;
        $params['next_key'] = $next_key;
        $rst = $this->_request->post($this->_url . 'stock/update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /商品管理API /商品限时抢购 /添加限时抢购任务
     * 添加限时抢购任务
     * 接口说明
     * 可通过该接口添加限时抢购任务
     *
     * 注意事项
     * 本接口已重新上线，抢购活动的规则有更新，请仔细阅读；
     * 每个商品同一时间只能有一个限时抢购任务。如果当前有限时抢购任务没有结束，无论是否开始，都不允许创建第二个限时抢购任务。可以提前修改限时抢购任务状态为结束后，再创建新的任务；
     * 抢购活动的规则要求：
     * 参与抢购的商品库存，必须小于等于现有库存；
     * 抢购开始/结束时间必须设置为一年内（365天）的时间，且活动持续时间不可超过24小时；
     * 参与抢购活动的商品原售卖价必须大于10元，折扣范围1-8.5折，且抢购价必须比原价优惠10元以上。
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/limiteddiscounttask/add?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 参与抢购的商品ID
     * start_time number 是 限时抢购任务开始时间(秒级时间戳)，只能取大于等于当前时间的值(允许有最多十分钟的误差)，且距离当前时间不得超过一年（365天）
     * end_time number 是 限时抢购任务结束时间(秒级时间戳)，必须大于当前时间以及start_time，且距离当前时间不得超过一年（365天）
     * limited_discount_skus[].sku_id string(uint64) 是 参与抢购的商品ID下，不同规格（SKU）的商品信息
     * limited_discount_skus[].sale_price number 是 SKU的抢购价格，必须小于原价（原价为1分钱的商品无法创建抢购任务）
     * limited_discount_skus[].sale_stock number 是 参与抢购的商品库存，必须小于等于现有库存
     * 请求参数示例
     * {
     * "product_id": "1234567001",
     * "start_time": 1614863822,
     * "end_time": 1614873822,
     * "limited_discount_skus": [
     * {
     * "sku_id": "12345678901",
     * "sale_price": 2888,
     * "sale_stock": 3
     * },
     * {
     * "sku_id": "12345678902",
     * "sale_price": 2600,
     * "sale_stock": 50
     * }
     * ]
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * task_id string(uint64) 限时抢购任务ID，创建成功后返回
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "task_id": "12345678"
     * }
     */
    public function limiteddiscounttaskAdd(\Weixin\Channels\Ec\Model\Product\LimitedDiscountTask $limiteddiscounttask)
    {
        $params = $limiteddiscounttask->getParams();
        $rst = $this->_request->post($this->_url . 'limiteddiscounttask/add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /商品管理API /商品限时抢购 /获取限时抢购任务列表
     * 获取限时抢购任务列表
     * 接口说明
     * 可通过该接口获取限时抢购任务
     *
     * 注意事项
     * 本接口已重新上线，限时抢购任务状态status字段含义有修改，可参考枚举值status，请仔细阅读。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/limiteddiscounttask/list/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * status number 否 指定获取某个status状态下的限时抢购任务列表，status枚举值含义可参考status，如果不填，则获取所有状态下的限时抢购任务列表
     * page_size number 是 每页数量(默认10，不超过50)
     * next_key string 否 由上次请求返回，记录翻页的上下文，传入时会从上次返回的结果往后翻一页，不传默认获取第一页数据
     * 请求参数示例
     * {
     * "status": 0,
     * "page_size": 10,
     * "next_key": "THE_NEXT_KEY"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * limited_discount_tasks[].task_id string(uint64) 限时抢购任务ID
     * limited_discount_tasks[].product_id string(uint64) 抢购商品ID
     * limited_discount_tasks[].status number 限时抢购任务状态
     * limited_discount_tasks[].create_time number 限时抢购任务创建时间(秒级时间戳)
     * limited_discount_tasks[].start_time number 限时抢购任务开始时间(秒级时间戳)
     * limited_discount_tasks[].end_time number 限时抢购任务结束时间(秒级时间戳)
     * limited_discount_tasks[].limited_discount_skus[].sku_id string(uint64) 限时抢购任务下不同的sku_id
     * limited_discount_tasks[].limited_discount_skus[].sale_price number 该sku_id的抢购价格
     * limited_discount_tasks[].limited_discount_skus[].sale_stock number 该sku_id设置的抢购数量
     * next_key string 本次翻页的上下文，用于请求下一页
     * total_num number 商品总数
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "limited_discount_tasks": [
     * {
     * "task_id": "12345677",
     * "product_id": "12345678001",
     * "status": 0,
     * "create_time": 1660047026,
     * "start_time": 1660046940,
     * "end_time": 1662293399,
     * "limited_discount_skus": [
     * {
     * "sku_id": "1234567890001",
     * "sale_price": 200,
     * "sale_stock": 10
     * },
     * {
     * "sku_id": "1234567890002",
     * "sale_price": 300,
     * "sale_stock": 10
     * }
     * ]
     * },
     * {
     * "task_id": "12345688",
     * "product_id": "12345678002",
     * "status": 0,
     * "create_time": 1659516539,
     * "start_time": 1659516420,
     * "end_time": 1662022079,
     * "limited_discount_skus": [
     * {
     * "sku_id": "12345678900013",
     * "sale_price": 20,
     * "sale_stock": 6
     * }
     * ]
     * }
     * ],
     * "next_key": "THE_NEXT_KEY_NEW",
     * "total_num": 2
     * }
     */
    public function limiteddiscounttaskGetList($status, $page_size = 50, $next_key = "")
    {
        $params = array();
        $params['status'] = $status;
        $params['page_size'] = $page_size;
        $params['next_key'] = $next_key;
        $rst = $this->_request->post($this->_url . 'limiteddiscounttask/list/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /商品管理API /商品限时抢购 /停止限时抢购任务
     * 停止限时抢购任务
     * 接口说明
     * 可通过该接口提前结束限时抢购任务
     *
     * 注意事项
     * 结束后不允许再开启，状态不可逆。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/limiteddiscounttask/stop?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * task_id string(uint64) 是 限时抢购任务ID
     * 请求参数示例
     * {
     * "task_id": "123456789"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function limiteddiscounttaskStop($task_id)
    {
        $params = array();
        $params['task_id'] = $task_id;
        $rst = $this->_request->post($this->_url . 'limiteddiscounttask/stop', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /商品管理API /商品限时抢购 /删除限时抢购任务
     * 删除限时抢购任务
     * 接口说明
     * 通过该接口可删除已结束的限时抢购任务。
     *
     * 注意事项
     * 对未开始和进行中的限时抢购任务不生效；
     * 删除操作不可逆。
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/product/limiteddiscounttask/delete?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * task_id string(uint64) 是 限时抢购任务ID
     * 请求参数示例
     * {
     * "task_id": "123456789"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function limiteddiscounttaskDelete($task_id)
    {
        $params = array();
        $params['task_id'] = $task_id;
        $rst = $this->_request->post($this->_url . 'limiteddiscounttask/delete', $params);
        return $this->_client->rst($rst);
    }
}
