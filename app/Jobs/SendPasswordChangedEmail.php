<?php

namespace App\Jobs;

use App\Mail\PasswordChanged;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPasswordChangedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $newPassword;

    public function __construct($user, $newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }

    public function handle()
    {
        $data = [
            'user' => $this->user->name,
            'new_password' => $this->newPassword,
            'changed_date' => \Carbon\Carbon::now()->format('d M, Y h:i A'),
            'logo' => url('admin/assets/images/logo-light.png'),
        ];

        Mail::to($this->user->email)->queue(new PasswordChanged($data));
    }
}
