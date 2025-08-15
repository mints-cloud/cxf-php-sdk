<?php

namespace Cxf;

use Cxf\Contact\Config\ContactConfig;
use Cxf\Contact\Content\ContactContent;
use Cxf\Contact\Ecommerce\ContactEcommerce;

class ContactClient
{
    use ContactConfig, ContactContent, ContactEcommerce;
    public Client $client;
    public string $contactV1Url = '/api/contact/v1';

    /**
     * @param $host
     * @param $apiKey
     * @param $sessionToken
     * @param $debug
     * @param $timeouts
     */
    public function __construct($host = null, $apiKey = null, $debug = false, $timeouts = [])
    {
        $this->client = new Client(
            $host ?? $_ENV['CXF_HOST'] ?? null,
            $apiKey ?? $_ENV['CXF_PUBLIC_API_KEY'] ?? null,
            'contact',
            null,
            null,
            $debug,
            $timeouts
        );
    }

    public function register($data)
    {
        return $this->client->raw('post', '/register', null, $this->dataTransform($data), '/api/v1');
    }

    public function login($email, $password)
    {
        $data = [
            'email' => $email,
            'password' => $password
        ];

        return $this->client->raw('post', '/login', null, $this->dataTransform($data), '/api/v1', [], false, false);
    }

    public function recoverPassword($data)
    {
        return $this->client->raw('post', '/recover-password', null, $this->dataTransform($data), '/api/v1');
    }

    public function resetPassword($data)
    {
        return $this->client->raw('post', '/reset-password', null, $this->dataTransform($data), '/api/v1');
    }

    public function oauthLogin($data)
    {
        return $this->client->raw('post', '/oauth-login', null, $data, '/api/v1');
    }

    public function magicLinkLogin($token)
    {
        $response = $this->client->raw('get', "/contact/login/{$token}", null, null, '/api/v1/magic-link');
        if (array_key_exists('session_token', $response)) {
            $this->client->setSessionToken($response['session_token']);
        }
        return $response;
    }

    public function sendMagicLink($emailOrPhone, $templateSlug, $redirectUrl = '', $lifeTime = 1440, $maxVisits = null, $driver = 'email')
    {
        $data = [
            'driver' => $driver,
            'lifeTime' => $lifeTime,
            'maxVisits' => $maxVisits,
            'redirectUrl' => $redirectUrl,
            'templateId' => $templateSlug
        ];
        if (in_array($driver, ['sms', 'whatsapp'])) {
            $data['phone'] = $emailOrPhone;
        } else {
            $data['email'] = $emailOrPhone;
        }
        return $this->client->raw('post', '/contact/request', null, $this->dataTransform($data), '/api/v1/magic-link');
    }

    public function getMe($options = null)
    {
        return $this->client->raw('get', '/me', $options, null, '/api/v1');
    }

    public function getMyProducts($options = null)
    {
        return $this->client->raw('get', '/my-products', $options, null, '/api/v1');
    }

    public function status()
    {
        return $this->client->raw('get', '/status', null, null, $this->contactV1Url);
    }

    public function update($data)
    {
        return $this->client->raw('put', '/update', null, $this->dataTransform($data), $this->contactV1Url);
    }

    public function logout()
    {
        if ($this->client->sessionToken) {
            $response = $this->client->raw('post', '/logout', null, null, $this->contactV1Url);
            if ($response['success']) {
                $this->client->setSessionToken(null);
            }
            return $response;
        }
    }

    public function changePassword($data)
    {
        return $this->client->raw('post', '/change-password', null, $this->dataTransform($data), $this->contactV1Url);
    }

    /**
     * Get Asset Info (Auth is not necessary).
     * Get a description of an Asset.
     *
     * @param string $slug It's the string identifier of the asset.
     * @return mixed
     * @throws \Exception
     */
    public function getPublicAsset($slug)
    {
        return $this->client->raw('get', "public-assets/{$slug}", null, null, '/');
    }

    private function dataTransform($data)
    {
        return CxfHelper::dataTransform($data);
    }
}