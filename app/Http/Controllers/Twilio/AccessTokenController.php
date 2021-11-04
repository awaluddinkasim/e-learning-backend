<?php

namespace App\Http\Controllers\Twilio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class AccessTokenController extends Controller
{
    public function generate_token(Request $request)
    {
        // Substitute your Twilio Account SID and API Key details
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $apiKeySid = env('TWILIO_API_KEY_SID');
        $apiKeySecret = env('TWILIO_API_KEY_SECRET');

        $identity = uniqid();

        $room_name = $request->room_name ? $request->room_name : 'Conference';

        // Create an Access Token
        $token = new AccessToken(
            $accountSid,
            $apiKeySid,
            $apiKeySecret,
            3600,
            $identity,
            $room_name
        );

        // Grant access to Video
        $grant = new VideoGrant();
        // $grant->setRoom('cool room');
        $token->addGrant($grant);

        // Serialize the token as a JWT
        $result=[
            "identity" => $identity,
            "token"=> $token->toJWT()
        ];
        return response()->json($result);
    }
}
