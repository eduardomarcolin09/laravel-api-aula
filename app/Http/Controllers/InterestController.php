<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInterestRequest;
use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    public function list(Request $request) {
        return Interest::paginate(10);
    }
    public function store(StoreInterestRequest $interest) {
        $newInterest = Interest::create($interest->all());

        if($newInterest) {
            return response()->json([
                'message' => 'Novo interesse criado com sucesso',
                'interest' => $newInterest
            ]);
        } else {
            return response()->json([
                'message' => 'Deu ruim. Te vira aí para descobrir o que aconteceu'
            ], 422);
        }
    }
}
