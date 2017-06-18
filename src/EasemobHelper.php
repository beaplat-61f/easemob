<?php
namespace Beaplat\Easemob;

use GuzzleHttp\Client;

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
        return json_decode($response->getBody()->getContents());
    }
}
