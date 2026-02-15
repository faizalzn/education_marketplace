<?php

namespace App\Actions;

use App\Models\User;
use App\Models\UserKyc;

class InitiateKycVerification
{
    public function execute(User $user, array $data): UserKyc
    {
        $kyc = $user->kyc ?? new UserKyc();

        $kyc->fill([
            'user_id' => $user->id,
            'full_name' => $data['full_name'],
            'phone_number' => $data['phone_number'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'] ?? null,
            'nationality' => $data['nationality'] ?? null,
            'street_address' => $data['street_address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'postal_code' => $data['postal_code'],
            'country' => $data['country'],
            'id_type' => $data['id_type'],
            'id_number' => $data['id_number'],
            'id_expiry_date' => $data['id_expiry_date'],
        ])->save();

        // Store document paths (assume files are uploaded separately)
        if (isset($data['id_document_path'])) {
            $kyc->id_document_path = $data['id_document_path'];
        }

        if (isset($data['address_proof_path'])) {
            $kyc->address_proof_path = $data['address_proof_path'];
        }

        $kyc->save();

        return $kyc->sendForReview() ? $kyc : $kyc;
    }
}
