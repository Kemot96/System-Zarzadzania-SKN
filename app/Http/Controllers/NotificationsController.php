<?php

namespace App\Http\Controllers;

use App\Models\ClubMember;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function index()
    {
        return view('notifications', [
            'notifications' => auth()->user()->notifications,
        ]);
    }

    public function actionClubMemberRemoveRequest(Request $request, Notification $notification)
    {
        if ($request->action == "accept") {

            ClubMember::destroy($notification->data["clubMember"]);

            DB::table('notifications')
                ->where('id', $notification->id)
                ->update(['data->status' => true]);

        } else if ($request->action == "discard") {

            $clubMember = ClubMember::find($notification->data["clubMember"]);

            $clubMember->removal_request = FALSE;

            $clubMember->save();

            DB::table('notifications')
                ->where('id', $notification->id)
                ->update(['data->status' => false]);
        }

        return back();

    }

}
