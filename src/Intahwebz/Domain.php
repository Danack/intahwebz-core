<?php

namespace Intahwebz;

interface Domain {

    function getContentDomain($contentID);

    /**
     * @return \Intahwebz\DomainInfo
     */
    function getDomainInfo();

    function getURLForCurrentDomain($path, $secure = FALSE);
}




 