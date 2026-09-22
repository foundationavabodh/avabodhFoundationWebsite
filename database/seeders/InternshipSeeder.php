<?php

namespace Database\Seeders;

use App\Enums\InternshipStatus;
use App\Models\Internship;
use App\Models\InternshipDomain;
use Illuminate\Database\Seeder;

class InternshipSeeder extends Seeder
{
    /**
     * Seeds a handful of sample Published internships so the public /internships
     * page and the admin CMS have something to show right away. Purely optional
     * demo data -- safe to run more than once (uses updateOrCreate on the slug),
     * and every field here is freely editable/removable afterwards from
     * /admin/internships once Step B (the Filament resource) exists.
     *
     * Run with: php artisan db:seed --class=InternshipSeeder
     */
    public function run(): void
    {
        $samples = [
            [
                'domain' => 'Website Development',
                'title' => 'Frontend Development Intern',
                'short_description' => 'Help build and improve pages on the Avbodh Foundation website using our existing design system.',
                'description' => "You'll work alongside our small dev team on real features for the public website -- new pages, small UI improvements, and bug fixes. Good fit if you're comfortable with HTML/CSS and are learning JavaScript.",
                'duration' => '2 months',
                'commitment' => '10-12 hrs/week',
                'skills_required' => 'HTML, CSS, JavaScript, Git',
                'display_order' => 0,
            ],
            [
                'domain' => 'Content Writing',
                'title' => 'Content Writing Intern',
                'short_description' => 'Write blog posts, impact stories, and social captions that help us reach more supporters.',
                'description' => "You'll research and draft articles about our ongoing projects, interview volunteers for short profile pieces, and help keep our website's content fresh and accurate.",
                'duration' => '1-2 months',
                'commitment' => '6-8 hrs/week',
                'skills_required' => 'Writing, Research, Basic SEO',
                'display_order' => 1,
            ],
            [
                'domain' => 'Digital Marketing',
                'title' => 'Digital Marketing Intern',
                'short_description' => 'Plan and run small social media campaigns to raise awareness for our current initiatives.',
                'description' => "You'll help plan a content calendar, draft posts, track basic engagement metrics, and support our outreach around upcoming events and fundraisers.",
                'duration' => '3 months',
                'commitment' => '8-10 hrs/week',
                'skills_required' => 'Social Media, Canva, Basic Analytics',
                'display_order' => 2,
            ],
            [
                'domain' => 'Designing',
                'title' => 'Graphic Design Intern',
                'short_description' => 'Design posters, social graphics, and print materials for our campaigns and events.',
                'description' => "You'll create visual assets for our social channels and offline events, working from our existing brand guidelines.",
                'duration' => '2 months',
                'commitment' => '6-10 hrs/week',
                'skills_required' => 'Canva or Figma, Basic Typography',
                'display_order' => 3,
            ],
            [
                'domain' => 'Volunteer',
                'title' => 'Field Volunteer Coordinator Intern',
                'short_description' => 'Support the coordination of our on-ground volunteer drives and community events.',
                'description' => "You'll help schedule volunteers, prepare materials for events, and be a point of contact for volunteers on the day of an activity.",
                'duration' => '3 months',
                'commitment' => '8 hrs/week',
                'skills_required' => 'Communication, Organization',
                'display_order' => 4,
            ],
        ];

        foreach ($samples as $sample) {
            $domain = InternshipDomain::where('name', $sample['domain'])->first();

            if (! $domain) {
                // Domain lookup table has been edited/renamed since this seeder was
                // written -- skip rather than fail the whole run.
                continue;
            }

            Internship::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($sample['title'])],
                [
                    'domain_id' => $domain->id,
                    'title' => $sample['title'],
                    'short_description' => $sample['short_description'],
                    'description' => $sample['description'],
                    'duration' => $sample['duration'],
                    'commitment' => $sample['commitment'],
                    'skills_required' => $sample['skills_required'],
                    'status' => InternshipStatus::Published,
                    'display_order' => $sample['display_order'],
                ]
            );
        }
    }
}
