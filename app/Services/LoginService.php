<?php


namespace App\Services;


use Particle\Validator\Rule\Email;
use Particle\Validator\Rule\NotEmpty;
use Particle\Validator\Validator;

class LoginService
{
    /**
     * Return validation result
     *
     * @return \Particle\Validator\ValidationResult
     */
    public function checkInputForLogin()
    {
        $validator = $this->getValidatorForLogin();
        $result = $validator->validate($_POST);

        return $result;
    }

    /**
     * Get Validator for a new login
     *
     * @return Validator
     */
    private function getValidatorForLogin() {
        $validator = new Validator;

        $validator->required('email')->email();

        $validator->overwriteMessages([
            'email' => [
                Email::INVALID_FORMAT => 'Email неверен!',
                NotEmpty::EMPTY_VALUE => 'Поле с email не должно быть пустым!'
            ],
        ]);

        return $validator;
    }
}