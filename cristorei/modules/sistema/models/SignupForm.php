<?php
namespace app\modules\sistema\models;

use app\modules\sistema\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $name;
    public $email;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username','name'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\modules\sistema\models\User', 'message' => Yii::t('app','Este nome de usuário já está em uso.')],
            [['username','name'], 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\modules\sistema\models\User', 'message' => Yii::t('app','Este e-mail já está em uso.')],

            [['password','password_repeat'], 'required'],
            [['password','password_repeat'], 'string', 'min' => 6],
            ['password_repeat','compare',  'compareAttribute' => 'password']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app','Nome de Usuário'),
            'name' => Yii::t('app','Nome Completo'),
            'email'   => Yii::t('app','E-mail'),
            'password' => Yii::t('app','Senha'),
            'password_repeat' => Yii::t('app','Repetir a Senha'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
   public function signup()
   {
       if ($this->validate()) {
           $user = new User();
           $user->username = $this->username;
           $user->name     = $this->name;
           $user->email    = $this->email;
           $user->status   = User::STATUS_DELETED;        
           $user->setPassword($this->password);
           $user->generateAuthKey();
           if ($user->save()) {

              // \Yii::$app->mailer->compose(['html' => 'novoUsuario-html', 'text' => 'novoUsuario-text'], ['user' => $user])
              //      ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
              //      ->setTo(\Yii::$app->params['adminEmail'])
              //      ->setSubject('[' . \Yii::$app->name . '] '.Yii::t('app','Usuário') . '#' . $user->name .'#'.Yii::t('app','aguardando aprovação'))
              //      ->send();

               return $user;
           }
       }

       return null;
   }
}
