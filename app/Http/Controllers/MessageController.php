<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function createMessage(Request $request, $id)
    {
        try {
            Log::info("Creating message");

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string']
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ], 400);
            }

            $name = $request->input('name');
            $userId = auth()->user()->id;

            $message = new Message();
            $message->messages = $name;
            $message->channel_id = $id;
            $message->user_id = $userId;

            $message->save();

            return response()->json([
                'success' => true,
                'message' => 'Message created'
            ], 200);

        } catch (\Exception $exception) {
            Log::error("Error creating message:" . $exception->getMessage());

            return response()->json([
                'succes' => false,
                'message' => "Error creating Message"
            ], 500);
        }
    }

    public function messagesAll(){
        try{
            Log::info('Getting all messages');

        $userId = auth()->user()->id;

        $messages = Message::where('user_id', $userId)
        ->get('messages');

        return response()->json([
            'success' => true,
            'message'=> 'Messages retrieved succesfull',
            'data' => $messages
        ]);

        }catch(\Exception $exception){
            Log::error('Error retrieved messages' . $exception->getMessage());
            return response()->json([
                'success'=> false,
                'message'=> 'Error retrieved messages'
            ],500);
        }
    }
}
