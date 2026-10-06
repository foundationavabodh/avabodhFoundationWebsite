<?php

namespace App\Http\Controllers;

use App\Enums\PartnerApprovalStatus;
use App\Models\Partner;

class PartnerController extends Controller
{
    /**
     * Display the full details page for one NGO / partner.
     *
     * Route-model binding resolves the Partner by `slug` regardless of whether it
     * is active, so -- like ProjectController::show() -- we explicitly 404 for
     * partners hidden from the public network page.
     */
    public function show(Partner $partner)
    {
        abort_unless($partner->is_active_network && $partner->approval_status === PartnerApprovalStatus::Approved, 404);

        $related = Partner::active()
            ->where('category', $partner->category)
            ->whereKeyNot($partner->getKey())
            ->limit(3)
            ->get();

        return view('pages.ngo-show', [
            'partner' => $partner,
            'related' => $related,
        ]);
    }
}
