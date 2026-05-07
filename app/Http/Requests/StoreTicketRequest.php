<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'campus_id' => 'required|exists:campuses,id',
            'category_id' => 'required|exists:categories,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'priority' => 'required|in:low,medium,high,urgent',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'Please provide a subject for your concern.',
            'description.min' => 'Please provide more details (at least 20 characters).',
            'attachments.*.max' => 'Each file must not exceed 5MB.',
        ];
    }
}
