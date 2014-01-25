<?php

namespace Intahwebz;

interface Route {

    public function getName();

    public function generateURL(\Intahwebz\Domain $domain, $parameters, $absolute = false);
    public function matchRequest(Request $request);

    /**
     * Gets on of the 'extra' values associated with this route.
     * @param $key
     * @return mixed
     */
    function get($key);

    function getDefaults();
}

