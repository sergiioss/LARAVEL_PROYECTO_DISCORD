<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function createGame(Request $request){
        try{
            Log::info("Creating Game");

            $validator = Validator::make($request->all(),[
                'name'=> ['required', 'string'],
                'url' => ['string']
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()
                ],400);
            }           

            $name = $request->input('name');
            $url = $request->input('url');
            $userId = auth()->user()->id;

            $game = new Game();
            $game->name = $name;
            $game->url = $url;
            $game->user_id = $userId;

            $game->save();

            return response()->json ([
                'success'=> true,
                'message'=> 'Game created'
            ],200);

        }catch(\Exception $exception){
            Log::error("Error creating game:" . $exception->getMessage());

            return response()->json([
                'succes'=> false,
                'message' => "Error creating Game"
            ],500);
        }
    }

    public function gameId(){
        try{
            Log::info('Getting all Games');

        $game = Game::query()
        ->get()->games;

        return response()->json([
            'success' => true,
            'message'=> 'Games retrieved succesfull',
            'data' => $game
        ]);

        }catch(\Exception $exception){
            Log::error('Error getting game' . $exception->getMessage());
            return response()->json([
                'success'=> false,
                'message'=> 'Error creating game'
            ],500);
        }
    }

    public function updatedGame(Request $request, $id){
        try{

            Log::info("Updated Games");

            $validator = Validator::make($request->all(),[
                'name'=> ['string'],
                'url'=>['string']
            ]);

            if($validator->fails()){
                return response()->json([
                    'success'=> false,
                    'message'=> $validator->errors()
                ],400);
            };

            $userId = auth()->user()->id;

            $game = Game::query()->where('user_id', $userId)->find($id);

            if(!$game){
                return response()->json(
                    [
                        'success' => true,
                        'message'=> 'Error'
                    ]
                    );
            }

            $name = $request->input('name');
            $url = $request->input('url');

            $game->name = $name;
            $game->url = $url;
            
            if(isset($name)){
            };

            if(isset($url)){
            };

            $game->save();

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

    public function deleteGame($id){
        try{
            Log::info('Delete a game');

            $userId = auth()->user()->id;

            $game = Game::query()
            ->where('user_id', $userId)
            ->find($id);

            if(!$game){
                return response()->json([
                    'success'=> true,
                    'message'=> 'Game doesnt exists'
                ],404);
            }

            $game->delete();

            return response()->json([
                'success'=>true,
                'message'=> 'Game' .$id.' deleted'
            ],200);

        }catch(\Exception $exception){
            Log::error('Error delete game' . $exception->getMessage());
            return response()->json(
                [
                    'success'=> false,
                    'message'=> 'Error delete game'
                ],500);
        }
    }
}
