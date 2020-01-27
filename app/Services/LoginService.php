<?php


namespace App\Services;


use App\Session;
use Particle\Validator\Rule\NotEmpty;
use Particle\Validator\Rule\Required;
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
    private function getValidatorForLogin()
    {
        $validator = new Validator;

        $validator->required('login');
        $validator->required('password');

        $validator->overwriteMessages([
            'login'    => [
                NotEmpty::EMPTY_VALUE => 'Запоните поле с логином!'
            ],
            'password' => [
                Required::NON_EXISTENT_KEY => 'Введите пароль!',
            ],
        ]);

        return $validator;
    }

    /**
     * Login user
     *
     * @param $user
     * @return bool
     */
    public function login($user)
    {
        $isAdmin = $this->isAdmin($user);
        if (!$isAdmin) {
            return false;
        }

        $session = Session::getInstance();
        $session->admin = true;

        return true;
    }

    /**
     * Logout
     */
    public function logout()
    {
        $session = Session::getInstance();
        unset($session->admin);
    }

    private function isAdmin($user)
    {
        $admin = [
            'login'    => 'admin',
            'password' => '123'
        ];

        $sameLogin = (mb_strtolower($user['login']) == mb_strtolower($admin['login']));
        $samePassword =  ($user['password'] == $admin['password']);

        return $sameLogin && $samePassword;
    }
}