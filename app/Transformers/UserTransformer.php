<?php

namespace ApiTripCuba\Transformers;

use ApiTripCuba\Entities\User;
use League\Fractal;
use Carbon\Carbon;

class UserTransformer extends Fractal\TransformerAbstract
{

	public function transform(User $user)
    {
        $results = [
            'id' => (int)$user->id,
            'type' => 'users',
            'attributes' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email'=> $user->username,
                'birthdate'=> $user->birthdate

            ]
        ];

        // remove empty results
        foreach ($results as $key => $result) {
            if (empty($result)) {
                unset($results[$key]);
            }
        }
        return $results;
    }

}