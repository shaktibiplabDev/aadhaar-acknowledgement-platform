<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PassportController extends Controller
{
    /**
     * Store a newly created passport/document update application in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sid' => 'nullable|string|max:32',
            'aadhaar_number' => 'required|digits:12',
            'passport_number' => 'required|string|max:20',
            'expiry_date' => 'required|date|after:today',
            'proof_document' => 'required|string|max:255',
            'operator_id' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Perform business logic (wallet deduction, document update packet logging)

            DB::commit();

            return redirect()->route('retailer.dashboard')
                ->with('success', 'Passport/Document update application submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to submit passport/document update: ' . $e->getMessage())
                ->withInput();
        }
    }
}
