<?php

namespace Weixin\Wx\Model\Shop\Audit;

/**
 * 品牌信息
 */
class BrandInfo extends \Weixin\Model\Base
{
    /**
     * brand_audit_type	uint32	是	是	是	是	认证审核类型 RegisterType
     */
    public $brand_audit_type = NULL;

    /**
     * trademark_type	string	是	是	是	是	商标分类 TrademarkType
     */
    public $trademark_type = NULL;

    /**
     * brand_management_type	uint32	是	是	是	是	选择品牌经营类型 BrandManagementType
     */
    public $brand_management_type = NULL;

    /**
     * commodity_origin_type	uint32	是	是	是	是	商品产地是否进口 CommodityOriginType
     */
    public $commodity_origin_type = NULL;

    /**
     * brand_wording	string	是	是	是	是	商标/品牌词
     */
    public $brand_wording = NULL;

    /**
     * sale_authorization	string array	否	否	是	是	销售授权书（如商持人为自然人，还需提供有其签名的身份证正反面扫描件)，图片url/media_id
     */
    public $sale_authorization = NULL;

    /**
     * trademark_registration_certificate	string array	是	否	是	否	商标注册证书，图片url/media_id
     */
    public $trademark_registration_certificate = NULL;

    /**
     * trademark_change_certificate	string array	否	否	否	否	商标变更证明，图片url/media_id
     */
    public $trademark_change_certificate = NULL;

    /**
     * trademark_registrant	string	是	否	是	否	商标注册人姓名
     */
    public $trademark_registrant = NULL;

    /**
     * trademark_registrant_nu	string	是	是	是	是	商标注册号/申请号
     */
    public $trademark_registrant_nu = NULL;

    /**
     * trademark_authorization_period	string	是	否	是	否	商标有效期，yyyy-MM-dd HH:mm:ss
     */
    public $trademark_authorization_period = NULL;

    /**
     * trademark_registration_application	string array	否	是	否	是	商标注册申请受理通知书，图片url/media_id
     */
    public $trademark_registration_application = NULL;

    /**
     * trademark_applicant	string	否	是	否	是	商标申请人姓名
     */
    public $trademark_applicant = NULL;

    /**
     * trademark_application_time	string	否	是	否	是	商标申请时间, yyyy-MM-dd HH:mm:ss
     */
    public $trademark_application_time = NULL;

    /**
     * imported_goods_form	string array	否	否	否	否	中华人民共和国海关进口货物报关单，图片url/media_id
     */
    public $imported_goods_form = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->brand_audit_type)) {
            $params['brand_audit_type'] = $this->brand_audit_type;
        }

        if ($this->isNotNull($this->trademark_type)) {
            $params['trademark_type'] = $this->trademark_type;
        }

        if ($this->isNotNull($this->brand_management_type)) {
            $params['brand_management_type'] = $this->brand_management_type;
        }

        if ($this->isNotNull($this->commodity_origin_type)) {
            $params['commodity_origin_type'] = $this->commodity_origin_type;
        }

        if ($this->isNotNull($this->brand_wording)) {
            $params['brand_wording'] = $this->brand_wording;
        }

        if ($this->isNotNull($this->sale_authorization)) {
            $params['sale_authorization'] = $this->sale_authorization;
        }

        if ($this->isNotNull($this->trademark_registration_certificate)) {
            $params['trademark_registration_certificate'] = $this->trademark_registration_certificate;
        }

        if ($this->isNotNull($this->trademark_change_certificate)) {
            $params['trademark_change_certificate'] = $this->trademark_change_certificate;
        }

        if ($this->isNotNull($this->trademark_registrant)) {
            $params['trademark_registrant'] = $this->trademark_registrant;
        }

        if ($this->isNotNull($this->trademark_registrant_nu)) {
            $params['trademark_registrant_nu'] = $this->trademark_registrant_nu;
        }

        if ($this->isNotNull($this->trademark_authorization_period)) {
            $params['trademark_authorization_period'] = $this->trademark_authorization_period;
        }

        if ($this->isNotNull($this->trademark_registration_application)) {
            $params['trademark_registration_application'] = $this->trademark_registration_application;
        }

        if ($this->isNotNull($this->trademark_applicant)) {
            $params['trademark_applicant'] = $this->trademark_applicant;
        }

        if ($this->isNotNull($this->trademark_application_time)) {
            $params['trademark_application_time'] = $this->trademark_application_time;
        }

        if ($this->isNotNull($this->imported_goods_form)) {
            $params['imported_goods_form'] = $this->imported_goods_form;
        }

        return $params;
    }
}
