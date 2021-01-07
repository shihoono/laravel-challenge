<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateBiditemRequest;

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
            $fileExtension = $request->picture_name->getClientOriginalExtension();
            $lowerCaseConversion = strtolower($fileExtension);
            $pictureName = $biditem->id.'.'.$lowerCaseConversion;
            $biditem->picture_name = $pictureName;
            $biditem->save();

            $file->storeAs('auction', $biditem->picture_name, ['disk' => 'public']);

            session()->flash('flash_message', ' 出品しました');
            return redirect('/');
        }
        
        session()->flash('flash_message', 'もう一度やり直してください');
        return redirect('/');
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

        $userId = $biditem->user_id;
        $user = User::findOrFail($userId);

        $bidrequests = Bidrequest::where('biditem_id', $id)->orderBy('created_at', 'desc')->get();

        $currentTime = new Carbon('now');
        if($currentTime > $biditem->endtime && $biditem->finished === 0){
            $newBidinfo = New Bidinfo;
            $biditem->finished = 1;
            $biditem->save();

            $newBidinfo->biditem_id = $id;

            $topBidrequest = Bidrequest::where('biditem_id', $id)->orderBy('price', 'desc')->first();

            if(!empty($topBidrequest)){
                $newBidinfo->user_id = $topBidrequest->user_id;
                $newBidinfo->price = $topBidrequest->price;
                $newBidinfo->save();
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

    public function showBidForm($id)
    {
        $bidrequest = New Bidrequest;
        $biditem = Biditem::findOrFail($id);

        return view('auction.showbidform', [
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
            if($biditem->user_id !== $user->id){
        
                $request->validate([
                    'price' => 'required|integer|gte:1|lte:1000000000',
                ]);

                $bidrequest->user_id = $user->id;
                $bidrequest->biditem_id = $request->biditem_id;
                $bidrequest->price = $request->price;
                if($bidrequest->save()){
                    session()->flash('flash_message', '入札しました'); 
                    return back();
                }
            }
            session()->flash('flash_message', 'ご自身の商品には入札できません。');
            return back();
        }
        return back()->with('flash_message', 'もう一度やり直してください');
    }

    public function showMsgForm($id)
    {
        $bidmessage = New Bidmessage;
        $bidinfo = Bidinfo::findOrFail($id);

        $user = \Auth::user();

        $messages = Bidmessage::where('bidinfo_id', $id)->orderBy('created_at', 'desc')->paginate(10);

        return view('auction.showmsgform', [
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
            'message' => 'required|string|max:1000',
        ]);
        
        $bidinfo = Bidinfo::findOrFail($request->bidinfo_id);
        $biditem = Biditem::findOrFail($bidinfo->biditem_id);

        if($user->id === $bidinfo->user_id || $user->id === $biditem->user_id){
            $bidmessage->user_id = $user->id;
            $bidmessage->bidinfo_id = $request->bidinfo_id;
            $bidmessage->message = $request->message;
        
            if($bidmessage->save()){
                session()->flash('flash_message', 'メッセージを投稿しました');
                return back();
            }
        }
        session()->flash('flash_message', '権限がないか、もしくはもう一度やり直してください');
        return back();
    }

    public function showAfterBidForm($id)
    {
        $bidinfo = Bidinfo::findOrFail($id);
        $biditem = Biditem::findOrFail($bidinfo->biditem_id);
        $user = \Auth::user();

        return view('auction.showafterbidform', [
            'bidinfo' => $bidinfo,
            'biditem' => $biditem,
            'user' => $user,
        ]);
    }

    public function afterbid(Request $request)
    {
        $bidinfo = Bidinfo::findOrFail($request->id);
        $biditem = Biditem::findOrFail($bidinfo->biditem_id);
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
                        session()->flash('flash_message', '発送先情報を送信しました');
                        return back();
                    }
                }
                session()->flash('flash_message', 'もう一度やり直してください');
                return back();
            }
        }

        if($bidinfo->trading_status === 0 && !is_null($bidinfo->bidder_name))
        {
            if(isset($_POST['sent'])){
                if($biditem->user_id === $user->id){
                    $bidinfo->trading_status = 1;
                    if($bidinfo->save()){
                        session()->flash('flash_message', '発送連絡が完了しました');
                        return back();
                    }
                }
                session()->flash('flash_message', 'もう一度やり直してください');
                return back();
            }
        }

        if($bidinfo->trading_status === 1 && !is_null($bidinfo->bidder_name))
        {
            if(isset($_POST['received'])){
                if($bidinfo->user_id === $user->id){
                    $bidinfo->trading_status = 2;
                    if($bidinfo->save()){
                        session()->flash('flash_message', '受取連絡が完了しました');
                        return back();
                    }
                }
                session()->flash('flash_message', 'もう一度やり直してください');
                return back();
            }
        }
    }

    public function home()
    {
        $user = \Auth::user();
        $bidinfo = Bidinfo::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate();

        return view('auction.home',[
            'bidinfo' => $bidinfo,
            'user' => $user,
        ]);
    }

    public function home2()
    {
        $user = \Auth::user();
        $biditems = Biditem::where('user_id', $user->id)->with('bidinfo')->orderBy('created_at', 'desc')->paginate();

        return view('auction.home2',[
            'biditems' => $biditems,
            'user' => $user,
        ]);
    }
}
