<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AddressUpdateController extends Controller
{
    /**
     * Store a newly created address update application in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sid' => 'nullable|string|max:32',
            'aadhaar_number' => 'required|digits:12',
            'current_address' => 'required|string',
            'new_address' => 'required|string',
            'pincode' => 'required|digits:6',
            'proof_of_address' => 'required|string|max:255',
            'operator_id' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Perform business logic (wallet deduction, enrolment packet logging)

            DB::commit();

            return redirect()->route('retailer.dashboard')
                ->with('success', 'Address update application submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to submit address update: ' . $e->getMessage())
                ->withInput();
        }
    }
}
