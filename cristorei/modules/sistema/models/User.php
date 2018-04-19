<?php
namespace app\modules\sistema\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property integer $estabelecimento_id
 * @property string $username
 * @property string $name
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $permite_acesso_externo
 * @property integer $data_ultimo_login
 * @property string $ip_ultimo_login
 * @property string $caminho_imagens
 * @property string $tipo
 * @property string $num_tel
 * @property string $num_cel
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const TIPO_SOMENTE_VISUALIZACAO = 'V';
    const TIPO_MEMBRO               = 'M';
    const TIPO_EDITOR               = 'E';
    const TIPO_ADMINISTRADOR        = 'A';
    const TIPO_TESOUREIRO           = 'F';
    const TIPO_MASTER               = 'master';

    const SCENARIO_INSERT = 'insert';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_UPDATE_PASS = 'update-password';
    const SCENARIO_MANTER_RESPONSAVEL = 'manter-responsavel';


    public $current_password;
    public $password;
    public $password_repeat;


    public function getIsMaster()
    {
        return ArrayHelper::isIn($this->username, \Yii::$app->params['masterUsers']);
    }

    public static function optsTipoUsuario()
    {
        return [
            self::TIPO_SOMENTE_VISUALIZACAO => 'Espectador',
            self::TIPO_EDITOR               => 'Editor',
            self::TIPO_MEMBRO               => 'Membro',
            self::TIPO_ADMINISTRADOR        => 'Administrador',
            self::TIPO_TESOUREIRO           => 'Tesoureiro',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app','Usuário'),
            'estabelecimento_id' => Yii::t('app','Estabelecimento'),
            'username' => Yii::t('app','E-mail'),
            'name' => Yii::t('app','Nome Completo'),
            'tipo' => Yii::t('app','Tipo de Usuário'),
            'status' => Yii::t('app','Ativo'),
            'permite_acesso_externo' => Yii::t('app','Permite Acesso Externo'),
            'data_ultimo_login' => Yii::t('app','Último Acesso'),
            'current_password' => Yii::t('app','Senha Atual'),
            'password' => Yii::t('app','Nova Senha'),
            'password_repeat' => Yii::t('app','Repete Senha'),
            'ip_ultimo_login' => Yii::t('app','Último IP'),            
            'caminho_imagens' => Yii::t('app','Caminho Imagens'),
            'num_tel' => Yii::t('app','Telefone'),
            'num_cel' => Yii::t('app','Telefone Celular'),
            'created_at' => Yii::t('app','Created At'),
            'updated_at' => Yii::t('app','Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app','Updated By'),
        ];
    }

    private function gerarInformacoesUsuarioResponsavel()
    {
        $this->password = Yii::$app->security->generateRandomString(10);
        $this->estabelecimento_id = Yii::$app->user->getEstabelecimentoId();
        $this->status = self::STATUS_ACTIVE;
        $this->tipo = self::TIPO_EDITOR;
    }


    public function beforeSave($insert)
    {
        if ($this->getIsNewRecord()) {
            $this->generateAuthKey();
        }

        if (empty($this->password)) {
            unset($this->password);
        } else {
            $this->setPassword($this->password);
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'unique', 'message' => Yii::t('app','Este usuário já encontra-se em uso.')],
            [['username','name'], 'string', 'min' => 2, 'max' => 255],
            ['username', 'email'],
            [['estabelecimento_id','username', 'name'], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['tipo','caminho_imagens'], 'safe'],
            [['password','password_repeat'], 'required', 'on' => self::SCENARIO_INSERT],
            [['password','password_repeat','current_password'], 'string', 'min' => 6],
            ['password_repeat','compare',  'compareAttribute' => 'password', 'on' => [self::SCENARIO_INSERT,self::SCENARIO_UPDATE,self::SCENARIO_UPDATE_PASS]],
            ['current_password', 'required', 'on' => [self::SCENARIO_UPDATE_PASS]],
            ['current_password', 'validaSenhaAtual','on' => [self::SCENARIO_UPDATE_PASS]],
            [['num_tel', 'num_cel'], 'string', 'max' => 15],
            [['num_tel'], 'required','on' => [self::SCENARIO_MANTER_RESPONSAVEL]],
        ];
    }

    function validaSenhaAtual($attribute, $params) {

        if (!Yii::$app->security->validatePassword($this->$attribute, $this->password_hash))
            $this->addError($attribute, Yii::t('app','Senha atual inválida!'));
    }


    public function obterDescricaoStatus()
    {
        switch ($this->status) {
            case 0:
                return Yii::t('app','Não');
                break;
            case 10:
                return Yii::t('app','Sim');
                break;
        }
        return "-";
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
//        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
        return static::find()
            ->where('username = :username', [':username' => $username])
            ->andWhere('status = :status',  [':status' => self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public function init()
    {
        if ($this->isNewRecord and $this->scenario == static::SCENARIO_INSERT) {
            $this->estabelecimento_id = Yii::$app->user->getEstabelecimentoId();
        }

        if ($this->isNewRecord and $this->scenario == static::SCENARIO_MANTER_RESPONSAVEL) {
            $this->estabelecimento_id = Yii::$app->user->getEstabelecimentoId();
            $this->password = Yii::$app->security->generateRandomString(10);
            $this->status = self::STATUS_ACTIVE;
            $this->tipo = self::TIPO_EDITOR;
        }

        parent::init();
    }

    public static function findLogUser($id) {
        if (empty($id)) {
            return null;
        }

        $user = static::findOne(['id' => $id]);

        if ($user) {
            return $user->name;
        } else {
            return null;
        }
    }
}
