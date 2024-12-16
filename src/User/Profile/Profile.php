<?php

namespace Cxf\User\Profile;
trait Profile {
    ##
    # === Me.
    # Get contact logged info.
    #
    # ==== Example
    #     @data = @cxf_user.me
    public function me($options = null) {
        return $this->client->raw('get', '/profile/me', $options);
    }
}
