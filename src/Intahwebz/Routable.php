<?php

namespace Intahwebz;


interface Routable {
    function getRouteName();
    function getRouteParams();
}

