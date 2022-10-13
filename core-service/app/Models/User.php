<?php

namespace App\Models;

use App\Events\SavedUserEvent;
use App\Events\UpdatingUserEvent;
use App\Events\ValidatingUserEvent;
use App\Helpers\HasQuery;
use App\Helpers\SessionHelper;
use Carbon\Carbon;
use Egal\Core\Session\Session;
use Egal\Model\Model as EgalModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @property string $id                {@property-type field} {@primary-key} {@validation-rules uuid|filled}
 * @property string $email             {@property-type field} {@validation-rules required|unique:users,email}
 * @property string $first_name        {@property-type field} {@validation-rules required|string|min:2|max:255|cyrillic}
 * @property string $last_name         {@property-type field} {@validation-rules required|string|min:2|max:255|cyrillic}
 * @property string $patronymic        {@property-type field} {@validation-rules string|min:2|max:255|cyrillic}
 * @property Carbon $birthdate         {@property-type field} {@validation-rules bail|required|date_format:Y-m-d|date_eighteen|maximum_age}
 * @property string $sex               {@property-type field} {@validation-rules required|string|in:male,female,none}
 * @property string $phone_number      {@property-type field} {@validation-rules required|string|phone_number|unique:users,phone_number}
 * @property string $role              {@property-type field} {@validation-rules string|filled}
 * @property Carbon $created_at        {@property-type field}
 * @property Carbon $updated_at        {@property-type field}
 *
 * @property Collection $client_chats                   {@property-type relation}
 * @property Collection $psychologist_chats             {@property-type relation}
 * @property Collection $messages                       {@property-type relation}
 * @property Collection $psychologist_data              {@property-type relation}
 * @property Collection $schedules                      {@property-type relation}
 * @property Collection $client_consultations           {@property-type relation}
 * @property Collection $psychologist_consultations     {@property-type relation}
 * @property Collection $user_results                   {@property-type relation}
 *
 * @action getItems {@statuses-access logged} {@roles-access shadow_psychologist|psychologist|admin|user}
 * @action create {@statuses-access logged} {@roles-access shadow_psychologist|shadow_user}
 * @action seederCreate {@services-access auth}
 * @action update {@statuses-access logged} {@roles-access user|shadow_psychologist|psychologist|admin}
 */
class User extends EgalModel
{
    use HasFactory;
    use HasQuery;

    protected $keyType = 'string';

    protected $fillable = [
        "id",
        'email',
        "first_name",
        "last_name",
        "patronymic",
        "birthdate",
        "sex",
        "phone_number",
        "role"
    ];

    public $hidden = [
        'role'
    ];

    public $incrementing = false;

    protected $dispatchesEvents = [
        'validating' => ValidatingUserEvent::class,
        'saved' => SavedUserEvent::class,
        'updating' => UpdatingUserEvent::class
    ];

    public function newQuery()
    {

        if (!Session::isActionMessageExists()) {
            return parent::newQuery();
        }

        if (Session::getActionMessage()->getModelName() !== get_class_short_name($this)) {
            return parent::newQuery();
        }

        if (Session::getActionMessage()->getActionName() === 'getItems' && SessionHelper::getRole() !== 'admin') {
            return parent::newQuery()->with('psychologistData')->where('id', '=', SessionHelper::getUUID());
        }

        return parent::newQuery()->with('psychologistData');
    }


    public static function actionSeederCreate(array $attributes = [])
    {
        $attributes["created_at"] = Carbon::now();
        $attributes["updated_at"] = Carbon::now();
        $user = DB::table('users')->insert([
            $attributes,
        ]);

        return $user;
    }

    public function clientChats(): HasMany
    {
        return $this->hasMany(Chat::class, 'client_id');
    }

    public function psychologistChats(): HasMany
    {
        return $this->hasMany(Chat::class, 'psychologist_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function psychologistData(): HasOne
    {
        return $this->hasOne(PsychologistData::class, 'id', 'id');
    }

    public function clientConsultations(): HasMany
    {
        return $this->hasMany(Consultation::class, 'client_id');
    }

    public function psychologistConsultations(): HasMany
    {
        return $this->hasMany(Consultation::class, 'psychologist_id');
    }

    public function userResults(): HasMany
    {
        return $this->hasMany(UserResult::class);
    }

    public function latestUserResult(): HasOne
    {
        return $this->hasOne(UserResult::class)->latestOfMany();
    }
}
