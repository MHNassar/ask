<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class userRepository
 * @package App\Repositories
 * @version January 17, 2018, 10:48 am UTC
 *
 * @method user findWithoutFail($id, $columns = ['*'])
 * @method user find($id, $columns = ['*'])
 * @method user first($columns = ['*'])
 */
class userRepository extends BaseRepository
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
        'token',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
}
