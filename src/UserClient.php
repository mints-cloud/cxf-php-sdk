<?php

namespace Cxf;

use Cxf\User\Config\Config;
use Cxf\User\Content\Content;
use Cxf\User\CustomerData\CustomerData;
use Cxf\User\Ecommerce\Ecommerce;
use Cxf\User\Helpers\Helpers;
use Cxf\User\Marketing\Marketing;
use Cxf\User\Profile\Profile;

class UserClient
{
    use Profile,
        Marketing,
        Config,
        Content,
        CustomerData,
        Ecommerce,
        Helpers;
    public Client $client;

    /**
     * @param $host
     * @param $apiKey
     * @param $sessionToken
     * @param $debug
     * @param $timeouts
     */
    public function __construct($host = null, $apiKey = null, $sessionToken = null, $refreshToken = null, $debug = false, $timeouts = [])
    {
        $this->client = new Client(
            $host ?? $_ENV['CXF_HOST'] ?? null,
            $apiKey ?? $_ENV['CXF_API_KEY'] ?? null,
            'user',
            $sessionToken,
            $refreshToken,
            null,
            null,
            $debug,
            $timeouts
        );
    }

    /**
     * @param $email
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function login($email, $password)
    {
        $response = $this->client->raw('post', '/users/login', null, [ 'data' => [
            'email' => $email,
            'password' => $password
        ]], '/api/v1', ['no_content_type' => true], false, false);

        if (!is_array($response)) return $response;

        if (isset($response['data']['access-token']) && isset($response['data']['refresh-token'])) {
            $this->client->setSessionToken($response['data']['access-token']);
            $this->client->setRefreshToken($response['data']['refresh-token']);
        }

        return $response;
    }

    /**
     * @param string $token
     * @return mixed
     * @throws \Exception
     */
    public function magicLinkLogin(string $token)
    {
        return $this->client->raw('get', "/users/magic-link-login/${token}", null, null, '/api/v1');
    }

    /**
     * @param string $email
     * @param string $redirectUrl
     * @param int $lifeTime
     * @return mixed
     * @throws \Exception
     */
    public function sendMagicLink(string $email, string $redirectUrl = '', int $lifeTime = 24)
    {
        return $this->client->raw('post', '/users/send-magic-link', null, ['data' => [
            'email' => $email,
            'redirectUrl' => $redirectUrl,
            'lifeTime' => $lifeTime
        ]], '/api/v1');
    }

    private function dataTransform($data)
    {
        return CxfHelper::dataTransform($data);
    }
}
