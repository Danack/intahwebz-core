<?php

namespace Intahwebz;

class DomainInfo {

    //TODO - add rootCanonicalDomain

    public $currentDomain;
    public $canonicalDomain;
    public $rootCanonicalDomain;
    public $currentScheme;
    public $httpsEnabled;
    public $currentURL;

    public function __construct($currentDomain, $rootCanonicalDomain, $canonicalDomain, $currentScheme, $httpsEnabled, $currentURL) {
        $this->currentDomain = $currentDomain;
        $this->rootCanonicalDomain = $rootCanonicalDomain;
        $this->canonicalDomain = $canonicalDomain;
        $this->currentScheme = $currentScheme;
        $this->httpsEnabled = $httpsEnabled;
        $this->currentURL = $currentURL;
    }
}
 