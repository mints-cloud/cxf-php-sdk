<?php

namespace Cxf;

use Doctrine\Inflector\InflectorFactory;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Predis\Client as RedisClient;

class Client
{
    public $host;
    public $apiKey;
    public $scope;
    public $contactTokenId;
    public $visitId;
    public $debug;
    public $timeouts;
    public $baseURL;
    private $inflector;
    private $getHttpTimeout = 10;
    private $postHttpTimeout = 10;
    private $putHttpTimeout = 10;
    private $deleteHttpTimeout = 10;
    private $isAnImage = false; // Flag to check if the request is an image


    public function __construct($host, $apiKey, $scope = null, $contactTokenId = null, $visitId = null, $debug = false, $timeouts = [])
    {
        $this->host = $host ?? env('CXF_HOST');
        $this->apiKey = $apiKey ?? $this->getApiKey($scope);
        $this->contactTokenId = $contactTokenId;
        $this->visitId = $visitId;
        $this->debug = $debug;
        $this->timeouts = $timeouts;
        $this->setScope($scope);
        $this->inflector = InflectorFactory::create()->build();
    }

    public function raw($action, $url, $options = [], $data = null, $baseUrl = null, $compatibilityOptions = [], $onlyTracking = false, $dataTransform = true)
    {
        if ($dataTransform) $data = CxfHelper::dataTransform($data);
        $baseUrl = $baseUrl ?: $this->baseURL;
        $methodCalled = debug_backtrace()[0]['function'];

        if ($this->isSingular($methodCalled) && ($url === "//" || is_null($url))) {
            throw new \Exception("Id must be a valid integer number, given URL: {$url}");
        }

        if (is_array($options)) {
            $needEncoding = ['jfilters', 'afilters', 'rfilters'];
            $foundOptionsWithEncoding = array_filter(array_keys($options), function ($key) use ($options, $needEncoding) {
                return in_array(strtolower($key), $needEncoding) && is_array($options[$key]);
            });

            foreach ($foundOptionsWithEncoding as $key) {
                $options[$key] = urlencode(base64_encode(json_encode($options[$key])));
            }

            $uri = http_build_query($options);
        }

        $fullUrl = $this->host . $baseUrl . $url;

        // if url end with /query merge options with data
        if (substr($fullUrl, -6) === '/query') {
            $data = array_merge($data, $options);
        }

        $resultFromCache = false;
        $response = null;

        if ($action === 'get') {
            $fullUrl = $fullUrl . (isset($uri) ? "?{$uri}" : "");
            $urlNeedCache = false;

            if (isset($config) && $config['redis_cache']['use_cache']) {
                foreach ($config['redis_cache']['groups'] as $group) {
                    foreach ($group['urls'] as $groupUrl) {
                        if (preg_match("/{$groupUrl}/", $fullUrl)) {
                            $time = $group['time'];
                            $urlNeedCache = true;
                            $redisClient = new RedisClient([
                                'host' => $config['redis_cache']['redis_host'],
                                'port' => $config['redis_cache']['redis_port'] ?? 6379,
                                'db' => $config['redis_cache']['redis_db'] ?? 1,
                            ]);

                            $response = $redisClient->get($fullUrl);

                            if ($response) {
                                $resultFromCache = true;
                            } else {
                                $response = $this->httpRequest($action, $fullUrl, $this->setHeaders($compatibilityOptions), null);
                                $redisClient->setex($fullUrl, $time, $response);
                            }
                            break 2;
                        }
                    }
                }
            }

            if (!$urlNeedCache) {
                $response = $this->httpRequest($action, $fullUrl, $this->setHeaders($compatibilityOptions), null);
            }

        } elseif (in_array($action, ['create', 'post'])) {
            $response = $this->httpRequest('POST', $fullUrl, $this->setHeaders($compatibilityOptions), $data);
        } elseif (in_array($action, ['put', 'patch', 'update'])) {
            $response = $this->httpRequest('PUT', $fullUrl, $this->setHeaders($compatibilityOptions), $data);
        } elseif (in_array($action, ['delete', 'destroy'])) {
            $response = $this->httpRequest('DELETE', $fullUrl, $this->setHeaders($compatibilityOptions), $data);
        }

        if ($this->debug) {
            $responseFrom = $resultFromCache ? 'REDIS' : 'CALI';
            echo "Method: {$action} \nURL: {$url} \nOptions: " . json_encode($options) . "\nOnly tracking: {$onlyTracking} \nResponse from: {$responseFrom}\n";
            if ($data) {
                echo "Data: " . json_encode($data) . "\n";
            }
        }

        try {
            // it is a image response?
            if ($this->isAnImage) {
                $this->isAnImage = false;
                return $response;
            }
            $decodedResponse = json_decode($response, true);
            if (!$decodedResponse) throw new \Exception($response);
            return $decodedResponse;
        } catch (\Exception $e) {
            return $this->getJsonIfExist($e->getMessage());
        }
    }

