<?php

namespace Cxf;

class CxfHelper
{
    /**
     * @param $client
     * @param string $url
     * @param array|null $options
     * @param bool $usePost
     * @return mixed
     */
    public static function getQueryResults($client, string $url, array $options = [], bool $usePost = true)
    {
        if ($usePost) {
            return $client->raw('post', $url . '/query', $options);
        } else {
            return $client->raw('get', $url, $options);
        }
    }

    public static function dataTransform($data)
    {
        $data = self::correctJson($data);

        if (!isset($data['data'])) {
            $data = ['data' => $data];
        }

        return $data;
    }

    public static function correctJson($data)
    {
        if ($data === null) return $data;
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        return $data;
    }
}