<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class AdvertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category' => $this->category->name,
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'isAuthorRequest' => ($this->user_id === Auth::id()),
            'image' => $this->pictures->isNotEmpty()
                ? asset('storage/' . $this->pictures->first()->path)
                : null,
        ];



        if ($request->route()->getName() === 'moderate_adverts.show') {
            $data['pictures'] = $this->convertPicturesInURL($this->pictures);
            //$data['dialogues'] = $this->dialogues;
        }
        if ($request->route()->getName() === 'adverts.show') {
            $data['pictures'] = $this->convertPicturesInURL($this->pictures);
        }


        if ($request->user() && $request->user()->role->name === 'moderator') {
            $data['is_active'] = $this->is_active;
        }

        return $data;

    }

    private function convertPicturesInURL($pictures) {
        $picArray = [];
        foreach ($pictures as $picture) {
            $picArray[] = ['url' => asset('storage/' . $picture->path)];
        }
        return $picArray;
    }

}