    private function getJsonIfExist($message)
    {
        $isString = is_string($message);
        if (!$isString) return $message;

        $hasJson = preg_match('/\{.*\}/', $message);
        if (!$hasJson) return $message;

        // Get position of json
        $start = strpos($message, '{');
        $end = strrpos($message, '}');
        $length = $end - $start + 1;

        // Get json
        $json = substr($message, $start, $length);
        return json_decode($json, true);
    }

    // Define a private function called setScope, it should accept a single argument called $scope and returns nothing
    private function setScope($scope)
    {
        $this->scope = $scope;
        // Set baseURL to the correct value based on the scope
        switch ($scope) {
            case 'public':
                $this->baseURL = '/api/v1';
                break;
            case 'contact':
                $this->baseURL = '/api/contact/v1';
                break;
            case 'user':
                $this->baseURL = '/api/user/v1';
                break;
            default:
                $this->baseURL = '/api/v1';
        }
    }

    private function getApiKey($scope)
    {
        // return the API key based on the scope
        if ($scope === 'user') return env('CXF_USER_API_KEY');

        // Check if CXF_CONTACT_API_KEY is set, if not, use CXF_API_KEY
        $apiKey = env('CXF_CONTACT_API_KEY');
        if (!$apiKey) $apiKey = env('CXF_API_KEY');
        return $apiKey;
    }

    private function httpRequest($method, $url, $headers = null, $data = null, $timeout = 10)
    {
        // Create a new Guzzle client with a timeout of 10 seconds, $method could be the HTTP verb (GET, POST, PUT, DELETE)
        // $url is the URL to send the request to, $headers is an array of headers to send with the request
        // $data is the data to send with the request, and $timeout is the timeout for the request
        $client = new \GuzzleHttp\Client(['timeout' => $timeout]);
        $options = [
            'headers' => $headers,
            RequestOptions::JSON => $data,
        ];
        try {
            // Send the request and store the response in a variable
            $response = $client->request($method, $url, $options);
            // get Headers
            $this->isAnImage = $this->isImage($response->getHeader('Content-Type'));
            $setCookiesHeader = $response->getHeader('Set-Cookie');
            if ($setCookiesHeader) $this->setCookies($setCookiesHeader);
            // Return the response body as a string
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            // If an exception is thrown, return the exception message
            return $e->getMessage();
        }
    }

    // Check in array if content type has something with image
    public function isImage($contentType): bool {
        if (is_array($contentType)) {
            foreach ($contentType as $content) {
                if (strpos($content, 'image') !== false) return true;
            }
        }
        return false;
    }

    public function httpGet($url, $headers = null)
    {
        return $this->httpRequest('GET', $url, $headers, null, $this->getHttpTimeout);
    }

    public function httpPost($url, $headers = null, $data = null)
    {
        return $this->httpRequest('POST', $url, $headers, $data, $this->postHttpTimeout);
    }

    public function httpPut($url, $headers = null, $data = null)
    {
        return $this->httpRequest('PUT', $url, $headers, $data, $this->putHttpTimeout);
    }

    public function httpDelete($url, $headers = null, $data = null)
    {
        return $this->httpRequest('DELETE', $url, $headers, $data, $this->deleteHttpTimeout);
    }

