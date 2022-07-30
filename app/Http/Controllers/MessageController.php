<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    const LOGIN = 1;

    public function createMessage(Request $request, $channelId)
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

            $channel = DB::table('channel_user')
            ->where('user_id', $userId)
            ->where('channel_id', $channelId)
            ->where('login', self::LOGIN)
            ->get();

            $cuantos = count($channel);

            if($cuantos === 0){
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'No estas dentro del canal'
                    ],
                    
                );
            }

            $message = new Message();
            $message->messages = $name;
            $message->channel_id = $channelId;
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

    public function messagesAll($channelId){
        //ESTO LO QUE HACE ES VALIDAR SI ESTAS DENTRO DEL CANAL Y EN CASO DE QUE ESTES QUE TRAIGAS TODOS LOS MENSAJES QUE HAS ESCRITO EN ESE CANAL
        try{
            Log::info('Getting all messages');

        $userId = auth()->user()->id;

        $channel = DB::table('channel_user')
        ->where('user_id', $userId)
        ->where('channel_id', $channelId)
        ->where('login', self::LOGIN)
        ->get();

        $cuantos = count($channel);

        if($cuantos === 0){
            return response()->json(
                [
                    'success' => true,
                    'message' => 'No estas dentro del canal'
                ],
                
            );
        }

        $messages = Message::where('user_id', $userId)
        ->where('channel_id', $channelId)
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

    public function updatedMessage(Request $request, $channelId, $messageId){
        try{

            Log::info("Updated Message");

            $validator = Validator::make($request->all(),[
                'messages'=> ['string']
            ]);

            if($validator->fails()){
                return response()->json([
                    'success'=> false,
                    'message'=> $validator->errors()
                ],400);
            };

            $userId = auth()->user()->id;

            $channel = DB::table('channel_user')
            ->where('user_id', $userId)
            ->where('channel_id', $channelId)
            ->where('login', self::LOGIN)
            ->get();

            $cuantos = count($channel);

            if($cuantos === 0){
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'No estas dentro del canal'
                    ],
                    
                );
            }

            $messages = Message::query()
            ->where('user_id', $userId)
            ->find($messageId);

            if(!$messages){
                return response()->json(
                    [
                        'success' => true,
                        'message'=> 'Error'
                    ]
                    );
            }
            
            $changemessage = $request->input('messages');

            if(isset($changemessage)){
                $messages->messages = $changemessage;
            };

            $messages->save();

            return response()->json([
                'success'=> true,
                'message'=> "Game" .$messageId. "updated"
            ],200);

        }catch(\Exception $exception){
            Log::error('Error updated game' . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error updated game'
                ],500
            );
        }
    }

    public function deleteMessage($channelId, $messageId){
        try{
            Log::info('Delete a message');

            $userId = auth()->user()->id;

            $channel = DB::table('channel_user')
            ->where('user_id', $userId)
            ->where('channel_id', $channelId)
            ->where('login', self::LOGIN)
            ->get();

            $cuantos = count($channel);

            if($cuantos === 0){
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'No estas dentro del canal'
                    ],
                    
                );
            }
            
            $message = Message::query()
            ->where('user_id', $userId)
            ->find($messageId);

            if(!$message){
                return response()->json([
                    'success'=> true,
                    'message'=> 'Message doesnt exists'
                ],404);
            }

            $message->delete();

            return response()->json([
                'success'=>true,
                'message'=> 'Message' .$messageId.' deleted'
            ],200);

        }catch(\Exception $exception){
            Log::error('Error delete message' . $exception->getMessage());
            return response()->json(
                [
                    'success'=> false,
                    'message'=> 'Error delete message'
                ],500);
        }
    }
}
