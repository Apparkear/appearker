<?php
	function all_language($ln){
		if($ln=='esp'){
            include('lang/esp.json');    
        }
        if($ln=='ita'){
            include('lang/ita.json');    
        }
        if($ln=='fre'){
            include('lang/fre.json');    
        }
        if($ln=='por'){
            include('lang/por.json');    
        }
        if($ln=='dch'){
            include('lang/sp.json');    
        }
        if($ln=='rus'){
            include('lang/rus.json');    
        }
        if($ln=='chi'){
            include('lang/chi.json');    
        }
        if($ln=='en'){
            include('lang/en.json');
        }

        $lnreturn = file_get_contents($ln);
 ?>