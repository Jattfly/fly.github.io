<?php

//======================================================================================//
$id = $_GET['id'] ?? die("Please Provide ID.");
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? die("Really Kid.");





//================== codded by Noobmaster_616 =========================\\

// Use the direct API URL instead of encoding
$apiURL = "https://apex2nova.com/premium.php?player=desktop&live=" . urlencode($id);

// Set referrers
$srcReferer = "https://stream.crichd.sc/";
$iframeReferer = "https://apex2nova.com/";
$pattern = '/return\(\[(.*)\]/';



//================== Function to fetch data from URLs =========================\\


function fetchData($url, $referer, $userAgent) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_REFERER => $referer,
        CURLOPT_USERAGENT => $userAgent,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
            "Accept: */*",
            "Accept-Language: en-US,en;q=0.9",
            "Cache-Control: no-cache",
            "Connection: keep-alive",
        ]
    ]);
    $response = curl_exec($ch);
    if ($response === false) {
        die("cURL Error: " . curl_error($ch));
    }
    curl_close($ch);
    return $response;
}

//==================Get initial response =========================\\
$response = fetchData($apiURL, $srcReferer, $userAgent);




// Parse and process the response
if (preg_match($pattern, $response, $matches)) {
    //================== Clean and format the URL =========================\\
    $cleanUrl = str_replace(['return([', '","', '\/', '\\', ']'], ['', '', '/', '', ''], trim($matches[1], '"'));
    $cleanUrl = preg_replace('#(?<=https:)/+#', '//', $cleanUrl);
    

    
    //================== Fetch stream data =========================\\

    $responseSecond = fetchData($cleanUrl, $iframeReferer, $userAgent);


    

    //================== Extract and modify the HLS path =========================\\
    $modifiedPath = preg_replace('#(/hls/)[^/]+#', '$1', $cleanUrl);


    
    //================== Generate final stream URL =========================\\
    $finalResponse = str_replace($id, $modifiedPath . $id, $responseSecond);


    
    
    //================== Output the stream data =========================\\
    header('Content-Type: application/x-mpegURL');
    echo $finalResponse;
} else {
    //================== No match found in stream response =========================\\
    die("No match found in stream response.");
}
?>