<?php

namespace App\Modules\Cart;

use App\User;


class CartPolicy
{

    /**
     * Determines user access
     *
     * @param User $user
     * @return bool
     */
    public function index($user)
    {
        return true;
    }

    /**
     * Determines user access
     *
     * @param User $user
     * @return bool
     */
    public function store($user)
    {
        return true;
    }
}