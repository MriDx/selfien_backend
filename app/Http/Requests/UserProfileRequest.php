<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserProfileRequest extends FormRequest
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
	    'update' => ['required', 'string'], // is update request or not
            'gender' => ['required', Rule::in(config('constants.enums.gender'))],
            'fcm_registration_id' => ['required'],
            'notification_on_like' => ['required'],
            'notification_on_dislike' => ['required'],
            'notification_on_comment' => ['required'],
            'image' => ['string']
        ];
    }
}
