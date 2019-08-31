<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use App\Reply;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new Reply());
    }

    /**
     * @throws ThrottleException
     */
    protected function failedAuthorization()
    {
        throw new ThrottleException('You are posting too frequently. Please take a break. :)');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required|spamfree',
        ];
    }

    /**
     * @param $thread
     * @return mixed
     * @throws \Exception
     */
    public function persist($thread)
    {
        if ($thread->locked) {
            throw new \Exception('Thread is locked');
        }

        return $thread->addReply(
            [
                'body' => \request('body'),
                'user_id' => auth()->id(),
            ]
        );
    }
}
