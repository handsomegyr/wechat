<?php

namespace Weixin\Channels\Ec\Model\Order;

/**
 * 订单状态
 */
class RequestOrderStatus
{
    // 10	待付款
    const WAITING_PAY = 10;
    // 20	待发货（包括部分发货
    const WAITING_DELIVERY = 20;
    // 21	部分发货
    const PARTIAL_DELIVERY = 21;
    // 30	待收货（包括部分发货）
    const WAITING_SIGN = 30;
    // 100	完成
    const FINISH = 100;
    // 250	订单取消（包括未付款取消，售后取消等）
    const CANCEL = 250;
}
