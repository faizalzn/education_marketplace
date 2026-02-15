<?php

namespace App\Http\Controllers\Auth;

use App\Actions\InitiateKycVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KycController extends BaseController
{
    public function show()
    {
        return Inertia::render('Auth/KYCRegistration');
    }

    public function store(Request $request, InitiateKycVerification $action)
    {
        $user = $request->user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'nullable|in:male,female,other',
            'nationality' => 'nullable|string|max:100',
            'street_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'id_type' => 'required|in:passport,national_id,driver_license',
            'id_number' => 'required|string|unique:user_kyc,id_number|max:50',
            'id_expiry_date' => 'required|date|after:today',
            'id_document_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'address_proof_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'bank_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
            'bank_routing_number' => 'nullable|string|max:20',
            'bank_account_holder_name' => 'required|string|max:255',
            'bank_statement_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'selfie_path' => 'nullable|string',
        ]);

        // Handle file uploads
        if ($request->hasFile('id_document_path')) {
            $validated['id_document_path'] = $request->file('id_document_path')->store('kyc/documents');
        }

        if ($request->hasFile('bank_statement_path')) {
            $validated['bank_statement_path'] = $request->file('bank_statement_path')->store('kyc/statements');
        }

        // Process KYC
        $kyc = $action->execute($user, $validated);

        return redirect('/dashboard')->with('success', 'KYC verification submitted successfully. Please wait for admin review.');
    }
}
