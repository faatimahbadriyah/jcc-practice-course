<?php

namespace App\Http\Controllers;

use Nexmo\Laravel\Facade\Nexmo;

class SmsController extends Controller
{
    public function sms()
    {
        $payload = [
            'to' => '6281398599459',
            'from' => 'fatimah',
            'text' => 'Test SMS',
        ];
        $send = Nexmo::message()->send($payload);

        $data = [
            'message' => 'Gagal kirim sms',
            'data' => json_encode($send),
        ];

        if (!$send) {
            return response()->json($data, 400);
        }

        $data['message'] = 'Berhasil kirim sms';
        $data['data'] = $payload;
        return response()->json($data, 200);
    }
}
