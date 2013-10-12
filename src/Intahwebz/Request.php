<?php


namespace Intahwebz;


interface Request {

    function getHostName();
    //function getRefererParams();
    function setRouteParameters($routeParameters);
    function getScheme();
    function getRequestParams();
    function getPath();
    function getPort();
    function getMethod();


    /**
     * @param $formFileName
     * @return \Intahwebz\UploadedFile
     * @throws \Intahwebz\FileUploadException
     * @throws \Exception
     */
    function getUploadedFile($formFileName);

    function getReferrer();

        /**
     * @param $variableName
     * @param mixed $default
     * @param mixed $minimum
     * @param mixed $maximum
     * @return mixed
     */
    function getVariable($variableName, $default = false, $minimum = false, $maximum = false);
} 