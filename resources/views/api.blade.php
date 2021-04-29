<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://5e24ee53213a14c15e2761b71bfd235e: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@isfdilat.myshopify.com/admin/api/2021-01/products.json?fields=id,images,title',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: _shopify_fs=2021-03-26T12%3A09%3A17Z; _y=1a4616b3-0e77-47ad-9993-5a9e979ab6d0; _shopify_y=1a4616b3-0e77-47ad-9993-5a9e979ab6d0; _s=fd8f374d-7808-4bf7-817f-0e83fbb2df3f; _shopify_s=fd8f374d-7808-4bf7-817f-0e83fbb2df3f'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
