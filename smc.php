<?php
// SMC Tools V 1.0 Beta
system('clear');
include "header.php";

function loop($url){
     $data = curl_init();
     curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($data, CURLOPT_URL, $url);
     curl_setopt($data, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.109 Safari/537.36");
     $http = curl_getinfo($data, CURLINFO_HTTP_CODE);
     $output = curl_exec($data);
     curl_close($data);
     return $output;
}

// \033[92m[+]\033[97m Pilih Options : 
                
function pilih(){
  echo "\n\033[91m-----------------------------------------
| \033[92mChooise Options :\033[91m                     |
|_______________________________________|
| \033[92m1. Get Information Phone Number\033[91m       |
| \033[92m2. IP Tracking                        \033[91m|
| \033[92m3. Check Valid Email\033[91m                  |
| \033[92m4. Detect CMS\033[91m                         | 
| \033[92m5. Lookup Domain\033[91m                      |    
-----------------------------------------\033[97m\n";
}
while(true){
pilih();
echo "\033[92m[+]\033[97m Choose Options : ";
$c = trim(fgets(STDIN));
switch ($c){
  case 1:
    $phone = readline("\033[92m[+]\033[97m Phone Number : ");
    echo "\033[92m[+]\033[96m Get Information Phone Number..\033[97m\n\n";
    $token = "3cdc7d946faa9e4ad32b57efdde98c8d";
    $responsephone = loop("http://apilayer.net/api/validate?access_key=$token&number=$phone&country_code=ID");
    $responsephone = json_decode($responsephone, TRUE);
    echo "\033[96m[Messages]\n\033[97m";
    echo "\033[92m[+]\033[97m Valid                 : ".$responsephone['valid']."\n";
    echo "\033[92m[+]\033[97m Phone Number          : ".$responsephone['number']."\n";
    echo "\033[92m[+]\033[97m Local Format          : ".$responsephone['local_format']."\n";
    echo "\033[92m[+]\033[97m International Format  : ".$responsephone['international_format']."\n";
    echo "\033[92m[+]\033[97m Country Prefix        : ".$responsephone['country_prefix']."\n";
    echo "\033[92m[+]\033[97m Country Code          : ".$responsephone['country_code']."\n";
    echo "\033[92m[+]\033[97m Country Name          : ".$responsephone['country_name']."\n";
    echo "\033[92m[+]\033[97m Location              : ".$responsephone['location']."\n";
    echo "\033[92m[+]\033[97m Carrier               : ".$responsephone['carrier']."\n";
    echo "\033[92m[+]\033[97m Line Type             : ".$responsephone['line_type']."\n";
    break;
  case 2:
    $ip = readline("\033[92m[+]\033[97m IP : ");
    echo "\033[92m[+]\033[96m Get Information IP Address..\033[97m\n\n";
    $responseip = loop("https://tools.keycdn.com/geo.json?host=$ip");
    $dec = json_decode($responseip);
    foreach($dec->data->geo as $key => $data){
      echo "\033[92m[+]\033[97m ".ucfirst(str_replace('_', ' ', $key))." : ".$data."\n";
      }
//     echo "\033[92m[+]\033[97m Google Maps : https://maps.google.com/maps?q=".$responseip['latitude'].",".$responseip['longitude']."&hl=ID;z=14&amp;output=embed\n";
    break;
  case 3:
    $email = readline("\033[92m[+]\033[97m Email : ");
    echo "\033[92m[+]\033[96m Checker Valid Email..\033[97m\n\n";
    $responseemail = loop("https://api.2ip.me/email.txt?email=$email");
    if (preg_match("/true/", $responseemail)){
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Email : \033[96m$email\033[97m - Email \033[92mValid\033[97m\n";      
    }
    else if (preg_match("/Limit/", $responseemail)){
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Email : \033[96m$email - \033[91mLimit requests\n\033[97m";
    }
    else{
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Email : \033[96m$email\033[97m - Email \033[91minvalid\033[97m\n";
    }
    break;
  case 4:
    $site = readline("\033[92m[+]\033[97m Website : ");
    echo "\033[92m[+]\033[96m CMS Detection..\033[97m\n\n";
    $responsesite = loop("$site");
    if (preg_match("/po-content|detailpost/", $responsesite)){ //Popoji
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Website : \033[96m$site\033[97m - CMS used is \033[92mPopoji\n\033[97m";
    }
    else if(preg_match("/wp-content|wordpress|Wordpress|xmlrpc.php/", $responsesite)){ //Wordpress
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Website : \033[96m$site\033[97m - CMS used is \033[92mWordpress\n\033[97m";
    }
    elseif(preg_match("/com_content|Joomla!|\/media\/system\/js\/|<script type=\"text\/javascript\" src=\"\/media\/system\/js\/mootools.js\"><\/script>/", $responsesite)){ //Joomla
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Website : \033[96m$site\033[97m - CMS used is \033[92mJoomla\n\033[97m"; 
      }
    else if(preg_match("/Drupal|drupal|sites\/all|node|drupal.org/", $responsesite)){ //Drupal
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Website : \033[96m$site\033[97m - CMS used is \033[92mDrupal\n\033[97m";
    }
    else if(preg_match("/Prestashop|prestashop/", $responsesite)){ //Prestashop
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Website : \033[96m$site\033[97m - CMS used is \033[92mPrestashop\n\033[97m";
    }
    else if(preg_match("/foto_berita|foto_user|files|statis-|berita-/", $responsesite)){ //Lokomedia
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Website : \033[96m$site\033[97m - CMS used is \033[92mLokomedia\n\033[97m";
    }
    else if(preg_match("/Interspire Email Marketer|Login with your username and password below|Take Me To/", $responsesite)){ //IEM
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Website : \033[96m$site\033[97m - CMS used is \033[92mInterspire Email Marketer\n\033[97m";
    }
    else if(preg_match("/route=product|Powered by OpenCart/", $responsesite)){ //Open Cart
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Website : \033[96m$site\033[97m - CMS used is \033[92mOpenCart\n\033[97m";
    }
    else if(preg_match("/Balitbang Kemdikbud|Tim Balitbang/", $responsesite)){ //Balitbang
      echo "\033[96m[Messages]\n";
      echo "\033[92m[+]\033[97m Website : \033[96m$site\033[97m - CMS used is \033[92mBalitbang\n\033[97m";
    }
    else{
      echo "\033[96m[Messages]\n";
      echo"\033[91m[-]\033[97m Website : \033[96m$site - CMS used is \033[91mUnknown\n\033[97m";
    }
    break;
  case 5:
    $site2 = readline("\033[92m[+]\033[97m Website : ");
    $lookupsite = loop("https://www.whoisxmlapi.com/whoisserver/WhoisService?apiKey=at_GZhISfBnRvfmABdgEKxhFK1GOnVWW&domainName=$site2");
    $xml = simplexml_load_string($lookupsite);
    $end = json_encode($xml);
    $declookup = json_decode($end, TRUE);
    echo "\033[96m[Messages]\n";
    echo "\n\033[96m[Domain Info]\n";
    echo "\033[92m[+]\033[97m Domain        : ".$declookup['domainName']."\n";
    echo "\033[92m[+]\033[97m Registered on : ".$declookup['createdDate']."\n";
    echo "\033[92m[+]\033[97m Updated on    : ".$declookup['updatedDate']."\n";
    echo "\033[92m[+]\033[97m Expired on    : ".$declookup['expiresDate']."\n";
    echo "\n\033[96m[Registration Contact]\n\033[97m";
    echo "\033[92m[+]\033[97m Name          : ".$declookup['registrant']['name']."\n";
    echo "\033[92m[+]\033[97m Organization  : ".$declookup['registrant']['organization']."\n";
    echo "\033[92m[+]\033[97m Street        : ".$declookup['registrant']['street1']."\n";
    echo "\033[92m[+]\033[97m City          : ".$declookup['registrant']['city']."\n";
    echo "\033[92m[+]\033[97m State         : ".$declookup['registrant']['state']."\n";
    echo "\033[92m[+]\033[97m Postal Code   : ".$declookup['registrant']['postalCode']."\n";
    echo "\033[92m[+]\033[97m Country       : ".$declookup['registrant']['country']."\n";
    echo "\033[92m[+]\033[97m Phone         : ".$declookup['registrant']['telephone']."\n";
    echo "\033[92m[+]\033[97m Email         : ".$declookup['registrant']['email']."\n";
    echo "\n\033[96m[Name Server]\n";
    echo "\033[92m[+]\033[97m NS1        : ".$declookup['nameServers']['hostNames']['Address']['0']."\n";
    echo "\033[92m[+]\033[97m NS2        : ".$declookup['nameServers']['hostNames']['Address']['1']."\n";
    break;
  default:
    echo "\033[91mEnter the options correctly!\n\033[97m";
    break;
}
}
?>
