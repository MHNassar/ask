<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version January 15, 2018, 2:32 pm UTC
 *
 * @method User findWithoutFail($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'phone',
        'biography',
        'photo',
        'remember_token',
        'token'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
