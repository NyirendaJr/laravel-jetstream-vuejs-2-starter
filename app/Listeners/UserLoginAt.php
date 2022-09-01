<?php

namespace App\Listeners;

use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;

class UserLoginAt
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        public UserRepository $userRepository
    ){}

    /**
     * Handle the event.
     *
     * @param Login $event
     * @return void
     */
    public function handle(Login $event): void
    {
        $this->userRepository->update($event->user['id'], [
            'last_login_at' => Carbon::now(),
            'last_login_ip_address' => request()->getClientIp()
        ]);
    }
}
