<?php

namespace Weixin\Qy\Model;

/**
 * 群聊会话构体
 */
class Appchat extends \Weixin\Model\Base
{

    /**
     * name 否 群聊名，最多50个utf8字符，超过将截断
     */
    public $name = NULL;

    /**
     * owner 否 指定群主的id。如果不指定，系统会随机从userlist中选一人作为群主
     */
    public $owner = NULL;

    /**
     * userlist 是 群成员id列表。至少2人，至多500人
     */
    public $userlist = NULL;

    /**
     * chatid 否 群聊的唯一标志，不能与已有的群重复；字符串类型，最长32个字符。只允许字符0-9及字母a-zA-Z。如果不填，系统会随机生成群id
     */
    public $chatid = NULL;

    /**
     * add_user_list 否 添加成员的id列表
     */
    public $add_user_list = NULL;

    /**
     * del_user_list 否 踢出成员的id列表
     */
    public $del_user_list = NULL;

    public function __construct(array $userlist)
    {
        $this->userlist = $userlist;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        if ($this->isNotNull($this->owner)) {
            $params['owner'] = $this->owner;
        }
        if ($this->isNotNull($this->userlist)) {
            $params['userlist'] = $this->userlist;
        }
        if ($this->isNotNull($this->chatid)) {
            $params['chatid'] = $this->chatid;
        }
        if ($this->isNotNull($this->add_user_list)) {
            $params['add_user_list'] = $this->add_user_list;
        }
        if ($this->isNotNull($this->del_user_list)) {
            $params['del_user_list'] = $this->del_user_list;
        }
        return $params;
    }
}
