<?php

/**
 * 小程序客户端总调度器
 * 
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Weixin\Wx;

use Weixin\Wx\Manager\Shop;
use Weixin\Wx\Manager\Msg;
use Weixin\Wx\Manager\Card;
use Weixin\Wx\Manager\Mall;
use Weixin\Wx\Manager\User;
use Weixin\Wx\Manager\Soter;
use Weixin\Wx\Manager\Qrcode;
use Weixin\Wx\Manager\Urllink;
use Weixin\Wx\Manager\Internet;
use Weixin\Wx\Manager\Merchant;
use Weixin\Wx\Manager\Security;
use Weixin\Wx\Manager\Shortlink;
use Weixin\Wx\Manager\Urlscheme;
use Weixin\Wx\Manager\RiskControl;
use Weixin\Wx\Manager\ServiceMarket;
use Weixin\Wx\Manager\PhoneNumber;

class Client
{

    private $_client;

    public function __construct(\Weixin\Client $client)
    {
        $this->_client = $client;
    }

    /**
     * 获取小程序消息管理器
     *
     * @return \Weixin\Wx\Manager\Msg
     */
    public function getMsgManager()
    {
        return new Msg($this->_client);
    }

    /**
     * 获取二维码管理器
     *
     * @return \Weixin\Wx\Manager\Qrcode
     */
    public function getQrcodeManager()
    {
        return new Qrcode($this->_client);
    }

    /**
     * 获取门店小程序管理器
     *
     * @return \Weixin\Wx\Manager\Merchant
     */
    public function getMerchantManager()
    {
        return new Merchant($this->_client);
    }

    /**
     * 获取小程序卡券管理器
     *
     * @return \Weixin\Wx\Manager\Card
     */
    public function getCardManager()
    {
        return new Card($this->_client);
    }

    /**
     * 获取小程序购物单管理器
     *
     * @return \Weixin\Wx\Manager\Mall
     */
    public function getMallManager()
    {
        return new Mall($this->_client);
    }

    /**
     * 获取小程序用户管理器
     *
     * @return \Weixin\Wx\Manager\User
     */
    public function getUserManager()
    {
        return new User($this->_client);
    }

    /**
     * 获取Urlscheme管理器
     *
     * @return \Weixin\Wx\Manager\Urlscheme
     */
    public function getUrlschemeManager()
    {
        return new Urlscheme($this->_client);
    }

    /**
     * 获取Urllink管理器
     *
     * @return \Weixin\Wx\Manager\Urllink
     */
    public function getUrllinkManager()
    {
        return new Urllink($this->_client);
    }

    /**
     * 获取Shortlink管理器
     *
     * @return \Weixin\Wx\Manager\Shortlink
     */
    public function getShortlinkManager()
    {
        return new Shortlink($this->_client);
    }

    /**
     * 获取生物认证管理器
     *
     * @return \Weixin\Wx\Manager\Soter
     */
    public function getSoterManager()
    {
        return new Soter($this->_client);
    }

    /**
     * 获取服务市场管理器
     *
     * @return \Weixin\Wx\Manager\ServiceMarket
     */
    public function getServiceMarketManager()
    {
        return new ServiceMarket($this->_client);
    }

    /**
     * 获取安全风控管理器
     *
     * @return \Weixin\Wx\Manager\RiskControl
     */
    public function getRiskControlManager()
    {
        return new RiskControl($this->_client);
    }

    /**
     * 获取网络管理器
     *
     * @return \Weixin\Wx\Manager\Internet
     */
    public function getInternetManager()
    {
        return new Internet($this->_client);
    }

    /**
     * 获取内容安全管理器
     *
     * @return \Weixin\Wx\Manager\Security
     */
    public function getSecurityManager()
    {
        return new Security($this->_client);
    }

    /**
     * 获取自定义版交易组件管理器
     *
     * @return \Weixin\Wx\Manager\Shop
     */
    public function getShopManager()
    {
        return new Shop($this->_client);
    }

    /**
     * 获取手机号管理器
     *
     * @return \Weixin\Wx\Manager\PhoneNumber
     */
    public function getPhoneNumberManager()
    {
        return new PhoneNumber($this->_client);
    }

    /**
     * 获取物流助手总调度器
     *
     * @return \Weixin\Wx\Express\Business\Client
     */
    public function getExpressBusinessClient()
    {
        return new \Weixin\Wx\Express\Business\Client($this->_client);
    }
}
