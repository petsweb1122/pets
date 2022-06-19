<?php

namespace App\Helpers;
use Detection\MobileDetect as MobileDetect;

class Common {

    public static function isMobileDevice() {

        $mobile_detect = new MobileDetect();

        return $mobile_detect->isMobile() == true && $mobile_detect->isTablet() == false;

    }

}
