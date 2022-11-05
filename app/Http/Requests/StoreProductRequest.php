<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreProductRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = false;

    /**
     * [failedValidation [Overriding the event validator for custom error response]]
     * @param  Validator $validator [description]
     * @return [object][object of various validation errors]
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 400));
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku' => 'required|unique:products|max:255',
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'categoryId' => 'required|exists:categories,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sku.required' => ':attribute is empty',
            'sku.unique' => ':attribute is unique',
            'sku.max' => ':attribute length must not more than 255 characters',
            'name.required' => ':attribute is empty',
            'name.max' => ':attribute length must not more than 255 characters',
            'price.required' => ':attribute is empty',
            'price.numeric' => ':attribute is integer',
            'price.min' => ':attribute must not negative',
            'stock.required' => ':attribute is empty',
            'stock.numeric' => ':attribute is integer',
            'stock.min' => ':attribute must not negative',
            'categoryId.required' => ':attribute is empty',
            'categoryId.exists' => ':attribute not found',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'categoryId' => 'category_id',
        ];
    }
}
