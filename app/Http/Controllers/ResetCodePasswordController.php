<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResetCodePasswordRequest;
use App\Http\Requests\UpdateResetCodePasswordRequest;
use App\Models\ResetCodePassword;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ResetCodePasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($userData)
    {
        function resetCodeStore($userData_,){
            $finalCode=[];
            $resetCode_ = mt_rand(100000, 999999);
            $resetCodeHash_ = Hash::make($resetCode_);
            $resetCodeStore = ResetCodePassword::create(['member_id' => $userData_['memberID'], 'email' => $userData_['email'], 'resetCode' => $resetCodeHash_]);
            if ($resetCodeStore) {
//                return $resetCodeStore['password_reset_code']=$resetCode_;
                $finalCode['url']=\hash('sha256',$resetCodeStore['resetCode']);
                $finalCode['code']=$resetCode_;
                $finalCode['id']=$resetCodeStore['id'];
                return $finalCode;

//                return $finalCode['email'$resetCodeStore['email']];
            } else return null;
        }
//        $existedResetCode = ResetCodePassword::where('email', $userData['email']);
        $existedResetCode = ResetCodePassword::where('email', $userData['email'])->first();
        if (empty($existedResetCode)) {
            //check if time is different with last one
            return resetCodeStore($userData);
        } else {
            $startTime = $existedResetCode['created_at'];
            $timeBefore = Carbon::parse($startTime);
            $currentTime = Carbon::now();
            $timeDiff=$timeBefore->diffInMinutes($currentTime);
            if($timeDiff>=41){
                ResetCodePassword::destroy($existedResetCode['id']);
                return resetCodeStore($userData);
            }
            //TODO: Implement destroy controller to delete the record if is failed to send the email
//            else {
//                $finalCode=[];
////                $finalCode['url']=\hash('sha256',$existedResetCode['resetCode']);
//
//
//                return $existedResetCode;
//            }

        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreResetCodePasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResetCodePasswordRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ResetCodePassword $resetCodePassword
     * @return \Illuminate\Http\Response
     */
    public function show(ResetCodePassword $resetCodePassword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ResetCodePassword $resetCodePassword
     * @return \Illuminate\Http\Response
     */
    public function edit(ResetCodePassword $resetCodePassword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateResetCodePasswordRequest $request
     * @param \App\Models\ResetCodePassword $resetCodePassword
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResetCodePasswordRequest $request, ResetCodePassword $resetCodePassword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ResetCodePassword $resetCodePassword
     * @return \Illuminate\Http\Response
     */
    public function destroyById($id)
    {
        ResetCodePassword::destroy($id);
    }
//    public function destroy(ResetCodePassword $resetCodePassword)
//    {
// }
}
