<?php

namespace App\Models;

use App\Helpers\SessionHelper;
use Carbon\Carbon;
use App\Events\SavedUserEvent;
use App\Events\SavingUserEvent;
use App\Events\SendEmailEvent;
use App\Events\SendPasswordEvent;
use App\Events\ValidatingUserEvent;
use App\Exceptions\ConfirmEmailException;
use App\Exceptions\DeletedAccountException;
use App\Helpers\Consts;
use App\Exceptions\NotFoundEmailException;
use Egal\Auth\Tokens\UserMasterRefreshToken;
use Egal\Auth\Tokens\UserMasterToken;
use Egal\Auth\Tokens\UserServiceToken;
use Egal\Core\Session\Session;
use Egal\AuthServiceDependencies\{
    Exceptions\LoginException,
    Exceptions\UserNotIdentifiedException,
    Models\User as BaseUser
};
use Exception;
use Illuminate\Database\Eloquent\{
    Casts\Attribute,
    Factories\HasFactory,
    Relations\BelongsToMany
};
use Illuminate\Support\Collection;
use Sixsad\Helpers\MicroserviceValidator;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

/**
 * @property $id            {@property-type field}  {@primary-key}
 * @property string $email         {@property-type field} {@validation-rule required|email|email_len}
 * @property string $password      {@property-type field} {@validation-rule required|string|password_regex|min:6|max:32}
 * @property string $role          {@property-type fake-field} {@validation-rule required|enum:user,psychologist}
 * @property string $old_password   {@property-type fake-field} {@validation-rule required|string}
 * @property string $new_password   {@property-type fake-field} {@validation-rule required|string|min:6|max:32|password_regex}
 * @property Carbon $created_at    {@property-type field}
 * @property Carbon $updated_at    {@property-type field}
 *
 * @property Collection $roles          {@property-type relation}
 * @property Collection $permissions    {@property-type relation}
 *
 * @action register                     {@statuses-access guest}
 * @action resendingCode                {@statuses-access guest}
 * @action login                        {@statuses-access guest}
 * @action loginToService               {@statuses-access guest}
 * @action refreshUserMasterToken       {@statuses-access guest}
 * @action passwordRecovery             {@statuses-access guest}
 * @action acceptPassword               {@statuses-access guest}
 * @action getItems                     {@services-access core}
 * @action updatePassword               {@statuses-access logged}
 * @action changeUserRole               {@services-access core}
 */
class User extends BaseUser
{

    use HasFactory;
    use HasRelationships;

    public $incrementing = false;

    protected $hidden = [
        'password',
    ];

    protected $fillable = [
        "email",
        "password",
        "id",
        "role",
    ];

    protected $guarder = [
        'created_at',
        'updated_at',
    ];

    protected $dispatchesEvents = [
        "validating" => ValidatingUserEvent::class,
        'saving' => SavingUserEvent::class,
        'saved' => SavedUserEvent::class,
    ];

    public static function actionRegister(array $attributes): array
    {
        MicroserviceValidator::validate($attributes, [
            "password" => "required|string|password_regex|min:6|max:32"
        ]);

        return self::actionCreate($attributes);
    }

    public static function actionPasswordRecovery(array $attributes): string
    {
        MicroserviceValidator::validate($attributes, [
            "email" => "required|email|exists:users"
        ]);

        $user = self::where("email", $attributes['email'])->first();

        event(new SendPasswordEvent($user, "password"));

        return "Code sent";
    }

    public static function actionAcceptPassword(array $attributes): string
    {
        $type = Consts::TYPE_PASSWORD;

        MicroserviceValidator::validate($attributes, [
            "password" => "required|string|password_regex|min:6|max:32",
            "code" => "required|check_code:$type",
        ]);

        $emailCode = EmailCode::where([
            "code" => $attributes['code'],
            "type" => $type,
        ])->first();

        $user = $emailCode->getAttribute("user_id");

        $emailCode->delete();

        User::where("id", "=", $user)->update([
            "password" => password_hash($attributes['password'], PASSWORD_BCRYPT)
        ]);

        return "Password updated";
    }

    public static function actionResendingCode(array $attributes): string
    {
        MicroserviceValidator::validate($attributes, [
            "email" => "required|email|exists:users"
        ]);

        $user = self::where("email", $attributes['email'])->first();

        if (!$user) {
            throw new NotFoundEmailException();
        }

        event(new SendEmailEvent($user, "email"));

        return "Code resended";
    }

