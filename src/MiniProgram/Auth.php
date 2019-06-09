<?php


namespace EasySwoole\WeChat\MiniProgram;

use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Utility\HttpClient;

/**
 * Class Auth
 *
 * @package EasySwoole\WeChat\MiniProgram
 */
class Auth extends MinProgramBase
{
    /**
     * Code换取Session
     * @param string $code
     * @return array
     * @throws MiniProgramError
     * @throws RequestError
     */
    public function session(string $code): array
    {
        $url = ApiUrl::generateURL(ApiUrl::AUTH_CODE2SESSION, [
            'APPID'  => $this->getMiniProgram()->getConfig()->getAppId(),
            'SECRET' => $this->getMiniProgram()->getConfig()->getAppSecret(),
            'JSCODE' => $code
        ]);

        $responseArray = HttpClient::getForJson($url);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 支付后获取UNI_ID(微信订单号)
     * @param $openid
     * @param $transaction_id
     * @return array
     * @throws MiniProgramError
     * @throws RequestError
     */
    public function getPadiUnionidByTransaction($openid, $transaction_id)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::AUTH_GET_PAID_UNIONID, [
            'ACCESS_TOKEN' => $token,
            'OPENID'       => $openid
        ], ['transaction_id' => $transaction_id]);

        $responseArray = HttpClient::getForJson($url);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 支付后获取UNI_ID(商户订单号)
     * @param $openid
     * @param $mch_id
     * @param $out_trade_no
     * @return array
     * @throws MiniProgramError
     * @throws RequestError
     */
    public function getPadiUnionidByOutTradeNo($openid, $mch_id, $out_trade_no)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::AUTH_GET_PAID_UNIONID, [
            'ACCESS_TOKEN' => $token,
            'OPENID'       => $openid
        ], ['out_trade_no' => $out_trade_no, 'mch_id' => $mch_id]);

        $responseArray = HttpClient::getForJson($url);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }
}