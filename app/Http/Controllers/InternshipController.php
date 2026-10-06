<?php

namespace App\Http\Controllers;

use App\Enums\InternshipStatus;
use App\Http\Requests\StoreInternshipApplicationRequest;
use App\Models\Internship;
use App\Models\InternshipApplication;
use App\Models\InternshipDomain;
use Illuminate\Http\RedirectResponse;

class InternshipController extends Controller
{
    /**
     * Options for the application form's "College Name" <select>. A fixed local
     * list (matching the ones avabodhfoundation.org/internships itself offers)
     * plus "Other", which reveals a free-text field (college_name_other) for any
     * college not on this list -- see the apply form and store() below.
     *
     * @var array<int, string>
     */
    private const COLLEGE_OPTIONS = [
        'S. B. Jain Institute of Technology, Management and Research',
        'Tata Institute of Social Sciences',
        'Symbiosis Institute of Technology, Nagpur',
        'Symbiosis Centre for Management Studies, Nagpur',
        'Symbiosis Institute of Technology, Pune',
        'D. Y. Patil International University, Pune',
        'Ramdeobaba University',
        'SRM Institute of Science and Technology',
        'G. S. College of Commerce & Economics, Nagpur',
        "Maharshi Karve Stree Shikshan Samstha's Cummins College of Engineering for Women, Nagpur",
        'G. H. Raisoni College of Engineering, Nagpur',
        'Dr. Ambedkar Institute of Management Studies and Research',
        'Priyadarshini College of Engineering, Nagpur',
        'Yeshwantrao Chavan College of Engineering',
    ];

    /**
     * Public /internships page: hero, open positions (published internships only),
     * and the apply form. All three sections live on this one page/view, matching
     * the task's specified page structure.
     */
    public function index()
    {
        $internships = Internship::query()
            ->where('status', InternshipStatus::Published)
            ->with('domain')
            ->orderBy('display_order')
            ->orderByDesc('created_at')
            ->get();

        $domains = InternshipDomain::query()
            ->where('is_active', true)
            ->orderBy('display_order')
            ->get();

        return view('pages.internships.index', [
            'internships' => $internships,
            'domains' => $domains,
            'collegeOptions' => self::COLLEGE_OPTIONS,
        ]);
    }

    /**
     * Final application submission. Only reachable once
     * StoreInternshipApplicationRequest's validation (including the "internship is
     * published" and "no duplicate application for this internship/email" checks)
     * passes.
     */
    public function store(StoreInternshipApplicationRequest $request): RedirectResponse
    {
        // "Other" is never itself the stored college name -- when chosen, the
        // applicant's own free-text entry (college_name_other) is what's saved.
        $collegeName = $request->validated('college_name') === 'Other'
            ? $request->validated('college_name_other')
            : $request->validated('college_name');

        $application = InternshipApplication::create([
            ...$request->safe()->only([
                'internship_id',
                'full_name',
                'email',
                'phone',
                'preferred_domain_id',
                'address',
                'skills',
            ]),
            'college_name' => $collegeName,
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('internships.index')
            ->with('applicationSubmitted', [
                'application_id' => $application->application_id,
                'internship_title' => $application->internship->title,
            ]);
    }
}
