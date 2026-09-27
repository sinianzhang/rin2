<?php

namespace App\Http\Requests;

use App\Enums\NotificationType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNotificationPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // The application has no login yet.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(NotificationType::class)],
            'text' => ['required', 'string', 'max:5000'],
            'expires_at' => ['required', 'date', 'after:now'],
            // "all" or the id of a single user.
            'recipient' => [
                'required',
                $this->input('recipient') === 'all' ? 'in:all' : 'exists:users,id',
            ],
        ];
    }
}
