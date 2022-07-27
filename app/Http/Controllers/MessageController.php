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

    public function updatedMessage(Request $request, $id){
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

            $messages = Message::query()->where('user_id', $userId)->find($id);

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
                'message'=> "Game" .$id. "updated"
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

    public function deleteMessage($id){
        try{
            Log::info('Delete a message');

            $userId = auth()->user()->id;

            $message = Message::query()
            ->where('user_id', $userId)
            ->find($id);

            if(!$message){
                return response()->json([
                    'success'=> true,
                    'message'=> 'Message doesnt exists'
                ],404);
            }

            $message->delete();

            return response()->json([
                'success'=>true,
                'message'=> 'Message' .$id.' deleted'
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
