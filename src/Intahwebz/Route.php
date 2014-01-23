<?php

namespace Intahwebz;

interface Route {

    public function getName();

    /**
     * @return callable
     */
    public function getCallable();

    public function generateURL(\Intahwebz\Domain $domain, $parameters, $absolute = false);
    public function matchRequest(Request $request);

    public function getTemplate();

    public function getMergedParameters(Request $request, $params);

    public function getACLPrivilegeName();
    public function getACLResourceName();

    function getDefaults();
}

