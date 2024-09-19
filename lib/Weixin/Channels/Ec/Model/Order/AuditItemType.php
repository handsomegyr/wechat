<?php

namespace Weixin\Channels\Ec\Model\Order;

/**
 * 审核项名称
 */
class AuditItemType
{
    // product_express_pic_url	商品快递单图片url
    // product_packaging_box_panoramic_video_url	商品包装箱全景视频url
    // product_unboxing_panoramic_video_url	商品开箱全景视频url
    // single_product_detail_panoramic_video_url	商品单个细节全景视频url
    const TYPENAME1 = "product_express_pic_url";
    const TYPENAME2 = "product_packaging_box_panoramic_video_url";
    const TYPENAME3 = "product_unboxing_panoramic_video_url";
    const TYPENAME4 = "single_product_detail_panoramic_video_url";
}
