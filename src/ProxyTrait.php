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

        // Check if cxf_user_session_token cookie exists, if so, set authorization bearer token
        if (isset($_COOKIE['cxf_user_session_token']) && Str::contains($request->url(), '/api/user/v1')) {
            $headers['Authorization'] = 'Bearer ' . $_COOKIE['cxf_user_session_token'];
        }

        // Check if cxf_contact_session_token cookie exists, if so, set authorization bearer token
        if (isset($_COOKIE['cxf_contact_session_token']) && Str::contains($request->url(), '/api/contact/v1')) {
            $headers['Authorization'] = 'Bearer ' . $_COOKIE['cxf_contact_session_token'];
        }

        // Check if cxf_contact_id cookie exists, if so, set as ContactToken header
        if (isset($_COOKIE['cxf_contact_id'])) {
            $headers['ContactToken'] = $_COOKIE['cxf_contact_id'];
        }

        $data = $request->input();
        if (empty($data)) $data = null;

        $options = [
            'headers' => $headers,
            'json' => $data
        ];

        $response = $HTTPClient->request($request->method(), $url, $options);
        return response()->json($response->getBody()->getContents(), $response->getStatusCode());
    }
}