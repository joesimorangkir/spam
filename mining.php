<?php

class Modul{
    
    public function curl ($url, $post = 0, $httpheader = 0, $proxy = 0, $uagent = 0){ // url, postdata, http headers, proxy, uagent
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_COOKIEJAR, ".cookie");
        curl_setopt($ch, CURLOPT_COOKIEFILE, ".cookie");
        if($post){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        if($httpheader){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
        }
        if($proxy){
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            // curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        }
        if($uagent){
            curl_setopt($ch, CURLOPT_USERAGENT, $uagent);
        }else{
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:66.0) Gecko/20100101 Firefox/".rand(1,200).".0");
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch);
        if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
            $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            curl_close($ch);
            return array($header, $body);
        }
    }
    public function xurl($url,$method="GET", $body=NULL, $headers=[]) {
            $return = [];
              while(1):
              // Exchange the auth code for an access token
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 6); //timeout in seconds
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

              // Get the method and set if required
            $method = strtoupper($method);
            if( $method != "GET" ) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            }

              // If method is a POST, set the appropriate headers
            if( $method == "POST" ) {
            curl_setopt($ch, CURLOPT_POST, true);
            if ( !empty($body) ) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            $headers[] = 'Content-Length: ' . strlen($body);
            }
          }
          // Exec the curl command
          $resp = curl_exec($ch);

          // Evaluate the response code
          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          $return["status"] = $httpcode;
          if( $httpcode === 0 ) {
            echo "\033[0;33myour connection is bad\033[0m\n";
            continue;
        }

          // Get the respone and set the return payload
          $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
          $return[] = substr($resp, 0, $header_size);
          $return[] = substr($resp, $header_size);

          return $return;
          endwhile;
    }
    public function array_to_cookies($source){
        if(!is_array($source)){
            return "NOT ARRAY!";
        }else{
            return str_replace(array('{"', '"}', '":"', '","'), array('', '', '=', '; '), json_encode($source));
        }
    }
    public function fetch_cookies($source) { // string
        preg_match_all('/^Set-Cookie:\s*([^;\r\n]*)/mi', $source, $matches); 
        $cookies = array(); 
        foreach($matches[1] as $item) { 
            parse_str($item, $cookie); 
            $cookies = array_merge($cookies, $cookie); 
        }
        return $cookies;
    }
    public function col($str,$color){
        $warna=array('x'=>"\033[0m",'p'=>"\033[1;37m",'a'=>"\033[1;30m",'m'=>"\033[1;31m",'h'=>"\033[1;32m",'k'=>"\033[1;33m",'b'=>"\033[1;34m",'u'=>"\033[1;35m",'c'=>"\033[1;36m",'px'=>"\033[1;7m",'mp'=>"\033[1;41m",'hp'=>"\033[1;42m",'kp'=>"\033[1;43m",'bp'=>"\033[1;44m",'up'=>"\033[1;45m",'cp'=>"\033[1;46m",'pp'=>"\033[1;47m",'ap'=>"\033[1;100m",'pm'=>"\033[7;41m",);return $warna[$color].$str."\033[0m";}
    public function timer($text,$timer){
        date_default_timezone_set('UTC');
        $tim = time()+$timer;
        $blue="\033[34m";$cyn="\033[36m";
        $blet="\033[92m";$putih="\033[37m";
        $bpur="\033[35m";$m="\033[31m";
        $bhj="\033[33m";$nyr="\033[8m";
        $rm="\033[0"."m";
        $wrn=[$putih,$m];
        $i=0;
        $randw=[$blet,$bhj,$cyn,$blet,$bhj,$cyn];$x=1;
        while(true):
        echo "\r                                                        \r";
        $wsl=$wrn[$i];
        $tm = $tim-time();
        $date=date("H:i:s",$tm);
        if($tm<1){ break; }
        $str=str_repeat("•",$x);$stran=$randw[$x-1];
        $as="strtime ";$cls="]";
        echo $putih.$text."$putih [$wsl$date$putih$cls $as$stran$str";
        if($x==6){$x=1;}else{$x++;} sleep(1);
        $i++;
        if($i >= count ($wrn)){$i=0;}
        endwhile;
    }
    public function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
    public function save($data,$data_post){
        if(!file_get_contents($data)){
          file_put_contents($data,"[]");}
          $json=json_decode(file_get_contents($data),1);
          $arr=array_merge($json,$data_post);
          file_put_contents($data,json_encode($arr,JSON_PRETTY_PRINT));
    }
    public function clr($data){system("clear");echo $data;}
    public function build($data){ return http_build_query($data);}
    public function set_ban($str,$int){
           $url="http://kakatoji.online/kakatoji/";
           $data=$this->build(["nb"=>$str,"int"=>$int]);
           $cek=$this->curl($url,$data);
           return $cek[1];
    }
    public function strip(){
        echo str_repeat("─",60)."\n";
    }
    public function rata($str, $std = 15){
        $len = strlen($str);
        if ($len < $std) {
        $n = $std - $len;
        $str .= str_repeat(" ", $n);
         }
        if ($len > $std) {
        $str = substr($str, 0, $std);
         }
         return $str;
    }
    public function name(){
          $url="https://randomuser.me/api/?format=json";
          $data=json_decode(file_get_contents($url),1);
          return $data;
    }
    public function prox(){
           $file=json_decode($this->curl("https://gimmeproxy.com/api/getProxy?get=true&supportsHttps=true&maxCheckPeriod=3600")[1],1);
           $data=[
               "proxy"  => $file["ip"],
               "port"   => $file["port"]
               ];
         return $data["proxy"].":".$data["port"];
    }
    public function uagent(){
         $url="https://raw.githubusercontent.com/kakatoji/ngecurl/main/user-agents.txt";
         $url=file_get_contents($url);
         preg_match_all("/(\s.*)/i",$url,$ua);
         $arr=array_filter($ua[1],'strlen');
         return trim($arr[array_rand($arr)]);
    }
    public function createMail(){
        $url="https://www.gmailnator.com";
        $arr=["upgrade-insecure-requests: 1","user-agent: Mozilla/5.0 (Linux; Android 8.1.0; SAMSUNG SM-C710F) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/16.0 Chrome/92.0.4515.166 Mobile Safari/537.36","accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9"];
        $create=$this->curl($url,"",$arr)[0];
        $cookie=$this->fetch_cookies($create);
        return $cookie;
    }
    public function cekMail(){
        $crt=$this->createMail();
        $ar[]="accept: */*";
        $ar[]="x-requested-with: XMLHttpRequest";
        $ar[]="user-agent: Mozilla/5.0 (Linux; Android 8.1.0; SAMSUNG SM-C710F) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/16.0 Chrome/92.0.4515.166 Mobile Safari/537.36";
        $ar[]="content-type: application/x-www-form-urlencoded; charset=UTF-8";
        $ar[]="referer: https://www.gmailnator.com/";
        $ar[]="cookie: csrf_gmailnator_cookie=".$crt['csrf_gmailnator_cookie'];
        $ar[]="cookie: ci_session=".$crt["ci_session"];
        $data=$this->build(["csrf_gmailnator_token"=>$crt["csrf_gmailnator_cookie"],"action"=>"GenerateEmail","data[]"=>1,"data[]"=>2,"data[]"=>3]);
        $mail=$this->curl("https://www.gmailnator.com/index/indexquery",$data,$ar)[1];
        return [
            "csrf_gmailnator_cookie" => $crt["csrf_gmailnator_cookie"],
            "ci_session"             => $crt["ci_session"],
            "email"                  => $mail
            ];
    }
    public function cekMessage($data){
        //$crt=$this->cekMail();
        $ua[]="accept: application/json, text/javascript, */*; q=0.01";
        $ua[]="x-requested-with: XMLHttpRequest";
        $ua[]="user-agent: Mozilla/5.0 (Linux; Android 8.1.0; SAMSUNG SM-C710F) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/16.0 Chrome/92.0.4515.166 Mobile Safari/537.36";
        $ua[]="content-type: application/x-www-form-urlencoded; charset=UTF-8";
        $ua[]="referer: https://www.gmailnator.com/inbox/";
        $ua[]="cookie: csrf_gmailnator_cookie=".$data["csrf_gmailnator_cookie"];
        $ua[]="cookie: ci_session=".$data["ci_session"];
        $data_post=$this->build(["csrf_gmailnator_token"=>$data["csrf_gmailnator_cookie"],"action"=>"LoadMailList","Email_address"=>$data["email"]]);
        $getMessage=$this->curl("https://www.gmailnator.com/mailbox/mailboxquery",$data_post,$ua)[1];
        return [
            "email" => $data["email"],
            "data"  =>  $getMessage   
            ];
    }
}
class bot extends Modul{
    public $host="https://nfiles.xyz/faucet/";
    public $sug="https://nfiles.xyz/ajax/sug.php";

