<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MobileEmailController extends Controller
{
    /**
     * Store a newly created mobile/email update application in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sid' => 'nullable|string|max:32',
            'aadhaar_number' => 'required|digits:12',
            'mobile' => 'nullable|digits:10',
            'email' => 'nullable|email|max:255',
            'operator_id' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (empty($request->mobile) && empty($request->email)) {
            return redirect()->back()
                ->withErrors(['contact' => 'At least either mobile number or email address must be provided.'])
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Perform business logic (wallet deduction, demographic update packet logging)

            DB::commit();

            return redirect()->route('retailer.dashboard')
                ->with('success', 'Mobile/Email update application submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to submit mobile/email update: ' . $e->getMessage())
                ->withInput();
        }
    }
}
