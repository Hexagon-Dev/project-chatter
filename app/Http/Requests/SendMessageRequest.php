<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property int $project_id
 * @property string $chat_type
 * @property int $chat_user_id
 * @property string $msg_content
 */
class SendMessageRequest extends FormRequest
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
            'msg_content' => 'required',
            'chat_user_id' => 'numeric',
            'chat_type' => 'required',
            'project_id' => 'required',
        ];
    }
}
