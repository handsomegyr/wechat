<p align="center">

<p align="center">微信公众平台开发模式通用接口API新版</p>
[![MIT](https://img.shields.io/packagist/l/doctrine/orm.svg)](https://github.com/handsomegyr/wechat/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/handsomegyr/wechat.svg?branch=master)](https://travis-ci.org/handsomegyr/wechat)
[![Coverage](https://img.shields.io/codecov/c/github/handsomegyr/wechat/master.svg)](https://codecov.io/gh/handsomegyr/wechat)

## Requirement

1. PHP >= 5.5
2. **[Composer](https://getcomposer.org/)**

## Installation

```shell
$ composer require "handsomegyr/wechat" -vvv
```

## Usage

基本使用（以服务端为例）:

```php
<?php
$client = new \Weixin\Client();
$client->setAccessToken($access_token);

echo "<br/>将一条长链接转成短链接接口<br/>";
$long_url = 'http://www.baidu.com/?a=1&b=2&c=3';
$ret = $client->getShortUrlManager()->long2short($long_url);
print_r($ret);
```

## Documentation



## License

MIT

