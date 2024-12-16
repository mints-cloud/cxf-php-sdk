<?php

namespace Cxf;

use Cxf\Public\Content\PublicContent;

class PublicClient
{
    use PublicContent;

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
            'public',
            $sessionToken,
            $refreshToken,
            null,
            null,
            $debug,
            $timeouts
        );
    }

    /**
     * Register Visit.
     * Register a ghost/contact visit in Cxf.Cloud.
     *
     * @param array $request request.
     * @param string|null $ip It's the visitor IP.
     * @param string|null $user_agent The visitor's browser user agent.
     * @param string|null $url URL visited.
     * @return mixed
     * @throws \Exception
     */
    public function registerVisit($request, $ip = null, $user_agent = null, $url = null)
    {
        $data = [
            'ip_address' => $ip ?: $request['remote_ip'],
            'user_agent' => $user_agent ?: $request['user_agent'],
            'url' => $url ?: $request['fullpath']
        ];

        return $this->client->raw('post', '/register-visit', null, json_encode($data));
    }

    /**
     * Register Visit timer.
     * Register a page visit time.
     *
     * @param string $visit It's the visitor IP.
     * @param int $time The visitor's browser user agent.
     * @return mixed
     * @throws \Exception
     */
    public function registerVisitTimer($visit, $time)
    {
        return $this->client->raw('get', "/register-visit-timer?visit={$visit}&time={$time}");
    }

    /**
     * Send User Magic Link.
     * Send a magic link to the user via email or phone.
     *
     * @param string $email_or_phone
     * @param string $template_slug
     * @param string $redirect_url
     * @param int $life_time
     * @param int|null $max_visits
     * @param string $driver
     * @return mixed
     * @throws \Exception
     */
    public function sendUserMagicLink($email_or_phone, $template_slug, $redirect_url = '', $life_time = 1440, $max_visits = null, $driver = 'email')
    {
        $data = [
            'driver' => $driver,
            'lifeTime' => $life_time,
            'maxVisits' => $max_visits,
            'redirectUrl' => $redirect_url,
            'templateId' => $template_slug
        ];

        $key = in_array($driver, ['sms', 'whatsapp']) ? 'phone' : 'email';
        $data[$key] = $email_or_phone;

        return $this->client->raw('post', '/users/magic-link', null, json_encode(['data' => $data]), '/api/v1');
    }

    private function dataTransform($data)
    {
        return CxfHelper::dataTransform($data);
    }
}