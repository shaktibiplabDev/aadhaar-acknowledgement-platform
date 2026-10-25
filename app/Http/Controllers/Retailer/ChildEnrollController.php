<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ChildEnrollController extends Controller
{
    /**
     * Store a newly created child enrolment application in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sid' => 'nullable|string|max:32',
            'child_name' => 'required|string|max:255',
            'dob' => 'required|date|after_or_equal:' . now()->subYears(5)->toDateString(),
            'gender' => 'required|in:M,F,T',
            'parent_aadhaar' => 'required|digits:12',
            'parent_name' => 'required|string|max:255',
            'address' => 'required|string',
            'pincode' => 'required|digits:6',
            'birth_certificate' => 'required|string|max:255',
            'operator_id' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Perform business logic (child enrolment packet logging, minor biometric exemption)

            DB::commit();

            return redirect()->route('retailer.dashboard')
                ->with('success', 'Child enrolment application submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to submit child enrolment: ' . $e->getMessage())
                ->withInput();
        }
    }
}
