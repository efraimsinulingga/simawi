<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WhoApiv2 {
    private $CI;
    private $tokenEndpoint = "https://icdaccessmanagement.who.int/connect/token";
    private $apiUrl = "https://id.who.int/icd/entity/search";
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'scope' => $this->scope,
            'grant_type' => $this->grantType
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            log_message('error', "Failed to get access token. HTTP Code: $httpCode, Response: $result");
            return false;
        }

        $jsonArray = json_decode($result, true);
        $this->accessToken = $jsonArray['access_token'] ?? null;

        if (!$this->accessToken) {
            log_message('error', "Access token not found in response.");
            return false;
        }

        return true;
    }

    public function fetchData($query, $release = "11", $useFuzzy = false, $limit = 10) {
        if (!$this->accessToken && !$this->getToken()) {
            return null;
        }

        // Build the API URL with query parameters
        $url = $this->apiUrl . "?" . http_build_query([
            'q' => $query,
            'release' => $release,
            'useFuzzy' => $useFuzzy ? 'true' : 'false',
            'limit' => $limit,
            'flatResults' => 'true',
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->accessToken,
            'Accept: application/json',
            'Accept-Language: en',
            'API-Version: v2'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            log_message('error', "API request failed. HTTP Code: $httpCode, Response: $response");
            return null;
        }

        $data = json_decode($response, true);

        $dataRes = [];
        if($data && isset($data['destinationEntities'])) {
            foreach($data['destinationEntities'] AS $item) {
                $dataRes[] = array(
                    'code' => basename($item['id']),
                    'name' => strip_tags($item['title']),
                );
            }
            
        }
        
        return $dataRes;
    }
}