<?php

namespace app\modules\sistema\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            ['username', 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app','Nome de Usuário (e-mail)'),
            'password' => Yii::t('app','Senha'),
            'rememberMe' => Yii::t('app','Lembrar meus dados de login')
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Nome de usuário ou senha incorretos.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {

            $user = $this->getUser();
            $user->data_ultimo_login = time();
            $user->ip_ultimo_login   = Yii::$app->request->userIP;
            $user->save(false,['ip_ultimo_login','data_ultimo_login']);

            if (Yii::$app->security->validatePassword('123456', $user->password_hash)) {
                $url_senha = Html::a(Yii::t('app','clicando aqui'), ['/sistema/user/update-password','id'=> $user->id]);
                Yii::$app->session->setFlash('warning', Yii::t('app', "Você está usando a senha padrão '123456'! Considere mudar sua senha").' '.$url_senha.'.');
            }
            
            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
