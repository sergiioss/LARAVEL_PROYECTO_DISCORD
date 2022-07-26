<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ChannelController extends Controller
{
    public function createChannel(Request $request, $id){
        try{
            Log::info("Creating Channel");

            $validator = Validator::make($request->all(),[
                'name'=> ['required', 'string']
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ],400);
            }           

            $name = $request->input('name');
            $userId = auth()->user()->id;

            $channel = new Channel();
            $channel->name = $name;
            $channel->game_id = $id;

            $channel->save();

            return response()->json ([
                'success'=> true,
                'message'=> 'Channel created'
            ],200);

        }catch(\Exception $exception){
            Log::error("Error creating channel:" . $exception->getMessage());

            return response()->json([
                'succes'=> false,
                'message' => "Error creating Channel"
            ],500);
        }
    }
}
