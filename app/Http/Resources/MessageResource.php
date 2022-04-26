<?php

namespace App\Http\Resources;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;
		$data['body'] = $this->body;
		$data['read'] = $this->read;
		$data['user_id'] = $this->user_id;
		$data['conversation_id'] = $this->conversation_id;
		$data['created_at'] = Carbon::parse($this->created_at)->toDateTimeString();
        $data['updated_at'] = Carbon::parse($this->created_at)->toDateTimeString();
		return $data;
    }
}
