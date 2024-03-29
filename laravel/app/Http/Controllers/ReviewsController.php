<?php

namespace App\Http\Controllers;

use App\User;
use App\Biditem;
use App\Bidinfo;
use App\Review;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;

class ReviewsController extends Controller
{
    public function showReviewForm($id)
    {
        $review = New Review;
        $bidinfo = Bidinfo::findOrFail($id);
        $user = \Auth::user();

        $reviewed = Review::where([
            ['bidinfo_id', $id],
            ['reviewer_id', $user->id]
        ])->count();

        return view('reviews.showreviewform', [
            'review' => $review,
            'bidinfo' => $bidinfo,
            'user' => $user,
            'reviewed' => $reviewed,
        ]);
    }

    public function review(ReviewRequest $request)
    {
        $review = New Review;
        $user = \Auth::user();
        $bidinfo = Bidinfo::findOrFail($request->id);
        $biditem = Biditem::findOrFail($bidinfo->biditem_id);

        //評価済みかどうか
        $reviewed = Review::where([
            ['bidinfo_id', $bidinfo->id],
            ['reviewer_id', $user->id]
        ])->count();

        
        if($bidinfo->trading_status === 2){
            if($reviewed === 0){
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
                    session()->flash('flash_message', '評価しました');
                    return redirect('/');
                }
                session()->flash('flash_message', 'もう一度やり直してください');
                return back();
            } else {
                session()->flash('flash_message', '評価済みです');
                return back();
            }
        } else {
            session()->flash('flash_message', 'まだ取引が完了していません');
            return back();
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        $reviews = Review::where('reviewee_id', $id)->orderBy('created_at', 'desc')->get();

        $rateAvg = $this->getAvg($id);

        return view('reviews.show', [
            'user' => $user,
            'reviews' => $reviews,
            'rateAvg' => $rateAvg,
        ]);
    }

    public function getAvg($id)
    {
        $rate = Review::where('reviewee_id', $id)->select('rate')->get();
        $rateAvg = collect($rate)->avg('rate');

        return $rateAvg;
    }
}