    public function __construct(){
        $this->ua=[
            "Host: nfiles.xyz",
            "user-agent: ".self::uagent(),
            "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
            "x-requested-with: dogecoinminer.app",
            "sec-fetch-site: none",
            "sec-fetch-mode: navigate",
            "sec-fetch-user: ?1",
            "sec-fetch-dest: document"
            ];
            
        $bot="dogeminerApp";$ver="1.0";$con="data.json";
        $ban=self::set_ban($bot,$ver);
        if(!file_exists($con)){self::clr($ban);
            echo self::col("~ input email faucetpay.io: ","k");
            $em["email"]=trim(fgets(STDIN));
            self::save($con,$em);
        }$data=json_decode(file_get_contents($con),1);self::clr($ban);
        while(true):
        if(file_exists(".cookie")){unlink(".cookie");}
        $aw=$this->hos($data["email"]);self::timer("sabar menunggu ya",60);
        $an=self::curl($this->host.'claim.php','',$this->ua($this->host))[1];
        preg_match('#<code>(.*?)</code>#i',$an,$clm);
        preg_match('#:\s(.*?)\/(.*?)<#i',$an,$no);
        if($no[1] < 30){
            echo self::col("suksess claim ","h").self::col($clm[1],"c")." ".self::col("DOGE","mp")."\n";self::strip();
        }else{
            exit(self::col("limit claim","m"));
        }
        endwhile;
    }
    public function hos($mail){
        $data=self::build(["d1"=>$mail,"submit"=>""]);
        return self::curl($this->host,$data,$this->ua($this->host))[1];
    }
    public function ua($da){
        return array_merge($this->ua,["referer: ".$da]);
    }
    public function asd($mail){
        return self::curl($this->host.'xplay_v4.php?mail='.$mail,'',$this->ua($this->asu))[1];
    }
}
(new bot);
