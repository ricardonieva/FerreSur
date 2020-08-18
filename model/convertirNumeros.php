<?php
//$num_q=$_GET["num_q"];
//echo numeral($num_q);


function numeral($nnn) {
    if ($nnn<=0) return "";  
    $fult=0;
    $e=right(strval(intval($nnn)),9);
    $e=str_replace(" ","0",$e);
    $a="";
    $bg=" ";
    $mm=dig(substr($e,0,3),$fult);

    if ($mm=="") $bg=" ";
    else {
        if ($mm=="un" or $mm=="uno"){
            $a=$a."un millón ";

        }
        else {        
            $a=$a.$mm." millones ";
        }
    }

    $mm=dig(substr($e,3,3),$fult);

    //echo substr($e,3,3)."<br>";

    if ($mm <>"") {
        $a=$a.$mm.$bg."mil "; 
    }
    $fult=1;
    $mm=dig(substr($e,6,3),$fult);

    $a=$a.$mm;

    //$g=money_format($nnn,'9999999999.99')

    $g=number_format($nnn,2,".","");
    $gc=str_replace(".","",strstr($g,"."));
    $gg=intval($gc);

    if ($gg<>0) {
        $a=$a." con ".$gc."/100";
    }
    return $a;
}

 

function dig ($ooo,$fult)

{

 

 

$UNI[0]="";

$UNI[1]="";

$UNI[2]="uno";

$UNI[3]="dos";

$UNI[4]="tres";

$UNI[5]="cuatro";

$UNI[6]="cinco";

$UNI[7]="seis";

$UNI[8]="siete";

$UNI[9]="ocho";

$UNI[10]="nueve";

$UNI[11]="diez";

$UNI[12]="once";

$UNI[13]="doce";

$UNI[14]="trece";

$UNI[15]="catorce";

$UNI[16]="quince";

$UNI[17]="dieciseis";

$UNI[18]="diecisiete";

$UNI[19]="dieciocho";

$UNI[20]="diecinueve";

$UNI[21]="veinte";

$UNI[22]="veintiuno";

$UNI[23]="veintidos";

$UNI[24]="veintitres";

$UNI[25]="veinticuatro";

$UNI[26]="veinticinco";

$UNI[27]="veintiseis";

$UNI[28]="veintisiete";

$UNI[29]="veintiocho";

$UNI[30]="veintinueve";

$CEN[1]="";

$CEN[2]="";

$CEN[3]="";

$CEN[4]="treinta";

$CEN[5]="cuarenta";

$CEN[6]="cincuenta";

$CEN[7]="sesenta";

$CEN[8]="setenta";

$CEN[9]="ochenta";

$CEN[10]="noventa";

$MIL[1]="";

$MIL[2]="ciento";

$MIL[3]="doscientos";

$MIL[4]="trescientos";

$MIL[5]="cuatrocientos";

$MIL[6]="quinientos";

$MIL[7]="seiscientos";

$MIL[8]="setecientos";

$MIL[9]="ochocientos";

$MIL[10]="novecientos";

 

               

 

                if ($fult==0) $UNI[2]="un";

                else $UNI[2]="uno";

               

                if ($fult==0) $UNI[22]="veintiun";

                else $UNI[22]="veintiuno";

                              

                $a1=intval(substr($ooo,0,1));

                $a9=$MIL[$a1+1];

 

                if ($ooo=="100") return "cien";

                else {

                               if (right($ooo,2)=="00") return $a9;

                else {

                               $a1=intval(right($ooo,2));

                               if ($a9=="") $bb="";

                               else $bb=" ";

 

                               if ($a1 <= 29) return $a9.$bb.$UNI[$a1+1];

                               else{

                                               if (right($ooo,1)=="0") return $a9.$bb.$CEN[1+intval(substr($ooo,1,1))];

                                               else return $a9.$bb.$CEN[1+intval(substr($ooo,1,1))]." y ".$UNI[1+intval(right($ooo,1))];

                               }

                }

}

               

                return "";

}

 

 

function right($cad,$ncar)

{

                if ($ncar>strlen($cad)) return str_pad($cad,$ncar," ",STR_PAD_LEFT);

                else return substr($cad,strlen($cad)-$ncar,$ncar);

               

                }

 

function left($cad,$ncar)

{

                if ($ncar>strlen($cad)) return chop($cad);

                else return substr($cad,0,$ncar);

               

                }

 

 

 

function getRealIP()

{

  

   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )

   {

      $client_ip =

         ( !empty($_SERVER['REMOTE_ADDR']) ) ?

            $_SERVER['REMOTE_ADDR']

            :

            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?

               $_ENV['REMOTE_ADDR']

               :

               "unknown" );

  

      // los proxys van añadiendo al final de esta cabecera

      // las direcciones ip que van "ocultando". Para localizar la ip real

      // del usuario se comienza a mirar por el principio hasta encontrar

      // una dirección ip que no sea del rango privado. En caso de no

      // encontrarse ninguna se toma como valor el REMOTE_ADDR

  

      $entries = explode('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

  

      reset($entries);

      while (list(, $entry) = each($entries))

      {

         $entry = trim($entry);

         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )

         {

            // http://www.faqs.org/rfcs/rfc1918.html

            $private_ip = array(

                  '/^0\./',

                  '/^127\.0\.0\.1/',

                  '/^192\.168\..*/',

                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',

                  '/^10\..*/');

  

            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

  

            if ($client_ip != $found_ip)

            {

               $client_ip = $found_ip;

               break;

            }

         }

      }

   }

   else

   {

      $client_ip =

         ( !empty($_SERVER['REMOTE_ADDR']) ) ?

            $_SERVER['REMOTE_ADDR']

            :

            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?

               $_ENV['REMOTE_ADDR']

               :

               "unknown" );

   }

  

   return $client_ip;

  

}

?>