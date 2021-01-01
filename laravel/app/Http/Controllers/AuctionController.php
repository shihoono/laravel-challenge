<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Biditem;
use App\User;
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

        $request->user()->biditems()->create([
            'name' => $request->name,
            'description' => $request->description,
            'endtime' => $request->endtime,
        ]);

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

        $user_id = $biditem->user_id;
        $user = User::findOrFail($user_id);

        $current_time = new Carbon('now');
        if($current_time > $biditem->endtime){
            $biditem->finished = 1;
            $biditem->save();
        }

        return view('auction.show', [
            'biditem' => $biditem,
            'user' => $user,
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

    public function home2()
    {
        $user = \Auth::user();
        $biditems = Biditem::find($user->id)->paginate(10);

        return view('auction.home2',[
            'biditems' => $biditems,
            'user' => $user,
        ]);
    }
}
