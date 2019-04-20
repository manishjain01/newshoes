<?php

namespace Mbarwick83\Instagram;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Instagram
{
    const API_HOST = 'https://api.instagram.com/';
    const TIMEOUT = 8.0;

    protected $client;
    protected $client_key;
    protected $client_secret;
    protected $redirect_uri;
    protected $scopes;

    public function __construct()
    {
        $this->client_key = config('instagram.client_id');
        $this->client_secret = config('instagram.client_secret');
        $this->redirect_uri = config('instagram.redirect_uri');
        $this->scopes = config('instagram.scopes');

    	$this->client = new Client([
    	    'base_uri' => self::API_HOST,
    	    'timeout'  => self::TIMEOUT,
    	]);	
    }

    /**
    * Get authorization url for oauth
    * 
    * @return String
    */
    public function getLoginUrl()
    {
        //echo $this->scopes;exit;
	   return $this->url('oauth/authorize', ['scope' => $this->scopes]);
    }

    /**
    * Get user's access token and basic info
    * 
    * @param string $code
    */
    public function getAccessToken($code)
    {
	   return $this->post('oauth/access_token', ['code' => $code], true);
    }

    /**
    * Make URLs for user browser navigation.
    *
    * @param string $path
    * @param array  $parameters
    *
    * @return string
    */
    protected function url($path, array $parameters = null)
    {
    	$query = [
            'client_id' => $this->client_key,
    	    'redirect_uri' => $this->redirect_uri,
    	    'response_type' => 'code'
    	];

        if ($parameters)
            $query = array_merge($query, $parameters);
        //pr($query);echo "a";

        $query = http_build_query($query);
        //pr($query);exit;

        return sprintf('%s%s?%s', self::API_HOST, $path, $query);
    }

    /**
    * Make POST calls to the API
    * 
    * @param  string  $path          
    * @param  boolean $authorization [Use access token query params]
    * @param  array   $parameters    [Optional query parameters]
    * @return Array
    */
    public function post($path, array $parameters, $authorization = false)
    {
    	$query = [];

    	if ($authorization)
    	    $query = [
    	        'client_id' => $this->client_key,
    	    	'client_secret' => $this->client_secret,
    	    	'redirect_uri' => $this->redirect_uri,			 
    	    	'grant_type' => 'authorization_code',
    	    ];

    	if ($parameters)
            $query = array_merge($query, $parameters);

        try {
    	    $response = $this->client->request('POST', $path, [
    	        'form_params' => $query,
		    'timeout' => self::TIMEOUT
    	    ]);

            return $this->toArray($response);
    	} 
    	catch (ClientException $e) {
    	    return $this->toArray($e->getResponse());
        }    	
    }

    /**
    * Make GET calls to the API
    * 
    * @param  string $path
    * @param  array  $parameters [Query parameters]
    * @return Array
    */
    public function get($path, array $parameters)
    {
        try {
    	    $response = $this->client->request('GET', $path, [
    	        'query' => $parameters
    	    ]);

            return $this->toArray($response);
    	}
    	catch (ClientException $e) {
    	    return $this->toArray($e->getResponse());
    	}
    }

    /**
    * Make DELETE calls to the API
    * 
    * @param  string  $path
    * @param  array   $parameters    [Optional query parameters]
    * @return Array
    */
    public function delete($path, array $parameters)
    {
        try {
            $response = $this->client->request('DELETE', $path, [
                'query' => $parameters
            ]);

            return $this->toArray($response);
        }
        catch (ClientException $e) {
            return $this->toArray($e->getResponse());
        } 
    }

    /**
    * Convert API response to array
    * 
    * @param  Object $response
    * @return Array
    */
    protected function toArray($response)
    {
    	return json_decode($response->getBody()->getContents(), true);
    }
}




