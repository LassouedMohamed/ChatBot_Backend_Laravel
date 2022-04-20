<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Resources\ConversationResource;
use App\Models\Message;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $conversations = Conversation::where('user_id' ,Auth::id())->orWhere('second_user_id',Auth::id())->get();

        $count = count($conversations);
        
        for ($i = 0; $i < $count; $i++) {
			for ($j = $i + 1; $j < $count; $j++) {
				if (isset($conversations[$i]->messages->last()->id) && isset($conversations[$j]->messages->last()->id) && $conversations[$i]->messages->last()->id < $conversations[$j]->messages->last()->id){
					$temp = $conversations[$i];
					$conversations[$i] = $conversations[$j];
					$conversations[$j] = $temp;
				}
			}
		}    
        return ConversationResource::collection($conversations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function makeConversationAsReaded (Request $request){
        $request->validate([
            'conversation_id' => 'required',
        ]);
        $conversation = Conversation::findOrFail($request['conversation_id']);

        foreach( $conversation->messages as $message){
            $message->update(['read' => true]);
        }
        return response(['success',200]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()){
            $request->validate([
                'user_id'=>'required',
                'message' =>'required'
            ]);
            $conversation = Conversation::create([
                'user_id' => Auth::id(),
                'second_user_id' => $request['user_id']
            ]);
            Message::create([
                'user_id' => Auth::id(),
                'body' => $request['message'],
                'conversation_id' =>$conversation->id,
                'read' => false,
            ]);

            return new ConversationResource($conversation);
        }
        return response([ 'message' => 'error'],403);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversation $conversation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversation $conversation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversation $conversation)
    {
        //
    }
}
