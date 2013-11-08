<?php

namespace Intahwebz;



class DomainExample implements \Intahwebz\Domain {

    private $request;

    private $domainName;

    function __construct(Request $request, $domainName) {
        $this->request = $request;
        $this->domainName = $domainName;

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

        $currentURL = false;

        $domainInfo = new \Intahwebz\DomainInfo(
            $this->domainName,
            $this->domainName,
            'www'.$this->domainName,
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
 