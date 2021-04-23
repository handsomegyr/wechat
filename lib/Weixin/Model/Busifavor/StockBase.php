<?php

namespace Weixin\Model\Busifavor;

use Weixin\Model\Base;

/**
 * 券的基类
 */
abstract class StockBase extends Base
{
    public static $STOCK_TYPE = array(
        "NORMAL" => "NORMAL"
    );
}
