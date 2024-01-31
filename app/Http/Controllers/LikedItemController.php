<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\LikedItem;
use Illuminate\Http\Request;

class LikedItemController extends Controller
{
    public function likeCard(Request $request, $card_id)
    {
        $user_id = $request->user()->id;
        //check if it has been liked before, if so, unlike it, else like it

        $likedCard = LikedItem::where([
            'user_id' => $user_id,
            'item_type' => 'card',
            'item_id' => $card_id
        ])->first();

        if ($likedCard) {
            $unlike = $likedCard->delete();
            $targetCard = Card::find($card_id);
            if ($targetCard->like_count !== 0) {
                $targetCard->like_count -= 1;
                $targetCard->save();
            }

            return response([
                'status' => 'success',
                'message' => 'unliked'
            ], 200);
        } else {
            $like = LikedItem::create([
                'user_id' => $user_id,
                'item_type' => 'card',
                'item_id' => $card_id
            ]);

            $targetCard = Card::find($card_id);
            $targetCard->like_count += 1;
            $targetCard->save();

            return response([
                'status' => 'success',
                'message' => 'liked'
            ], 200);
        }
    }
}
