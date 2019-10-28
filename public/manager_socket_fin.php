<?php
session_start();
    $receptor = "500";
    $host = "192.168.130.10"; 		
    $puerto = "5038";
    //$usuario = "nextcore";	   			
    $usuario = "admin";			   
     
    //$string = 'N3xtCor32018Comm';
    $string = 'publynextsa';
    $contrasena = (string)$string;
	//$_SESSION["Extension"] = "500";
    //$_SESSION["Prefijo"] = "49";
	
    $Extension = "501";
    //$prefijo = "49";
    $contexto = "from-internal";	  
    $canal = "SIP/".$Extension;	        
    $espera = "30";					
    $prioridad = "1";				
					
    if (!$receptor == null){
        $errno = 0 ;
        $errstr = 0 ;
        $caller_id = "Llamada a $receptor, desde $canal";
        $socket = fsockopen($host, $puerto, $errno, $errstr, 20);	
    
        if (!$socket) {												
          //  echo "$errstr ($errno)";
        }
        else {														
            fputs($socket, "Action: Logoff\r\n");
            fputs($socket, "Events: off\r\n");
            fputs($socket, "Username: $usuario\r\n");
            fputs($socket, "Secret: $contrasena\r\n\r\n");
    
            $wrets=fgets($socket,128);

            echo $wrets;
     
            fputs($socket, "Action: Originate\r\n" );
            fputs($socket, "Channel: Local/501@from-internal\r\n" );
            fputs($socket, "Exten: 500\r\n" );
            fputs($socket, "Context: from-internal\r\n" );
            fputs($socket, "Priority: 1\r\n" );
            fputs($socket, "Async: yes\r\n" );
            fputs($socket, "WaitTime: 15\r\n" );
            fputs($socket, "Callerid: 500\r\n\r\n" );

            $wrets=fgets($socket,128);
            echo $wrets;
        }
        echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
 
      
    }else{
        exit() ;
    }					
?>