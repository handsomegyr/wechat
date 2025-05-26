<?php

namespace Weixin\Wx\Model\Funds;

/**
 * 账户类型,需要与开店主体一致
 */
class AccountInfo extends \Weixin\Model\Base
{
    // BankAccountType
    // 枚举值	说明
    // ACCOUNT_TYPE_BUSINESS	对公银行账户
    // ACCOUNT_TYPE_PRIVATE	经营者个人银行卡

    // bank_account_type	string	是	账户类型,需要与开店主体一致，详见BankAccountType
    public $bank_account_type = NULL;
    // account_bank	string	是	开户银行（获取开户银行, 搜索银行列表)
    public $account_bank = NULL;
    // bank_address_code	string	是	开户银行省市编码（获取城市列表）
    public $bank_address_code = NULL;
    // bank_branch_id	string	否	开户银行联行号(获取支行联号)
    public $bank_branch_id = NULL;
    // bank_name	string	否	开户银行全称（若开户银行为“其他银行”，则需二选一填写“开户银行全称（含支行）”或“开户银行联行号”）(获取支行信息))
    public $bank_name = NULL;
    // account_number	string	是	银行账号
    public $account_number = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();
        // bank_account_type	string	是	账户类型,需要与开店主体一致，详见BankAccountType
        if ($this->isNotNull($this->bank_account_type)) {
            $params['bank_account_type'] = $this->bank_account_type;
        }
        // account_bank	string	是	开户银行（获取开户银行, 搜索银行列表)
        if ($this->isNotNull($this->account_bank)) {
            $params['account_bank'] = $this->account_bank;
        }
        // bank_address_code	string	是	开户银行省市编码（获取城市列表）
        if ($this->isNotNull($this->bank_address_code)) {
            $params['bank_address_code'] = $this->bank_address_code;
        }
        // bank_branch_id	string	否	开户银行联行号(获取支行联号)
        if ($this->isNotNull($this->bank_branch_id)) {
            $params['bank_branch_id'] = $this->bank_branch_id;
        }
        // bank_name	string	否	开户银行全称（若开户银行为“其他银行”，则需二选一填写“开户银行全称（含支行）”或“开户银行联行号”）(获取支行信息))
        if ($this->isNotNull($this->bank_name)) {
            $params['bank_name'] = $this->bank_name;
        }
        // account_number	string	是	银行账号
        if ($this->isNotNull($this->account_number)) {
            $params['account_number'] = $this->account_number;
        }
        return $params;
    }
}
