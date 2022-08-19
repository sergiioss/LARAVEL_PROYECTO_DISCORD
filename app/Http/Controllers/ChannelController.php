<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ChannelController extends Controller
{
    public function createChannel(Request $request, $id)
    {
        try {
            Log::info("Creating Channel");

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

            $channel = new Channel();
            $channel->name = $name;
            $channel->game_id = $id;

            $channel->save();

            $channel->users()->attach($userId);

            return response()->json([
                'success' => true,
                'message' => 'Channel created'
            ], 200);
        } catch (\Exception $exception) {
            Log::error("Error creating channel:" . $exception->getMessage());

            return response()->json([
                'succes' => false,
                'message' => "Error creating Channel"
            ], 500);
        }
    }

    public function channelAll()
    {

        try {
            Log::info('Getting all Channels');

            $userId = auth()->user()->id;

            $channel = Channel::get()->toArray();

            return response()->json([
                'success' => true,
                'message' => 'Channel retrieved succesfull',
                'data' => $channel
            ]);
        } catch (\Exception $exception) {
            Log::error('Error getting channel' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating channel'
            ], 500);
        }
    }

    public function updatedChannel(Request $request, $id)
    {
        try {
            Log::info("Update channel");

            $validator = Validator::make($request->all(), [
                'name' => ['string']
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $validator->errors()
                    ],
                    400
                );
            };

            $userId = auth()->user()->id;

            $channel = DB::table('channel_user')
            ->where('user_id', $userId)
            ->where('channel_id', $id)
            ->get(); 

            /* Aqui Le pregunto si ha encontrado la coincidencia del canal de manera que si ha encontrado algo aparecera un 1 y si no ha encontrado nada un 0 */

            $cuantos = count($channel);

            /* Aqui simplemente un if para que cuando sea 1 ejecute el guardado y si es 0 me devuelva error */

            if($cuantos === 0){
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Ese canal no existe'
                    ],
                    
                );
            }else{
                $channel = Channel::find($id);

                $name = $request->input('name');
                $channel->name = $name;
                $channel->save(); 
            }

            return response()->json(
                [
                    'success' => true,
                    'message' => "Channel".$id."updated"
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error("Error updating channels: " . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => "Error updating channels"
                ],
                500
            );
        }
    }

    public function deleteChannel($id){
        try{
            Log::info('Delete a channel');

            $userId = auth()->user()->id;

            $channel = DB::table('channel_user')
            ->where('user_id', $userId)
            ->where('channel_id', $id)
            ->get();

            $cuantos = count($channel);

            if($cuantos === 0){
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Ese canal no existe'
                    ],
                    
                );
            }else{
                $channel = Channel::find($id);
                $channel->delete(); 
            }

            return response()->json([
                'success'=>true,
                'message'=> 'Channel' .$id.' deleted'
            ],200);

        }catch(\Exception $exception){
            Log::error('Error delete channel' . $exception->getMessage());
            return response()->json(
                [
                    'success'=> false,
                    'message'=> 'Error delete channel'
                ],500);
        }
    }

    public function loginChannel(Request $request, $id)
    {
        try {
            Log::info("Login channel");

            $validator = Validator::make($request->all(), [
                'login' => ['boolean']
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $validator->errors()
                    ],
                    400
                );
            };

            $userId = auth()->user()->id;

            $channel = DB::table('channel_user')
            ->where('channel_id', $id)
            ->get();
            
            /* Aqui Le pregunto si ha encontrado la coincidencia del canal de manera que si ha encontrado algo aparecera un 1 y si no ha encontrado nada un 0 */

            $cuantos = count($channel);

            /* Aqui simplemente un if para que cuando sea 1 ejecute el guardado y si es 0 me devuelva error */

            if($cuantos === 0){
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Ese canal no existe'
                    ],
                    
                );
            }else{
                $channel = DB::table('channel_user')
                ->where('channel_id', $id)
                ->update(['channel_user.login' => true]);
            }
            
            return response()->json(
                [
                    'success' => true,
                    'message' => "Channel".$id."updated"
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error("Error login channel: " . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => "Error login channel"
                ],
                500
            );
        }
    }

    public function logoutChannel(Request $request, $id)
    {
        try {
            Log::info("Logout channel");

            $validator = Validator::make($request->all(), [
                'login' => ['boolean']
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $validator->errors()
                    ],
                    400
                );
            };

            $userId = auth()->user()->id;

            $channel = DB::table('channel_user')
            ->where('channel_id', $id)
            ->get();
            
            /* Aqui Le pregunto si ha encontrado la coincidencia del canal de manera que si ha encontrado algo aparecera un 1 y si no ha encontrado nada un 0 */

            $cuantos = count($channel);

            /* Aqui simplemente un if para que cuando sea 1 ejecute el guardado y si es 0 me devuelva error */

            if($cuantos === 0){
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Ese canal no existe'
                    ],
                    
                );
            }else{
                $channel = DB::table('channel_user')
                ->where('channel_id', $id)
                ->update(['channel_user.login' => false]);
            }
            
            return response()->json(
                [
                    'success' => true,
                    'message' => "Channel".$id."updated"
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error("Error logout channels: " . $exception->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => "Error logout channels"
                ],
                500
            );
        }
    }

}
