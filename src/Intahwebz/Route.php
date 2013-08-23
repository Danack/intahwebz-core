<?php

namespace Intahwebz;

interface Route{

    public function generateURL($parameters, $absolute = false);
    public function mapParametersToFunctionArguments(Request $request);
    public function matchRequestAndStoreParams(Request $request);
}

