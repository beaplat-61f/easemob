<?php
namespace Beaplat\Easemob;

use Cache;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class EasemobHelper
{
    private $client_id;
    private $client_secret;
    private $org_name;
    private $app_name;
    private $base_url;
    private $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client_id = config('easemob.client_id');
        $this->client_secret = config('easemob.client_secret');
        $this->org_name = config('easemob.org_name');
        $this->app_name = config('easemob.app_name');
        $this->base_url = 'https://a1.easemob.com/' . $this->org_name . '/' . $this->app_name;
        // set default header
//        $this->client->setDefaultOption('headers', [
//            'Authorization' => Cache::get('easemob_token', ''),
//        ]);
    }

    public function getToken()
    {
        $options = [
            "grant_type"    => "client_credentials",
            "client_id"     => $this->client_id,
            "client_secret" => $this->client_secret
        ];
        $response = $this->client->post($this->base_url . '/token', [
            'body' => json_encode($options)
        ]);
        $result = json_decode($response->getBody()->getContents());
        // 为了兼容Laravel 5.3以下版本，就不使用cache()方法了
        // 向下取整
        $token = 'Bearer ' . $result->access_token;
        Cache::put('easemob_token', $token, floor($result->expires_in / 60));
        return $token;
    }

    public function createUser($username, $password)
    {
        $options = [
            "username" => $username,
            "password" => $password
        ];

        // 过多的try catch是否过于臃肿
        try {
            $response = $this->client->post($this->base_url . '/users', [
                'body' => json_encode($options)
            ],[
                'Authorization' => Cache::get('easemob_token'),
            ]);
            return json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
//            return $e->getResponse()->getStatusCode();
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }
}