    private function getTokens() {
        if ($this->scope === 'user') {

            return [
                'access_token' => $_COOKIE['cxf_user_access_token'] ?? '',
                'refresh_token' => $_COOKIE['cxf_user_refresh_token'] ?? ''
            ];
        } else if ($this->scope === 'contact') {
            return [
                'access_token' => $_COOKIE['cxf_contact_access_token'] ?? '',
                'refresh_token' => $_COOKIE['cxf_contact_refresh_token'] ?? ''
            ];
        }
        return [];
    }
    private function setHeaders($compatibilityOptions = [], $headers = null)
    {
        $h = [
            'Accept' => 'application/json',
            'ApiKey' => $this->apiKey
        ];

        // Copy local cookies to $h
        $tokens = $this->getTokens();
        if (isset($tokens['access_token']) && isset($tokens['refresh_token'])) {
            $h['Access-Token'] = $tokens['access_token'];
            $h['Refresh-Token'] = $tokens['refresh_token'];
        }

        if (empty($compatibilityOptions['no_content_type'])) {
            $h['Content-Type'] = 'application/json';
        }
        if ($this->contactTokenId) {
            $h['ContactToken'] = $this->contactTokenId;
        }
        if ($this->visitId) {
            $h['Visit-Id'] = $this->visitId;
        }

        if ($compatibilityOptions) {
            foreach ($compatibilityOptions as $k => $v) {
                $h[$k] = $v;
            }
        }

        if ($headers) {
            foreach ($headers as $k => $v) {
                $h[$k] = $v;
            }
        }

        return $h;
    }

    public function contactGet($url, $headers = null, $compatibilityOptions = [])
    {
        $h = $this->setHeaders($compatibilityOptions, $headers);
        return $this->httpGet($url, $h);
    }

    public function contactPost($url, $data, $compatibilityOptions = [])
    {
        $headers = $this->setHeaders($compatibilityOptions);
        return $this->httpPost($url, $headers, $data);
    }

    public function contactPut($url, $data, $compatibilityOptions = [])
    {
        $headers = $this->setHeaders($compatibilityOptions);
        return $this->httpPut($url, $headers, $data);
    }

    public function userGet($url, $headers = null, $compatibilityOptions = [])
    {
        $h = $this->setHeaders($compatibilityOptions, $headers);
        return $this->httpGet($url, $h);
    }

    public function userPost($url, $data, $compatibilityOptions = [])
    {
        $headers = $this->setHeaders($compatibilityOptions);
        return $this->httpPost($url, $headers, $data);
    }

    public function userPut($url, $data, $compatibilityOptions = [])
    {
        $headers = $this->setHeaders($compatibilityOptions);
        return $this->httpPut($url, $headers, $data);
    }

    public function userDelete($url, $data, $compatibilityOptions = [])
    {
        $headers = $this->setHeaders($compatibilityOptions);
        return $this->httpDelete($url, $headers, $data);
    }

    public function publicGet($url, $headers = null, $compatibilityOptions = [])
    {
        $h = $this->setHeaders($compatibilityOptions, $headers);
        return $this->httpGet($url, $h);
    }

    public function publicPost($url, $headers = null, $data = [], $compatibilityOptions = [])
    {
        $h = $this->setHeaders($compatibilityOptions, $headers);
        return $this->httpPost($url, $h, $data);
    }

    public function publicPut($url, $headers = null, $data = [], $compatibilityOptions = [])
    {
        $h = $this->setHeaders($compatibilityOptions, $headers);
        return $this->httpPut($url, $h, $data);
    }

    private function isSingular($str): bool
    {
        $pluralized = $this->inflector->pluralize($str);
        $singularized = $this->inflector->singularize($str);

        return $pluralized !== $str && $singularized === $str;
    }

    public function setCookies($headers)
    {
        $parsedCookies = $this->parseSetCookies($headers);

        foreach ($parsedCookies as $cookie) {
            setcookie(
                $cookie['name'],
                $cookie['value'],
                [
                    'expires' => isset($cookie['expires']) ? strtotime($cookie['expires']) : 0,
                    'path' => $cookie['path'] ?? '/',
                    'domain' => '',
                    'secure' => $cookie['secure'] ?? false,
                    'httponly' => $cookie['httponly'] ?? false,
                    'samesite' => $cookie['samesite'] ?? 'Lax',
                ]
            );
        }
    }

    function parseSetCookies(array $setCookies): array
    {
        $parsedCookies = [];

        foreach ($setCookies as $cookieString) {
            $parts = explode(';', $cookieString);
            $parts = array_map('trim', $parts);

            $cookie = [];

            [$name, $value] = explode('=', array_shift($parts), 2);
            $cookie['name'] = $name;
            $cookie['value'] = $value;

            foreach ($parts as $part) {
                if (strpos($part, '=') !== false) {
                    [$attrName, $attrValue] = explode('=', $part, 2);
                    $cookie[strtolower($attrName)] = $attrValue;
                } else {
                    $cookie[strtolower($part)] = true;
                }
            }

            $parsedCookies[$name] = $cookie;
        }

        return $parsedCookies;
    }

}
