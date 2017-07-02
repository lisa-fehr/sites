<?php

namespace Warfehr\OmegaOledMsg;

use Illuminate\Database\Eloquent\Model;
use Validator;

class MsgModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'oled_msg';

    /**
     * Errors on this model.
     * @var MessageBag
     */
    private $errors;
    
    /**
     * Fillable fields
     * @var array
     */
    protected $fillable = [
      'author',
      'content',
      'columns'
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'author' => 'required|max:135|regex:/(^[A-Za-z0-9 \'",-_@#]+$)+/',
            'content' => 'required|string|regex:/^[0-1]+/',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'author.regex' => 'The :attribute field may only contain: alphanumeric characters, quotes, commas, dashes and underscores, @ and #.',
            'content.string' => 'The :attribute field is required.',
        ];
    }

    /**
     * Get the nice names of the fields.
     *
     * @return array
     */
    public function attributes() {

        return [
            'content' => 'block'
        ];
    }

    /**
     * Check that the data for the model is valid before saving.
     * @param  array $data Request input
     * @return bool
     */
    public function validate(array $data)
    {
        // make a new validator object
        $validator = Validator::make($data, $this->rules(), $this->messages(), $this->attributes());

        // check for failure
        if ($validator->fails())
        {
            // set errors and return false
            $this->errors = $validator->messages();
            return false;
        }

        // validation pass
        return true;
    }

    /**
     * Return the errors on this model.
     * @return MessageBag
     */
    public function errors()
    {
        return $this->errors;
    }


}
