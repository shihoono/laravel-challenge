<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Biditem;
use App\User;
use App\Bidrequest;
use App\Bidinfo;
use App\Bidmessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $biditems = Biditem::orderBy('created_at', 'desc')->paginate(10);

        return view('auction.index', [
            'biditems' => $biditems,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $biditem = New Biditem;

        return view('auction.create', [
            'biditem' => $biditem,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'description' => 'required|max:1000',
            'endtime' => 'required|after:now',
        ]);

        if($request->user()->biditems()->create([
            'name' => $request->name,
            'description' => $request->description,
            'endtime' => $request->endtime,
        ]))
        {
            return redirect('/')->with('flash_success', '保存しました');
        }
        
        return redirect('/')->with('flash_error', '保存に失敗しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $biditem = Biditem::findOrFail($id);

        $user_id = $biditem->user_id;
        $user = User::findOrFail($user_id);

        $bidrequests = Bidrequest::where('biditem_id', $id)->orderBy('created_at', 'desc')->get();
        $new_bidinfo = New Bidinfo;

        $current_time = new Carbon('now');
        if($current_time > $biditem->endtime && $biditem->finished === 0){
            $biditem->finished = 1;
            $biditem->save();

            $new_bidinfo->biditem_id = $id;

            $top_bidrequest = Bidrequest::where('biditem_id', $id)->orderBy('price', 'desc')->first();

            if(!empty($top_bidrequest)){
                $new_bidinfo->user_id = $top_bidrequest->user_id;
                $new_bidinfo->price = $top_bidrequest->price;
                $new_bidinfo->save();
            }
        }

        $bidinfo = Bidinfo::where('biditem_id', $id)->get();

        return view('auction.show', [
            'biditem' => $biditem,
            'user' => $user,
            'bidrequests' => $bidrequests,
            'bidinfo' => $bidinfo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function bidForm($id)
    {
        $bidrequest = New Bidrequest;
        $biditem = Biditem::findOrFail($id);

        return view('auction.bidform', [
            'bidrequest' => $bidrequest,
            'biditem' => $biditem,
        ]);
    }

    public function bid(Request $request)
    {
        $bidrequest = New Bidrequest;

        $user = \Auth::user();

        $biditem = Biditem::where('id', $request->biditem_id)->first();
        if($biditem->finished === 0){
        
            $request->validate([
                'price' => 'required|integer|gte:1|lte:1000000000',
            ]);

            $bidrequest->user_id = $user->id;
            $bidrequest->biditem_id = $request->biditem_id;
            $bidrequest->price = $request->price;
            if($bidrequest->save()){
                return back()->with('flash_success', '入札しました'); 
            }
        }
        return back()->with('flash_error', 'もう一度やり直してください');
    }

    public function msgForm($id)
    {
        $bidmessage = New m;
        $bidinfo = Bidinfo::findOrFail($id);

        $messages = Bidmessage::where('bidinfo_id', $id)->orderBy('created_at', 'desc')->paginate(10);

        return view('auction.msgform', [
            'bidmessage' => $bidmessage,
            'bidinfo' => $bidinfo,
            'messages' => $messages,
        ]);
    }

    public function msg(Request $request)
    {
        $bidmessage = New Bidmessage;

        $user = \Auth::user();
        
        $request->validate([
            'message' => 'required|string',
        ]);
        
        $bidmessage->user_id = $user->id;
        $bidmessage->bidinfo_id = $request->bidinfo_id;
        $bidmessage->message = $request->message;
        if($bidmessage->save()){
            return back()->with('flash_success', 'メッセージを投稿しました');
        }
        
        return back()->with('flash_error', 'もう一度やり直してください');
    }

    public function home()
    {
        $user = \Auth::user();
        $bidinfo = Bidinfo::where('user_id', $user->id)->paginate();

        return view('auction.home',[
            'bidinfo' => $bidinfo,
            'user' => $user,
        ]);
    }

    public function home2()
    {
        $user = \Auth::user();
        $biditems = Biditem::where('user_id', $user->id)->with('bidinfo')->paginate();

        return view('auction.home2',[
            'biditems' => $biditems,
            'user' => $user,
        ]);
    }
}