    public static function actionUpdatePassword(array $attributes): string
    {
        MicroserviceValidator::validate($attributes, [
            "new_password" => "required|string|password_regex|min:6|max:32",
            "old_password" => "required"
        ]);

        $userId = SessionHelper::getUUID();

        $user = self::where(["id" => $userId])->first();

        if (!$user || !password_verify($attributes['old_password'], $user->getAttribute('password'))) {
            throw new Exception("Password dont match!", 405);
        }

        self::where("id", "=", $userId)->update([
            "password" => password_hash($attributes['new_password'], PASSWORD_BCRYPT)
        ]);

        return "Password updated";
    }

    public static function actionLogin(string $email, string $password): array
    {
        /** @var BaseUser $user */
        $user = self::query()
            ->where('email', '=', $email)
            ->first();

        if (!$user || !password_verify($password, $user->getAttribute('password'))) {
            throw new LoginException('Incorrect Email or password!');
        }

        if ($user->getAttribute("status") === "expected") {
            throw new ConfirmEmailException();
        }

        if ($user->getAttribute("status") === "blocked") {
            throw new DeletedAccountException();
        }

        $umt = new UserMasterToken();
        $umt->setSigningKey(config('app.service_key'));
        $umt->setAuthIdentification($user->getAuthIdentifier());

        $umrt = new UserMasterRefreshToken();
        $umrt->setSigningKey(config('app.service_key'));
        $umrt->setAuthIdentification($user->getAuthIdentifier());

        return [
            'user_master_token' => $umt->generateJWT(),
            'user_master_refresh_token' => $umrt->generateJWT()
        ];
    }


    public static function actionChangeUserRole(array $attributes): string
    {
        MicroserviceValidator::validate($attributes, [
            "role" => "required|enum:blocked_psychologist,psychologist|exists:roles,id",
            "id" => "required|uuid|exists:users,id"
        ]);

        $role = $attributes['role'];
        $id = $attributes['id'];

        $user = self::where("id", $id)->first();

        $user->roles()->detach();
        $user->roles()->attach($role);

        return "User changed";
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function permissions(): HasManyDeep
    {
        return $this->hasManyDeep(
            Permission::class,
            [UserRole::class, Role::class, RolePermission::class],
            ['user_id', 'id', 'role_id', 'id'],
            ['id', 'role_id', 'id', 'permission_id']
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function (User $user) {
            $defaultRoles = Role::query()
                ->where('is_default', true)
                ->get();
            $user->roles()
                ->attach($defaultRoles->pluck('id'));
        });
    }

    protected function getRoles(): array
    {
        return array_unique($this->roles->pluck('id')->toArray());
    }

    protected function getPermissions(): array
    {
        return array_unique($this->permissions->pluck('id')->toArray());
    }

    protected function password(): Attribute
    {
        return Attribute::set(
            fn (string $value): string => password_hash($value, PASSWORD_BCRYPT),
        );
    }

    public static function actionLoginToService(string $token, string $serviceName): string
    {
        /** @var \Egal\Auth\Tokens\UserMasterToken $umt */
        $umt = UserMasterToken::fromJWT($token, config('app.service_key'));
        $umt->isAliveOrFail();

        /** @var \Egal\AuthServiceDependencies\Models\User $user */
        $user = static::find($umt->getAuthIdentification());
        $service = self::getServiceModel()::find($serviceName);
        Session::getActionMessage()->getParameters()['timezone'] ?? Session::getActionMessage()->addParameter('timezone', 0);
        $timezone = Session::getActionMessage()->getParameters()['timezone'];

        if (!$user) {
            throw new UserNotIdentifiedException();
        }

        if (!$service) {
            throw new LoginException('Service not found!');
        }

        if (!isset($timezone) || $timezone > 12 || $timezone < -12) {
            throw new LoginException('Timezone not found!');
        }

        $ust = new UserServiceToken();
        $ust->setSigningKey($service->getKey());
        $ust->setAuthInformation($user->generateAuthInformation());
        return $ust->generateJWT();
    }

    protected function generateAuthInformation(): array
    {
        return array_merge(
            $this->fresh()->toArray(),
            [
                'auth_identification' => $this->getAuthIdentifier(),
                'roles' => $this->getRoles(),
                'permissions' => $this->getPermissions(),
                'timezone' => (int)Session::getActionMessage()->getParameters()['timezone'] ?? 0
            ]
        );
    }
}
