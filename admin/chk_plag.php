<?php

// $key = '1a4700fca3e9cfb292817bbcb69f38c5';
$query = $_REQUEST['text'];

$form_data = array(
    'query-list' => $query,
);

// echo "<pre>";
// print_r($form_data);
$str = http_build_query($form_data);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.check-plagiarism.com/frontend/checkPlagv4");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);

$err = curl_error($ch);

curl_close($ch);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $output;
}

?>