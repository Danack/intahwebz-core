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
        $scheme = $domainInfo->currentScheme;

        return $scheme.'://'.$domainName;
    }


    /**
     * @return \Intahwebz\DomainInfo
     */
    public function getDomainInfo() {
        $currentDomain = 'intahwebrouting.test';

        if(isset($_SERVER['HTTP_HOST']) == TRUE){
            $currentDomain = $_SERVER['HTTP_HOST'];
        }

        $canonicalDomain = $currentDomain;

        if(mb_stripos($currentDomain, 'www.') !== 0){
            $canonicalDomain = 'www.'.$canonicalDomain;
        }

        $currentURL = false;

        $domainInfo = new \Intahwebz\DomainInfo(
            $currentDomain,
            'intahwebrouting.test',
            $canonicalDomain,
            $this->request->getScheme(),
            true,
            $currentURL
        );

        return $domainInfo;
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
 