<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Card;

class BingoController extends Controller
{

    protected $bingo;

    function __construct (){

        if (Storage::disk('local')->exists(config('app.DATA_FILE'))) {
            $this->bingo = json_decode(Storage::get(config('app.DATA_FILE')), true);
        }

        if(!$this->bingo){
            $this->bingo['calls'] = [];
            $this->bingo['cards'] = [];
        }
    }

    public function call(){
        if(count($this->bingo['calls']) >= config('app.MAX')){
            return response()->json(["call" => null, "calls" => $this->bingo['calls']], 200);
        }
        $call = $this->getCall();
        $this->bingo['calls'][] = $call;

        return $this->saveAndResponse(["call" => $call, "calls" => $this->bingo['calls']]);
    }

    public function takeCard(){
        $card = new Card(
            intervalBetweenColumns: config('app.INTERVAL_BETWWEEN_COLUMNS'), 
            rowLength: config('app.ROW_LENGTH')
        );
        $this->bingo['cards'][] = $card->getGrid();

        return $this->saveAndResponse(["cardNumber" => count($this->bingo['cards']), "card" => $card->getGrid()]);
    }

    public function checkCard(Request $request){
        if(!isset($this->bingo['cards'][$request->id - 1])) return response()->json(["message" => "card not set"], 400);

        $grid = $this->bingo['cards'][$request->id - 1];

        $card = new Card(
            intervalBetweenColumns: config('app.INTERVAL_BETWWEEN_COLUMNS'), 
            rowLength: config('app.ROW_LENGTH'),
            grid: $grid
        );

        $isWinner = $card->isWinner($this->bingo['calls']);

        return response()->json(["isWinner" => $isWinner, 'cardNumber' => $request->id, 'options' => $grid], 200);
    }

    public function checkAll(){

        if(!count($this->bingo['cards'])) return response()->json(["message" => "cards not set"], 400);

        $checkings = [];
        foreach($this->bingo['cards'] as $k => $grid){
            $card = new Card(
                intervalBetweenColumns: config('app.INTERVAL_BETWWEEN_COLUMNS'),
                rowLength: config('app.ROW_LENGTH'),
                grid: $grid
            );

            $isWinner = $card->isWinner($this->bingo['calls']);

            array_push($checkings, [
                "cardNumber" => ($k + 1),
                "winner" => $isWinner,
                "options" => $grid
            ]);
        }

        return response()->json(["checkings" => $checkings], 200);
    }

    public function reset(){
        $success = Storage::disk('local')->delete(config('app.DATA_FILE'));
        $message = $success ? 'game reset' : 'game already reset';
        return response()->json(["success" => $success, 'message' => $message], 200);
    }

    private function getCall(){
        while($call = random_int(config('app.MIN'), config('app.MAX'))){
            if(!in_array($call, $this->bingo['calls'])) return $call;
        }
    }

    private function saveAndResponse($response){
        Storage::disk('local')->put(config('app.DATA_FILE'), json_encode($this->bingo, true));
        return response()->json($response, 200);
    }
}
