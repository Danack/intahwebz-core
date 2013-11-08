<?php

namespace Intahwebz;



class DomainExample implements \Intahwebz\Domain {

    private $request;

    function __construct(Request $request) {
        $this->request = $request;
    }

    function getContentDomain($contentID) {

        $domainInfo = $this->getDomainInfo();

        $domainName = $domainInfo->canonicalDomain;

        if(CDN_ENABLED == TRUE){
            $cdnID = ($contentID % CDN_CNAMES) + 1;
            $domainName = "cdn".$cdnID.".".$domainName;
        }

        $scheme = $domainInfo->currentScheme;

        return $scheme.'://'.$domainName;
    }


    /**
     * @return \Intahwebz\DomainInfo
     */
    public function getDomainInfo() {
        $currentDomain = ROOT_DOMAIN;

        if(isset($_SERVER['HTTP_HOST']) == TRUE){
            $currentDomain = $_SERVER['HTTP_HOST'];
        }

        $canonicalDomain = $currentDomain;

        if(mb_stripos($currentDomain, 'www.') !== 0){
            $canonicalDomain = 'www.'.$canonicalDomain;
        }

        $currentURL = false;

        if(isset($_SERVER['REQUEST_URI']) == TRUE){
            $domainInfo['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
        }

        $domainInfo = new \Intahwebz\DomainInfo(
            $currentDomain,
            ROOT_DOMAIN,
            $canonicalDomain,   //$canonicalDomain,
            $this->request->getScheme(),
            true,               //$httpsEnabled,
            $currentURL
        );

        return	$domainInfo;
    }

    function getURLForCurrentDomain($path, $secure = FALSE) {
        $domainInfo = $this->getDomainInfo();

        $scheme = $domainInfo->currentScheme;

        if ($secure) {
            $scheme = 'https';
        }

        $fullURL = $scheme.'://'.$domainInfo->currentDomain.$path;

        return $fullURL;
    }

}
 