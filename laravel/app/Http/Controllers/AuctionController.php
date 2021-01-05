<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateBiditemRequest;
use App\Http\Requests\AfterBidRequest;

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
    public function store(CreateBiditemRequest $request)
    {
        $biditem = New Biditem;
        $user = \Auth::user();
        
        $file = $request->file('picture_name');

        $biditem->user_id = $user->id;
        $biditem->name = $request->name;
        $biditem->description = $request->description;
        $biditem->picture_name = $request->picture_name;
        $biditem->endtime = $request->endtime;

        if($biditem->save())
        {
            $file_extension = $request->picture_name->getClientOriginalExtension();
            $lower_case_conversion = strtolower($file_extension);
            $picture_name = $biditem->id.'.'.$lower_case_conversion;
            $biditem->picture_name = $picture_name;
            $biditem->save();

            $file->storeAs('auction', $biditem->picture_name, ['disk' => 'public']);

            return redirect('/')->with('flash_success', ' 出品しました');
        }
        
        return redirect('/')->with('flash_error', 'もう一度やり直してください');
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

        $current_time = new Carbon('now');
        if($current_time > $biditem->endtime && $biditem->finished === 0){
            $new_bidinfo = New Bidinfo;
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
        $bidmessage = New Bidmessage;
        $bidinfo = Bidinfo::findOrFail($id);

        $user = \Auth::user();

        $messages = Bidmessage::where('bidinfo_id', $id)->orderBy('created_at', 'desc')->paginate(10);

        return view('auction.msgform', [
            'bidmessage' => $bidmessage,
            'bidinfo' => $bidinfo,
            'messages' => $messages,
            'user' => $user,
        ]);
    }

    public function msg(Request $request)
    {
        $bidmessage = New Bidmessage;

        $user = \Auth::user();
        
        $request->validate([
            'message' => 'required|string',
        ]);
        
        $bidinfo = Bidinfo::findOrFail($request->bidinfo_id);
        $biditem = Biditem::findOrFail($bidinfo->biditem_id);

        if($user->id === $bidinfo->user_id || $user->id === $biditem->user_id){
            $bidmessage->user_id = $user->id;
            $bidmessage->bidinfo_id = $request->bidinfo_id;
            $bidmessage->message = $request->message;
        
            if($bidmessage->save()){
                return back()->with('flash_success', 'メッセージを投稿しました');
            }
        }
        return back()->with('flash_error', '権限がないか、もしくはもう一度やり直してください');
    }

    public function afterBidForm($id)
    {
        $bidinfo = Bidinfo::findOrFail($id);
        $biditem = Biditem::findOrFail($bidinfo->biditem_id);
        $user = \Auth::user();

        return view('auction.afterbidform', [
            'bidinfo' => $bidinfo,
            'biditem' => $biditem,
            'user' => $user,
        ]);
    }

    public function afterbid(Request $request)
    {
        $bidinfo = Bidinfo::findOrFail($request->id);
        $user = \Auth::user();

        if($bidinfo->trading_status === 0 && is_null($bidinfo->bidder_name)){
            if(isset($_POST['bidder_info'])){
                if($bidinfo->user_id === $user->id){
                    $request->validate([
                        'bidder_name' => 'required|string|max:100',
                        'bidder_address' => 'required|string|max:255',
                        'bidder_phone_number' => 'required|string|max:13',
                    ]);

                    $bidinfo->bidder_name = $request->bidder_name;
                    $bidinfo->bidder_address = $request->bidder_address;
                    $bidinfo->bidder_phone_number = $request->bidder_phone_number;
                    if($bidinfo->save()){
                        return back()->with('flash_success', '発送先情報を送信しました');
                    }
                }
                return back()->with('flash_error', 'もう一度やり直してください');
            }
        }

        if($bidinfo->trading_status === 0 && !is_null($bidinfo->bidder_name))
        {
            if(isset($_POST['sent'])){
                $bidinfo->trading_status = 1;
                if($bidinfo->save()){
                    return back()->with('flash_success', '発送連絡が完了しました');
                }
            }
        }
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
