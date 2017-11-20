<?php

class class_xls {
    
    function __construct($fname = 'noname.xls' ) {
        //header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");;
        header("Content-Disposition: attachment;filename=$fname ");
        header("Content-Transfer-Encoding: binary ");
    }
    
    //function
    public function xlsHeader() {
        echo pack( "ssssss" , 0x809 , 0x8 , 0x0 , 0x10 , 0x0 , 0x0 );
        return;
    }
    
    public function xlsClose() {
        echo pack( "ss" , 0x0A , 0x00 );
        return;
    }
    
    public function xlsWriteNumber( $Row , $Col , $Value ) {
        echo pack( "sssss" , 0x203 , 14 , $Row , $Col , 0x0 );
        echo pack( "d" , $Value );
        return;
    }
    
    public function xlsWriteString( $Row , $Col , $Value ) {
        $L = strlen( $Value );
        echo pack( "ssssss" , 0x204 , 8 + $L , $Row , $Col , 0x0 , $L );
        echo $Value;
        return;
    }
} 