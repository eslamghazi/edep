<?php

namespace App\Gateways;

use App\Interfaces\SMS;
use Illuminate\Support\Facades\Http;

class Dreamsa implements SMS
{

    private $secretKey;
    private $user;
    private $sender;

    public function __construct()
    {
        $this->secretKey = config("services.dreamsa.secretKey");
        $this->user = config("services.dreamsa.user");
        $this->sender = config("services.dreamsa.sender");
    }

    public function connect($message, $phone)
    {
        $url = 'https://www.dreams.sa/index.php/api/sendsms';

        $data = [
            'user'        => $this->user,
            'secret_key'  => $this->secretKey,
            'to'          => $phone, // Assuming you want to use the $phone variable passed to the method
            'message'     => $message,
            'sender'      => $this->sender,
            'date'        => date('Y-m-d'),
            'time'        => date('H:i:s')
        ];

        // Using the Http facade to send a POST request
        $response = Http::get($url, $data);

        \Illuminate\Support\Facades\Log::info('Dreamsa SMS Response: ' . $response->body());

        // Decoding the JSON response into an array
        $responseCode = $response->json();

        if ($responseCode == null) {
            return response()->json([
                'status' => 'success',
                'message' => 'SMS sent successfully'
            ]);
        } else {
            // The defineError method should exist within this class and handle the error codes
            return response()->json([
                'status' => 'error',
                'message' => $this->defineError($responseCode ?? null)
            ]);
        }
    }


    public function send($message, $phone, $lang = 'E', $senderID = null)
    {
        return $this->connect($message, $phone, $lang, $senderID);
    }

    public function defineError($code)
    {
        $arErrors = [
            '-100' => 'المعلومات مفقودة (لا توجد أو فارغة)',
            '-110' => 'اسم المستخدم أو مفتاح السر خطأ',
            '-111' => 'الحساب غير مُفعل',
            '-112' => 'الحساب محظور',
            '-113' => 'رصيد غير كاف',
            '-114' => 'الخدمة غير متوفرة حالياً',
            '-115' => 'المرسل غير متاح (إذا لم يكن للمستخدم مرسل مفتوح)',
            '-116' => 'اسم المرسل غير صالح',
            '-117' => 'تحقق من رقمك. هناك مشكلة ما',
            '-118' => 'خطأ غير مرغوب فيه',
            '-119' => 'التاريخ المحدد ليس صحيحًا',
            '-122' => 'الرقم غير مسموح به',
            '-124' => 'الآي بي غير مسموح به',
        ];

        return $arErrors[$code] ?? 'Unknown error';
    }
}
