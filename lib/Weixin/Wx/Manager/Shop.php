<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;
use Weixin\Wx\Manager\Shop\Cat;
use Weixin\Wx\Manager\Shop\Img;
use Weixin\Wx\Manager\Shop\Spu;
use Weixin\Wx\Manager\Shop\Audit;
use Weixin\Wx\Manager\Shop\Order;
use Weixin\Wx\Manager\Shop\Scene;
use Weixin\Wx\Manager\Shop\Coupon;
use Weixin\Wx\Manager\Shop\Account;
use Weixin\Wx\Manager\Shop\Delivery;
use Weixin\Wx\Manager\Shop\Promoter;
use Weixin\Wx\Manager\Shop\Register;
use Weixin\Wx\Manager\Shop\Aftersale;

/**
 * 自定义版交易组件
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/Introduction2.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Shop
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/shop/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 获取商家入驻管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Account
	 */
	public function getAccount()
	{
		return new Account($this->_client);
	}
	/**
	 * 获取售后管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Aftersale
	 */
	public function getAftersale()
	{
		return new Aftersale($this->_client);
	}
	/**
	 * 获取审核管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Audit
	 */
	public function getAudit()
	{
		return new Audit($this->_client);
	}
	/**
	 * 获取商品类目管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Cat
	 */
	public function getCat()
	{
		return new Cat($this->_client);
	}
	/**
	 * 获取优惠券管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Coupon
	 */
	public function getCoupon()
	{
		return new Coupon($this->_client);
	}
	/**
	 * 获取物流管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Delivery
	 */
	public function getDelivery()
	{
		return new Delivery($this->_client);
	}
	/**
	 * 获取图片管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Img
	 */
	public function getImg()
	{
		return new Img($this->_client);
	}
	/**
	 * 获取订单管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Order
	 */
	public function getOrder()
	{
		return new Order($this->_client);
	}
	/**
	 * 获取推广员管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Promoter
	 */
	public function getPromoter()
	{
		return new Promoter($this->_client);
	}
	/**
	 * 获取接入申请管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Register
	 */
	public function getRegister()
	{
		return new Register($this->_client);
	}
	/**
	 * 获取场景值管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Scene
	 */
	public function getScene()
	{
		return new Scene($this->_client);
	}
	/**
	 * 获取SPU管理器
	 *
	 * @return \Weixin\Wx\Manager\Shop\Spu
	 */
	public function getSpu()
	{
		return new Spu($this->_client);
	}
}
