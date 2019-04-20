<?php 

namespace App\Services\Validation;

use Illuminate\Validation\Validator as IlluminateValidator;
use Illuminate\Support\Facades\Hash;    
class ValidatorExtended extends IlluminateValidator {

   

    public function __construct( $translator, $data, $rules, $messages = array(), $customAttributes = array() ) {
        parent::__construct( $translator, $data, $rules, $messages, $customAttributes );

   //     $this->_set_custom_stuff();
    }

    /**
     * Setup any customizations etc
     *
     * @return void
     */
    protected function _set_custom_stuff() {
        //setup our custom error messages
       // $this->setCustomMessages( $this->_custom_messages );
    }

    /**
     * Allow only alphabets, spaces and dashes (hyphens and underscores)
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateAlphaDashSpaces( $attribute, $value ) {
        return (bool) preg_match( "/^[A-Za-z\s-_]+$/", $value );
    }

    /**
     * Allow only alphabets, numbers, and spaces
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateAlphaNumSpaces( $attribute, $value ) {

        return (bool) preg_match( "/^[A-Za-z0-9\s]+$/", $value );
    }   

     /**
     * Allow Password should contain at least one lowercase letter,one uppercase letter,one number and one special character and minimum 8 characater limit.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateValidPassword( $attribute, $value ) {

        return (bool) preg_match( "/S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S/", $value );
    }  

     /**
     * Allow Password should contain at least one lowercase letter,one uppercase letter,one number and one special character and minimum 8 characater limit.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    protected function validateOldPasswordCheck( $attribute, $value,$customAttributes ) {
                 
        return (bool) Hash::check($value, $customAttributes[0]);
    }
    protected function validatePhone($attribute, $value, $parameters)
    {
        // Phone number should start with number 0-9 and can have minus, plus
        // and braces.
        return preg_match("/^([0-9\s\-\+\(\)]*)$/", $value);
    }
}   
?>