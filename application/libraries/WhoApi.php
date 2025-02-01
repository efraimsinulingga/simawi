<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WhoApi {
    private $CI;
    private $tokenEndpoint = "https://icdaccessmanagement.who.int/connect/token";
    private $apiUrl2 = "https://id.who.int/icd/entity/search?q=diabetes";
    private $apiUrl = "https://id.who.int/icdapi/entity/search?q=1697&release=11&useFuzzy=false&limit=10";
    private $clientId;
    private $clientSecret;
    private $scope = "icdapi_access";
    private $grantType = "client_credentials";
    private $accessToken;

    public function __construct() {        
        $this->CI =& get_instance();
                
        $this->CI->config->load('api_who', TRUE);
        
        $this->clientId = $this->CI->config->item('client_id', 'api_who');
        $this->clientSecret = $this->CI->config->item('client_secret', 'api_who');
    }

    private function getToken() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->tokenEndpoint);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'scope' => $this->scope,
            'grant_type' => $this->grantType
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $result = curl_exec($ch);
        curl_close($ch);

        $jsonArray = json_decode($result, true);
        $this->accessToken = $jsonArray['access_token'] ?? null;
    }

    public function fetchData() {
        if (!$this->accessToken) {
            $this->getToken();
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->accessToken,
            'Accept: application/json',
            'Accept-Language: en',
            'API-Version: v2'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}