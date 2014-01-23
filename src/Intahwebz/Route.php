<?php

namespace Intahwebz;

interface Route {

    public function getName();

    /**
     * @return callable
     */
    public function getCallable();

    public function generateURL(\Intahwebz\Domain $domain, $parameters, $absolute = false);
    public function mapParametersToFunctionArguments(Request $request);
    public function matchRequestAndStoreParams(Request $request);

    public function getTemplate();

    public function getMergedParameters(Request $request, $params);

//    public function getRouteParam($name);
//    public function getRouteParams();

    public function getACLPrivilegeName();
    public function getACLResourceName();
}

