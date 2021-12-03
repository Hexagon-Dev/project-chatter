<?php

namespace App\Models;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    /**
     * @param string $type
     * @param ?int $userID
     * @return Chat|Model
     * @throws Throwable
     */
    public function getChat(string $type, ?int $userID = null): Chat
    {
        if (!in_array($type, Chat::TYPES, true)) {
            throw new UnprocessableEntityHttpException('Unrecognized type of chat');
        }

        // Если юзер не указан - пишем в чат проекта, иначе проверяем можем ли мы писать пользователю и пишем
        if ($userID === null) {
            $userID = $this->id;
        } else {
            $role = DB::table('model_has_roles')->where('model_id', $userID)->get('role_id')->first();
            $role = Role::findById($role->role_id);

            $receiverPermissions = collect($role->permissions->pluck('name'));

            $havePerm = $receiverPermissions->contains(function ($value) {
                return auth()->user()->hasPermissionTo($value);
            });

            if (!$havePerm) {
                throw new AuthorizationException('You don\'t have permission to write this user');
            }
        }

        return $this->chats()->firstOrCreate([
            'type' => $type,
            'chat_user_id' => $userID,
        ]);
    }
}
