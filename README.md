<p align="center">

<p align="center">微信公众平台开发模式通用接口API新版</p>

<p align="center">
[![Build Status](https://www.travis-ci.org/handsomegyr/wechat.svg?branch=master)](https://www.travis-ci.org/handsomegyr/wechat)
</p>

</div>

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


## Contributors

This project exists thanks to all the people who contribute. [[Contribute](CONTRIBUTING.md)].
<a href="https://github.com/handsomegyr/wechat/graphs/contributors"></a>



## License

MIT

