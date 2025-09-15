<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AclUserHasRole;
use App\Models\AclUserHasPermission;
use App\Models\ShopPost;
use Illuminate\Foundation\Auth\User as Authenticatable;
class AclUser extends  Authenticatable
{
    protected $table = 'acl_users';
    protected $fillable =[
        'username',
        'password',
        'last_name',
        'first_name',
        'gender',
        'email',
        'birthday',
        'avatar',
        'code',
        'job_title',
        'department',
        'manager_id',
        'phone',
        'address1',
        'address2',
        'city',
        'state',
        'postal_code',
        'country',
        'active_code',
        'status',
        'created_at',
        'updated_at',
    ];
    protected $guarded = ['id'];
    protected $primaryKey = 'id';
    protected $dates =[
        'birthday',
        'created_at',
        'updated_at'
    ];
    protected $dateFormat ='Y-m-d H:i:s';

    public function roles(){
        return $this->hasMany(
            AclUserHasRole::class,
            'user_id' ,'id'
        );
    }
    public function permissions(){
        return $this->hasMany(
            AclUserHasPermission::class,
            'user_id' ,'id'
        );
    }
    public function posts(){
        return $this->hasMany(
            ShopPost::class,
            'user_id' ,'id'
        );
    }

    /**
     * Tên cột 'Ghi nhớ đăng nhập'
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = 'remember_token';
    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->getKeyName();
    }
    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }
    /**
     * Hàm trả về tên cột dùng để tim `Mật khẩu`
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
    /**
     * Hàm dùng để trả về giá trị của cột "nv_ghinhodangnhap" session.
     * Get the token value for the "remember me" session.
     *
     * @return string|null
     */
    public function getRememberToken()
    {
        if (! empty($this->getRememberTokenName())) {
            return (string) $this->{$this->getRememberTokenName()};
        }
    }
    /**
     * Hàm dùng để set giá trị cho cột "nv_ghinhodangnhap" session.
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        if (! empty($this->getRememberTokenName())) {
            $this->{$this->getRememberTokenName()} = $value;
        }
    }
    /**
     * Hàm trả về tên cột dùng để chứa REMEMBER TOKEN
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return $this->rememberTokenName;
    }
    public function setPasswordAttribute($value)
    {
        
        $this->attributes['password'] = bcrypt($value);
        
    }
}