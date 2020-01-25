<?php


namespace App\Middlewares;


class GuestMiddleware
{
    public function handle()
    {
        if(!auth()) {
            return view('errors.forbidden');
        }

        return true;
    }
}