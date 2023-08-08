<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrustedContactStoreRequest;
use App\Http\Requests\TrustedContactUpdateRequest;
use App\Models\TrustedContact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TrustedContactController extends Controller
{

    public function index(Request $request)
    {
        $userID = $request->user()->id;
        $trustedContacts = TrustedContact::where('user_id', $userID)->get();

        return $this->successResponse($trustedContacts, 'Trusted contacts fetched successfully');
    }

    public function store(TrustedContactStoreRequest $request)
    {
        $data = $request->validated();
        $userID = $request->user()->id;

        $trustedContacts = [];
        foreach($data as $contact) {
            $contact["user_id"] = $userID;
            $trustedContacts[] = TrustedContact::create($contact);
        }

        return $this->successResponse($trustedContacts, 'Trusted contacts created successfully', Response::HTTP_CREATED);
    }

    public function show(TrustedContact $trustedContact)
    {
        return $this->successResponse($trustedContact, 'Trusted contact fetched successfully');
    }

    public function update(TrustedContactUpdateRequest $request, TrustedContact $trustedContact)
    {
        $user = $request->user();

        if ($user->id !== $trustedContact->user_id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $data = $request->validated();

        $trustedContact->update($data);

        return $this->successResponse($trustedContact, 'Trusted contact updated successfully');
    }

    public function destroy(TrustedContact $trustedContact, Request $request)
    {
        $user = $request->user();

        if ($user->id !== $trustedContact->user_id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $trustedContact->delete();

        return $this->successResponse(null, 'Trusted contact deleted successfully', 204);
    }
}
