<?php

namespace Cxf;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait ProxyTrait
{
    protected $host;
    protected $apiKey;

    public function __construct()
    {
        $this->host = $_ENV['CXF_HOST'] ?? null;
        $this->apiKey = $_ENV['CXF_API_KEY'] ?? null;
    }

    /**
     * @throws GuzzleException
     */
    public function proxyRequest(Request $request)
    {
        $url = $this->host . $request->getPathInfo() . '?' . $request->getQueryString();
        $HTTPClient = new \GuzzleHttp\Client();
        $headers = [
            'ApiKey' => $this->apiKey,
            'content-type' => 'application/json',
            'accept' => 'application/json',
        ];

        //users headers
        if (isset($_COOKIE['cxf_user_access_token']) && Str::contains($request->url(), '/api/user/v1')) {
            $headers['Access-Token'] = $_COOKIE['cxf_user_access_token'];
        }
        if (isset($_COOKIE['cxf_user_refresh_token']) && Str::contains($request->url(), '/api/user/v1')) {
            $headers['Refresh-Token'] = $_COOKIE['cxf_user_refresh_token'];
        }

        // contacts headers
        if (isset($_COOKIE['cxf_contact_access_token']) && Str::contains($request->url(), '/api/v1/contacts')) {
            $headers['Access-Token'] = $_COOKIE['cxf_contact_access_token'];
        }
        if (isset($_COOKIE['cxf_contact_refresh_token']) && Str::contains($request->url(), '/api/v1/contacts')) {
            $headers['Refresh-Token'] = $_COOKIE['cxf_contact_refresh_token'];
        }

        $data = $request->input();
        if (empty($data)) $data = null;
        if ($request->method() == 'GET') $data = null;

        $options = [
            'headers' => $headers,
            'json' => $data
        ];

        $response = $HTTPClient->request($request->method(), $url, $options);

        if (Str::contains($request->url(), '/public-assets')) {
            $content = $response->getBody()->getContents();
            $headers = $response->getHeaders();
            $laravelResponse = response($content, $response->getStatusCode());
            foreach ($headers as $name => $values) {
                foreach ($values as $value) {
                    $laravelResponse->header($name, $value);
                }
            }
            return $laravelResponse;
        } else {
            $contents = $response->getBody()->getContents();
            return response($contents, $response->getStatusCode());
        }
    }
}