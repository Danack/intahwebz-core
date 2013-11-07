<?php

namespace Intahwebz;

interface Response {

    function setHeader();

    function setErrorStatus($params, $errorCode, $errorText);

    function setResponse($data);

    function send();
    function isOK();
    function getStatus();
    function getErrorText();

    function unsetCookie($cookieName);
    function setCookieVariable($cookieName, $value, $secureOnly = false);
}

