<?php
// define the ADMIN_EMAIL, MAIN_CSS and IMG_PATH
switch(LOCATION_ID) {
    case 1:
        $PHONE_NOS =  array('1300 733 430', '+61 2 8090 3458');
        define(MAIN_CSS, 'style-AU.css');
        define(IMG_PATH, 'images');
        define(ADMIN_NAME, 'Remote Staff Admin AU');
        define(ADMIN_EMAIL, 'admin@remotestaff.com.au');
        break;
    case 2:
        $PHONE_NOS =  array('+44 208 816 7802');
        define(MAIN_CSS, 'style-UK.css');
        define(IMG_PATH, 'images/uk');
        define(ADMIN_NAME, 'Remote Staff Admin UK');
        define(ADMIN_EMAIL, 'admin@remotestaff.co.uk');
        break;
    case 3:
        $PHONE_NOS =  array('+1 415 992 6356');
        define(MAIN_CSS, 'style-US.css');
        define(IMG_PATH, 'images/us');
        define(ADMIN_NAME, 'Remote Staff Admin US');
        define(ADMIN_EMAIL, 'admin@remotestaff.biz');
        break;
    case 4:
        $PHONE_NOS =  array('1300 733 430', '+61 2 8090 3458');
        define(MAIN_CSS, 'style-AU.css');
        define(IMG_PATH, 'images');
        define(ADMIN_NAME, 'Remote Staff Admin PH');
        define(ADMIN_EMAIL, 'admin@remotestaff.com.ph');
        break;
}
	