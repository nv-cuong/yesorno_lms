<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class UserNotificationController extends Controller
{
    /**
     * @param  int  $id  Notification ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $user = Sentinel::getUser();
        // @phpstan-ignore-next-line
        $notification = $user->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
            return redirect(route('personal.course', [$notification->data['course_slug']]));
        }

        return abort(404);
    }
}
