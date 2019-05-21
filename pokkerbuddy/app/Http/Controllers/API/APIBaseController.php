<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIBaseController extends Controller {

    public function sendResponse($result, $message, $requestkey) {
        $response = [
            'status' => 'SUCCESS',
            'message' => $message,
            'requestKey' => $requestkey,
            'data' => $result,
        ];
        return response()->json($response, 200);
    }

    public function sendError($requestkey, $errorMessages) {
        $response = [
            'status' => 'FAILURE',
            'message' => $errorMessages,
            'requestKey' => $requestkey,
        ];

        return response()->json($response, 200);
    }



    public function android_push($deviceToken = null, $message = null, $type = null, $badge = null, $batch = array()) {
        $this->autoRender = false;
        $this->layout = false;
        $url = 'https://android.googleapis.com/gcm/send';
        $message = array("batch" => $batch, 'badge' => $badge, 'sound' => 'default', 'type' => $type, "message" => $message);
         $registatoin_ids = array($deviceToken);

        $fields = array('registration_ids' => $registatoin_ids, 'data' => $message);
        $GOOGLE_API_KEY = "AIzaSyBveHtZkYLhMCBI_rJtyXY3nwZ0hGxckwM";
        $headers = array(
            'Authorization: key=' . $GOOGLE_API_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
    
        if ($result === false) {
            // die('Curl failed: ' . curl_error($ch));
        } else {
        //print_r("success");die;
        }
        curl_close($ch);
    }


  // public function iphone_push($deviceToken = null, $message = null, $type = null,$badge = null,$batch = array())
  //   {

  //        $deviceToken      = $deviceToken; //"01FE59D85A1F62728541988192F92AF840D098F89254D607D6D7B97F250D12BB";//$deviceToken;
  //       //636A67B61425C7C677704334D40B852844445D63CD5921DC6B151F9D9F20E7A5

  //       $passphrase       = '123456';
  //       $Text             = $message;
  //       $this->autoRender = false;
  //       $this->layout     = false;
  //       $basePath         = public_path().'/PokerSignOnNew_Noti_Dev.pem';
        
  //       if (file_exists($basePath)) {
  //           $ctx = stream_context_create();
  //           stream_context_set_option($ctx, 'ssl', 'local_cert', $basePath);
  //           stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
  //           $fp = stream_socket_client(
  //               'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx
  //           );
  //           if (!$fp) {
  //               exit("Failed to connect: $err $errstr" . PHP_EOL);
  //           }
  //           $body['aps'] = array('alert' => array("body" => $Text, 'type' => $type),'badge' => $badge,'sound' => 'default',"batch"=>$batch);
           
  //           $payload     = json_encode($body);
  //           $msg         = chr(0) . pack('n', 32) . pack("H*", $deviceToken) . pack('n', strlen($payload)) . $payload;
  //             $result      = fwrite($fp, $msg, strlen($msg));
            
  //           if (!$result) {
  //          /*     echo 'Message not delivered' . PHP_EOL;
  //           echo $result;
  //           echo "Failure";*/
  //           } else {
  //              //]  var_dump($result);
  //           //  print_r($msg);

  //               //echo "success";die;
  //           }
  //           fclose($fp);
  //       }
  //   }



}
