<?php

namespace App\Http\Requests\Admin;

use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogIndexRequest extends FormRequest
{
    const SOMETIMES_KEY = 'sometimes';
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
            'search' => self::SOMETIMES_KEY,
            'title' => self::SOMETIMES_KEY,
            'provider_id' => 'sometimes|exists:providers,unique_id',
            'status' => [self::SOMETIMES_KEY, Rule::in(Blog::getStatuses()), 'nullable'],
        ];
    }

    /**
     * Append route params
     *
     * @param  array $keys
     * @return array $data
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);

        if (!isset($data['sort'])) {
            $data['sort'] = 'title';
        }
        return $data;
    }
}
