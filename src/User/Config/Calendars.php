<?php

namespace Cxf\User\Config;

trait Calendars
{
    /**
     * Get calendars.
     * Get a collection of calendars.
     *
     * Parameters:
     * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
     *
     * First Example:
     * $data = $this->getCalendars();
     *
     * Second Example:
     * $options = [
     *     'fields' => 'title'
     * ];
     * $data = $this->getCalendars($options);
     */
    public function getCalendars($options = null)
    {
        return $this->client->raw('get', '/config/calendars', $options);
    }

    /**
     * Get calendar.
     * Get a calendar info.
     *
     * Parameters:
     * $id (int) -- Calendar id.
     * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
     *
     * First Example:
     * $data = $this->getCalendar(1);
     *
     * Second Example:
     * $options = [
     *     'fields' => 'title'
     * ];
     * $data = $this->getCalendar(1, $options);
     */
    public function getCalendar($id, $options = null)
    {
        return $this->client->raw('get', "/config/calendars/{$id}", $options);
    }

    /**
     * Create calendar.
     * Create a calendar with data.
     *
     * Parameters:
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = [
     *     'title' => 'New Calendar',
     *     'object_type' => 'contacts',
     *     'object_id' => 1
     * ];
     * $data = $this->createCalendar($data);
     */
    public function createCalendar($data)
    {
        return $this->client->raw('post', '/config/calendars', null, $this->dataTransform($data));
    }

    /**
     * Update calendar.
     * Update a calendar info.
     *
     * Parameters:
     * $id (int) -- Calendar id.
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = [
     *     'title' => 'New Calendar Modified',
     *     'object_type' => 'contacts',
     *     'object_id' => 1
     * ];
     * $data = $this->updateCalendar(4, $data);
     */
    public function updateCalendar($id, $data)
    {
        return $this->client->raw('put', "/config/calendars/{$id}", null, $this->dataTransform($data));
    }

    /**
     * Delete calendar.
     * Delete a calendar.
     *
     * Parameters:
     * $id (int) -- Calendar id.
     *
     * Example:
     * $data = $this->deleteCalendar(4);
     */
    public function deleteCalendar($id)
    {
        return $this->client->raw('delete', "/config/calendars/{$id}");
    }
}