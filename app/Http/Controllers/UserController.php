<?php

namespace App\Http\Controllers;

use App\Models\BusinessData;
use App\Models\OpenHour;
use App\Models\Social;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function storeProfileInfo(Request $request)
    {
        $user_id = $request->user()->id;
        $profileInfo = json_decode($request->profileInfo);
        $openHours = json_decode($request->openHours);

        $businessData = [
            'businessAddress' => $profileInfo->businessAddress,
            'businessPhone' => $profileInfo->businessPhone,
            'state_id' => $profileInfo->state,
            'lga_id' => $profileInfo->lga,
        ];
        $socialsData = [
            'user_id' => $user_id,
            'whatsapp' => $profileInfo->whatsappPhone,
            'facebook' => $profileInfo->facebookHandle,
            'instagram' => $profileInfo->instagramHandle,
            'twitter' => $profileInfo->twitterHandle,
            'website' => $profileInfo->website,
        ];
        $businessInfo = BusinessData::where('user_id', $user_id)->first();
        $businessInfo->update($businessData);

        $socialsInfo = Social::updateOrCreate([
            'user_id' => $user_id
        ], $socialsData);

        $openHoursBulk = [];

        foreach ($openHours as $i) {
            $data = [
                'day' => $i->day,
                'open' => $i->openTime,
                'close' => $i->closeTime,
                'user_id' => $user_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            array_push($openHoursBulk, $data);
        }

        $deleteOld = OpenHour::where('user_id', $user_id)->delete();
        OpenHour::insert($openHoursBulk);


        return response([
            'businessInfo' => $businessInfo,
            'socialsInfo' => $socialsInfo,
           // 'openHours' => $openHours,
        ], 201);
    }

    public function changeProfilePic(Request $request)
    {
        $user = User::find($request->user()->id);
        if ($request->hasFile('businessLogo')) {
            $image = $request->file('businessLogo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $imageName);

            // Retrieve the previous logo name from the database

            $previousLogo = $user->businessLogo;

            // Delete the previous logo file if it exists
            if ($previousLogo && Storage::exists('public/images/' . $previousLogo)) {
                Storage::delete('public/images/' . $previousLogo);
            }

            $data = [
                'businessLogo' => $imageName,
            ];

            $user->update($data);

            return $user;
        } else {
            return response([
                'error' => 'Invalid image'
            ], 401);
        }
    }

    public function getProfileInfo(Request $request)
    {
        $user_id = $request->user()->id;

        $userData = User::with(['businessData', 'socials', 'openHours'])
            ->where('id', $user_id)
            ->first();

        // $userData = BusinessData::where('user_id', $user_id)->first();


        return $userData;
    }
}
