<?php

class ProForma{


  public function render(){
    global $nodejs_api;
    $smarty = new Smarty();


    // $smarty->assign("BASE_API_URL", $this->getAPIURL());
    if (TEST){
      $smarty->assign("WS_URL", "ws://test.api.remotestaff.com.au");
      $smarty->assign("BASE_API_URL", "http://test.api.remotestaff.com.au");
      $smarty->assign("BASE_URL", "http://devs.remotestaff.com.au");
    }else if (STAGING){
      $smarty->assign("WS_URL", "ws://staging.api.remotestaff.com.au");
      $smarty->assign("BASE_API_URL", "http://staging.api.remotestaff.com.au");
      $smarty->assign("BASE_URL", "http://staging.remotestaff.com.au");
    }else{
      $smarty->assign("WS_URL", "wss://api.remotestaff.com.au");
      $smarty->assign("BASE_API_URL", "https://api.remotestaff.com.au");
      $smarty->assign("BASE_URL", "https://remotestaff.com.au");
    }
    $smarty->assign("NJS_API_URL", $nodejs_api);
    $smarty->display("proforma.tpl");

  }
}

 ?>
