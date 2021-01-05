<?php

namespace App\Http\Controllers;

use App\User;
use App\Biditem;
use App\Bidinfo;
use App\Review;

use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function reviewForm($id)
    {
        $review = New Review;
        $bidinfo = Bidinfo::findOrFail($id);

        return view('reviews.reviewform', [
            'review' => $review,
            'bidinfo' => $bidinfo
        ]);
    }

    public function review(Request $request)
    {
        $review = New Review;
        $user = \Auth::user();
        $bidinfo = Bidinfo::findOrFail($request->id);
        $biditem = Biditem::findOrFail($bidinfo->biditem_id);

        if($bidinfo->trading_status === 2){
            $review->bidinfo_id = $request->id;
            $review->reviewer_id = $user->id;
            
            if($bidinfo->user_id === $user->id){
                $review->reviewee_id = $biditem->user_id;
            }
            if($biditem->user_id === $user->id){
                $review->reviewee_id = $bidinfo->user_id;
            }

            $review->rate = $request->rate;
            $review->comment = $request->comment;
            if($review->save()){
                return redirect('/')->with('flash_success', '評価しました');
            }
        } else {
            return back()->with('flash_error', 'まだ取引が完了していません');
        }
    }
}
