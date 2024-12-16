<?php

namespace Cxf\User\Helpers;
trait Helpers {
    ##
    # == Helpers
    #

    # === Slugify.
    # Slugify a text using an object type.
    #
    # ==== Parameters
    # data:: (Hash) -- Data to be submitted.
    #
    # ==== Example
    #
    public function slugify($data) {
        // TODO: Research use of variable polymorphicObjectType
        return $this->client->raw('post', '/helpers/slugify', null, $this->data_transform($data));
    }
}
