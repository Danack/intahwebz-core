<?php

namespace Intahwebz;

interface Route{

    public function getName();

    /**
     * @return RouteMapping
     */
    public function getMapping();

    public function generateURL($parameters, $absolute = false);
    public function mapParametersToFunctionArguments(Request $request);
    public function matchRequestAndStoreParams(Request $request);

    public function getTemplate();
    
    public function getRouteParam($name);
    public function getRouteParams();

    public function getACLPrivilegeName();
    public function getACLResourceName();
}

