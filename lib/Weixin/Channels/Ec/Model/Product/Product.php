<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 商品
 */
class Product extends \Weixin\Model\Base
{
    /**
     * product_id	string(uint64)	是	小店内部商品ID
     */
    public $product_id = NULL;

    /**
     * out_product_id	string	否	商家自定义商品ID，小店后台不作任何唯一性约束，开发者自行保证，一旦添加成功后该字段无法修改，最多128字符
     */
    public $out_product_id = NULL;

    /**
     * title	string	是	标题，应至少含5个有效字符数（中文文字/英文字母/数字，都各算1个有效字符数，且不得仅为数字或英文，不得含非法字符，允许的特殊字符集为：`·~～!@#$%^&()！@#￥%……&*（）-_——=+[]\【】、{} \|｜;'；’:"： ‘“”,./，。、<>?《》？\u00A0\u0020\u3000），最多60字符。
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
     */
    public $title = NULL;

    /**
     * sub_title	string	否	副标题，最多18字符
     */
    public $sub_title = NULL;

    /**
     * head_imgs	array[string]	是	主图，多张，列表，最少3张（食品饮料和生鲜类目商品最少4张），最多9张。不得有重复图片。无形状尺寸要求，最终在商详页会显示为正方形
     */
    public $head_imgs = NULL;

    /**
     * deliver_method	number	否	发货方式，若为无需快递（仅对部分类目开放），则无需填写运费模版id。0:快递发货（默认），1:无需快递
     */
    public $deliver_method = NULL;

    /**
     * desc_info[]	array	否	商品详情信息
     */
    public $desc_info = NULL;

    /**
     * cats[]	array	是	商品类目，大小恒等于3（一二三级类目）
     */
    public $cats = NULL;

    /**
     * attrs[]	array	否	商品参数，部分类目有必填的参数，具体参考文档获取类目信息中的字段attr.product_attr_list[].is_required
     */
    public $attrs = NULL;

    /**
     * spu_code	string	否	商品编码
     */
    public $spu_code = NULL;

    /**
     * brand_id	string(uint64)	否	品牌id，无品牌为“2100000000”
     */
    public $brand_id = NULL;

    /**
     * qualifications	array[string]	否	商品资质图片（最多5张）。该字段将被product_qua_infos代替
     */
    public $qualifications = NULL;

    /**
     * product_qua_infos[]	array	否	商品资质列表，取代qualifications，具体参考文档获取类目信息中的字段product_qua_list[]
     */
    public $product_qua_infos = NULL;

    /**
     * @var \Weixin\Channels\Ec\Model\Product\ExpressInfo
     * express_info	string	是	运费模板
     */
    public $express_info = NULL;

    /**
     * aftersale_desc	string	否	售后说明
     */
    public $aftersale_desc = NULL;

    /**
     * @var \Weixin\Channels\Ec\Model\Product\LimitedInfo
     * limited_info	string	是	限购
     */
    public $limited_info = NULL;

    /**
     * @var \Weixin\Channels\Ec\Model\Product\ExtraService
     * extra_service	string	是	额外信息
     */
    public $extra_service = NULL;

    /**
     * skus[]	array	是	长度最少为1，最大为500
     */
    public $skus = NULL;

    /**
     * listing	number	否	添加完成后是否立即上架。1:是；0:否；默认0
     */
    public $listing = NULL;

    /**
     * @var \Weixin\Channels\Ec\Model\Product\AfterSaleInfo
     * after_sale_info	string	是	售后
     */
    public $after_sale_info = NULL;

    /**
     * @var \Weixin\Channels\Ec\Model\Product\SizeChart
     * size_chart	string	是	尺码表
     */
    public $size_chart = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->product_id)) {
            $params['product_id'] = $this->product_id;
        }

        if ($this->isNotNull($this->out_product_id)) {
            $params['out_product_id'] = $this->out_product_id;
        }

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }

        if ($this->isNotNull($this->sub_title)) {
            $params['sub_title'] = $this->sub_title;
        }

        if ($this->isNotNull($this->head_imgs)) {
            $params['head_imgs'] = $this->head_imgs;
        }

        if ($this->isNotNull($this->deliver_method)) {
            $params['deliver_method'] = $this->deliver_method;
        }

        if ($this->isNotNull($this->desc_info)) {
            foreach ($this->desc_info as $desc) {
                $params['desc_info'][] = $desc->getParams();
            }
        }

        if ($this->isNotNull($this->cats)) {
            foreach ($this->cats as $cat) {
                $params['cats'][] = $cat->getParams();
            }
        }

        if ($this->isNotNull($this->attrs)) {
            foreach ($this->attrs as $attr) {
                $params['attrs'][] = $attr->getParams();
            }
        }

        if ($this->isNotNull($this->spu_code)) {
            $params['spu_code'] = $this->spu_code;
        }

        if ($this->isNotNull($this->brand_id)) {
            $params['brand_id'] = $this->brand_id;
        }

        if ($this->isNotNull($this->qualifications)) {
            $params['qualifications'] = $this->qualifications;
        }

        if ($this->isNotNull($this->product_qua_infos)) {
            foreach ($this->product_qua_infos as $product_qua_info) {
                $params['product_qua_infos'][] = $product_qua_info->getParams();
            }
        }

        if ($this->isNotNull($this->express_info)) {
            $params['express_info'] = $this->express_info->getParams();
        }
        if ($this->isNotNull($this->aftersale_desc)) {
            $params['aftersale_desc'] = $this->aftersale_desc;
        }

        if ($this->isNotNull($this->limited_info)) {
            $params['limited_info'] = $this->limited_info->getParams();
        }

        if ($this->isNotNull($this->extra_service)) {
            $params['extra_service'] = $this->extra_service->getParams();
        }

        if ($this->isNotNull($this->skus)) {
            foreach ($this->skus as $sku) {
                $params['skus'][] = $sku->getParams();
            }
        }

        if ($this->isNotNull($this->listing)) {
            $params['listing'] = $this->listing;
        }

        if ($this->isNotNull($this->after_sale_info)) {
            $params['after_sale_info'] = $this->after_sale_info->getParams();
        }

        if ($this->isNotNull($this->size_chart)) {
            $params['size_chart'] = $this->size_chart->getParams();
        }

        return $params;
    }
}
