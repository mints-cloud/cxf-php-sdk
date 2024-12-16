<?php

namespace Cxf\User\Config;

use Cxf\CxfHelper;

trait SystemSettings
{
    public function getSettingsByKeys($options)
    {
        return $this->client->raw('get', '/config/system-settings/by-keys', $options);
    }

    public function getSettings()
    {
        return $this->client->raw('get', '/config/system-settings');
    }

    public function createSetting($data)
    {
        return $this->client->raw('post', '/config/system-settings', null, CxfHelper::dataTransform($data));
    }

    public function clearSettingsCache()
    {
        return $this->client->raw('post', '/config/system-settings/clear-cache');
    }
}