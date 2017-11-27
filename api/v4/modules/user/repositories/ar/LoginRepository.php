<?php

namespace api\v4\modules\user\repositories\ar;

use api\v4\modules\user\entities\LoginEntity;
use api\v4\modules\user\helpers\LoginEntityFactory;
use api\v4\modules\user\models\User;
use common\ddd\repositories\ActiveArRepository;
use Yii;
use yii\helpers\ArrayHelper;
use api\v4\modules\user\interfaces\repositories\LoginInterface;
use yii\web\NotFoundHttpException;

class LoginRepository extends ActiveArRepository implements LoginInterface
{

    protected $modelClass = 'api\v4\modules\user\models\User';

    public function isExistsByLogin($login)
    {
        return $this->isExists(['login' => $login]);
    }

    public function oneByLogin($login)
    {
        try {
            $model = $this->oneModelByCondition(['login' => $login]);
        } catch (NotFoundHttpException $e) {
            return [];
        }
        return $this->forgeEntity($model);
    }

    public function oneByToken($token, $type = null)
    {
        $model = $this->oneModelByCondition(['token' => $token]);
        return $this->forgeEntity($model);
    }

    public function fieldAlias()
    {
        return [
            'name' => 'username',
            'token' => 'auth_key',
            'creation_date' => 'created_at',
        ];
    }

    public function create($login, $password, $email, $role, $parent = '') {


        $request = $this->insert($entity);

        $request->send();
    }

    public function forgeEntity($user, $class = null)
    {
        if (empty($user)) {
            return null;
        }
        $user = ArrayHelper::toArray($user);
        $user['roles'] = explode(',', $user['role']);
        $user = $this->alias->decode($user);
        return LoginEntityFactory::forgeLoginEntity($user);
    }

    public function getBalance($login)
    {
        // TODO: Implement getBalance() method.
    }
}