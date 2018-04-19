<?php
namespace app\modules\sistema\models;

use app\modules\sistema\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $password_repeat;

    /**
     * @var \app\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException(Yii::t('app','Password reset token cannot be blank.'));
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException(Yii::t('app','Wrong password reset token.'));
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','password_repeat'], 'required'],
            [['password','password_repeat'], 'string', 'min' => 6],
            ['password_repeat','compare',  'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
          'password'=> 'Senha',
          'password_repeat'=> Yii::t('app','Repetir Senha'),
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
