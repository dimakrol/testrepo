<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'impossible_video_id' => 'required',
            'video' => 'required|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:200000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096'
        ];
    }
}
