<?php

namespace App\Services;

class ZaloPayService
{

  protected $endpointUrl;
  protected $zaloPayAppId;
  protected $zaloPayApikey;
  protected $zaloPayApikey2;

  public function __construct()
  {
    $this->zaloPayAppId = env('ZALO_APP_ID', 2553);
    $this->zaloPayApikey = env('ZALO_API_KEY', 'PcY4iZIKFCIdgZvA6ueMcMHHUbRLYjPL');
    $this->zaloPayApikey2 = env('ZALO_API_KEY_2', 'kLtgPl8HHhfvMuDHPwKfgfsY4Ydm9eIz');
  }

  /**
   * Get all banks list
   */
  public function getBankList()
  {
    $this->endpointUrl = "https://sbgateway.zalopay.vn/api/getlistmerchantbanks";
    $config = [
      "appid" => $this->zaloPayAppId,
      "key1" => $this->zaloPayApikey,
      "key2" => $this->zaloPayApikey2,
      "endpoint" => $this->endpointUrl,
    ];

    $reqtime = round(microtime(true) * 1000); // miliseconds
    $params = [
      "appid" => $config["appid"],
      "reqtime" => $reqtime,
      "mac" => hash_hmac("sha256", $config["appid"] . "|" . $reqtime, $config["key1"]) // appid|reqtime
    ];

    $resp = file_get_contents($config["endpoint"] . "?" . http_build_query($params));
    $result = json_decode($resp, true);

    return $result;
  }

  /**
   * Create new order payment
   */
  public function createPayment(string $amount, ?string $bankCode, string $redirectUrl, string $description, string $orderCode)
  {
    if (!isset($amount) || !is_numeric($amount)) return [
      'error_code' => 1,
      'message' => 'Required amount of payment'
    ];


    if (!isset($redirectUrl) || !filter_var($redirectUrl, FILTER_VALIDATE_URL)) return [
      'error_code' => 1,
      'message' => 'Required redirect url of payment'
    ];

    if (!isset($description)) return [
      'error_code' => 1,
      'message' => 'Required description of the payment'
    ];

    $this->endpointUrl = "https://sb-openapi.zalopay.vn/v2/create";

    $config = [
      "app_id" => $this->zaloPayAppId,
      "key1" => $this->zaloPayApikey,
      "key2" => $this->zaloPayApikey2,
      "endpoint" => $this->endpointUrl
    ];

    if ($bankCode) {
      $embeddata = json_encode([
        'redirecturl' => $redirectUrl
      ], JSON_UNESCAPED_SLASHES);
    } else {
      $embeddata = json_encode([
        'redirecturl' => $redirectUrl,
        'bankgroup' => 'ATM'
      ], JSON_UNESCAPED_SLASHES); // Merchant's data
    }

    $items = '[]'; // Merchant's data
    $transID = rand(0, 1000000); //Random trans id
    $app_trans_id = date("ymd") . "_" . $transID;
    $order = [
      "app_id" => $config["app_id"],
      "app_time" => round(microtime(true) * 1000), // miliseconds
      "app_trans_id" => $app_trans_id,
      "app_user" => "user123",
      "item" => $items,
      "embed_data" => $embeddata,
      "amount" => $amount,
      "description" => "$description #$transID",
      "bank_code" => $bankCode,
    ];

    // appid|app_trans_id|appuser|amount|apptime|embeddata|item
    $data = $order["app_id"] . "|" . $order["app_trans_id"] . "|" . $order["app_user"] . "|" . $order["amount"]
      . "|" . $order["app_time"] . "|" . $order["embed_data"] . "|" . $order["item"];
    $order["mac"] = hash_hmac("sha256", $data, $config["key1"]);

    $context = stream_context_create([
      "http" => [
        "header" => "Content-type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query($order)
      ]
    ]);

    $resp = file_get_contents($config["endpoint"], false, $context);
    $result = json_decode($resp, true);

    return $result;
  }

  /**
   * Get payment status
   */
  public function getStatusPayment($appTransId)
  {
    $this->endpointUrl = 'https://sb-openapi.zalopay.vn/v2/query';

    $config = [
      "app_id" => $this->zaloPayAppId,
      "key1" => $this->zaloPayApikey,
      "key2" => $this->zaloPayApikey2,
      "endpoint" => $this->endpointUrl
    ];

    if (!$appTransId) return [
      'error_code' => 1,
      'message' => 'AppTransId is required'
    ];

    $data = $config["app_id"] . "|" . $appTransId . "|" . $config["key1"]; // app_id|app_trans_id|key1
    $params = [
      "app_id" => $config["app_id"],
      "app_trans_id" => $appTransId,
      "mac" => hash_hmac("sha256", $data, $config["key1"])
    ];

    $context = stream_context_create([
      "http" => [
        "header" => "Content-type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query($params)
      ]
    ]);

    $resp = file_get_contents($config["endpoint"], false, $context);
    $result = json_decode($resp, true);

    return $result;
  }
}
