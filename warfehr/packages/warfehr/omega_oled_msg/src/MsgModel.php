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
      'columns',
      'image'
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
     * Add onto the existing save method to force validation before save.
     * @param  array $options
     * @return boolean
     */
    public function save(array $options = array())
    {
        // make a new validator object
        $validator = Validator::make([
                'content' => $this->content,
                'author' => $this->author,
            ],
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );

        // check for failure
        if ($validator->fails())
        {
            // set errors and return false
            $this->errors = $validator->messages();
            return false;
        }

        parent::save();

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

    /**
     * Indicate that something went wrong
     * @return boolean
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }


}
