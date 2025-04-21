<?php

namespace Cxf\User\Ownership;

trait Ownerships {
  public function addOwnerships($data, $options = []) {
    return $this->client->raw('post', '/ownerships/add', $options, $this->dataTransform($data));
  }

  public function getOwnerships($data, $options = []) {
    return $this->client->raw('post', '/ownerships/get', $options, $this->dataTransform($data));
  }

  public function removeOwnerships($data, $options = []) {
    return $this->client->raw('post', '/ownerships/remove', $options, $this->dataTransform($data));
  }
}
