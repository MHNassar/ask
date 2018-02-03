<?php

namespace App\Repositories;

use App\Models\Twitte;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TwitteRepository
 * @package App\Repositories
 * @version January 17, 2018, 12:40 pm UTC
 *
 * @method Twitte findWithoutFail($id, $columns = ['*'])
 * @method Twitte find($id, $columns = ['*'])
 * @method Twitte first($columns = ['*'])
*/
class TwitteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'body'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Twitte::class;
    }
}
