<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SponsorsController;
use App\Models\News;
use App\Models\Sponsor;
use App\Models\SponsoredAd;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Mail\ContactUs;
use App\Models\BusinessRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

Route::get('/', function () {
    $news = News::select('id', 'title', 'created_at')
        ->latest() // Orders by the latest created_at
        ->take(3)  // Limits to the first 3 results
        ->get();

    $sponsoredAds = SponsoredAd::select('business_name', 'poster_path')->get();

    $sponsors = Sponsor::select('logo')->get();

    return view('website.components.welcome', compact('news', 'sponsoredAds', 'sponsors'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get('/about', function () {
    return view('website.components.about');
});

Route::get('/services', function () {
    return view('website.components.services');
});

Route::get('/guests', function () {
    return view('website.components.testimonials');
});

Route::get('/news', function () {
    $news = News::paginate(10); // Adjust 10 to the number of items you want per page
    return view('website.components.news', compact('news'));
});


Route::get('/news-detail/{id}', function ($id) {
    $details = News::findOrFail($id); // Pass the ID to findOrFail
    $recent = News::whereNot('id', $id)
        ->select('title', 'created_at', 'id') // Select only needed columns
        ->latest() // Order by latest entries
        ->get();

    return view('website.components.news-detail', compact('details', 'recent'));
});



Route::get('/contact', function () {
    return view('website.components.contact');
});

Route::get('/publications', function () {
    return view('website.components.publications');
});

Route::get('/pricing', function () {
    return view('website.components.pricing');
});

Route::get('/download', function () {
    return response()->download('assets/proposals/proposal-2025.pdf');
});


Route::post('/contact-us', function (Request $request) {
    // Retrieve form inputs
    $name = $request->input('name');
    $email = $request->input('email');
    $subject = $request->input('subject');
    $userMessage = $request->input('message'); // Renamed from $message

    // Log inputs for debugging
    Log::info($name);
    Log::info($email);
    Log::info($subject);
    Log::info($userMessage);

    // Construct raw message
    $fullMessage = "Name: $name\n";
    $fullMessage .= "Email: $email\n";
    $fullMessage .= "Subject: $subject\n";
    $fullMessage .= "Message:\n$userMessage";

    // Send raw mail
    Mail::raw($fullMessage, function ($message) use ($email, $name, $subject) {
        $message->to('info@impactivebubuexpo.com')
            ->subject($subject)
            ->replyTo($email, $name); // Optional: makes reply go to the user
    });

    return view('website.components.thank-you');
})->name('contact-us');

Route::get("/register-with-us", function () {
    return view('website.components.register-with-us');
})->name('register-with-us');

Route::post('/register-your-business', function (Request $request) {
    // Validate the request
    $validator = Validator::make($request->all(), [
        'business_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'sponsor_package' => 'nullable|in:gold,diamond,silver,bronze',
        'exhibitor_package' => 'nullable|in:full_tent,shared_tent_2,shared_tent_5',
        'dinner_package' => 'nullable|in:table_10,table_5,individual',
        'message' => 'nullable|string|max:1000',
    ], [
        'business_name.required' => 'The business name field is required.',
        'email.required' => 'The email field is required.',
        'email.email' => 'Please enter a valid email address.',
        'phone.required' => 'The phone number field is required.',
    ]);

    // Check if at least one package is selected
    $validator->after(function ($validator) use ($request) {
        if (!$request->sponsor_package && 
            !$request->exhibitor_package && 
            !$request->dinner_package && 
            empty($request->magazine_options)) {
            $validator->errors()->add('package_required', 'Please select at least one package option.');
        }
    });

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        // Collect magazine options
        $magazineOptions = [];
        if ($request->magazine_back_cover) $magazineOptions[] = 'back_cover';
        if ($request->magazine_inside_cover) $magazineOptions[] = 'inside_cover';
        if ($request->magazine_page3) $magazineOptions[] = 'page3';
        if ($request->magazine_full_page) $magazineOptions[] = 'full_page';
        if ($request->magazine_half_vertical) $magazineOptions[] = 'half_vertical';
        if ($request->magazine_half_horizontal) $magazineOptions[] = 'half_horizontal';
        if ($request->magazine_quarter) $magazineOptions[] = 'quarter';

        // Create and save registration
        $registration = BusinessRegistration::create([
            'business_name' => $request->business_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'sponsor_package' => $request->sponsor_package,
            'exhibitor_package' => $request->exhibitor_package,
            'dinner_package' => $request->dinner_package,
            'magazine_options' => $magazineOptions,
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        // Construct email message
        $rawMessage = "New Business Registration\n\n";
        $rawMessage .= "Business Name: {$registration->business_name}\n";
        $rawMessage .= "Email: {$registration->email}\n";
        $rawMessage .= "Phone: {$registration->phone}\n";
        
        // Add selected packages
        $rawMessage .= "\nSelected Packages:\n";
        
        if ($registration->sponsor_package) {
            $sponsorMap = [
                'gold' => 'Gold (100m)',
                'diamond' => 'Diamond (50m)',
                'silver' => 'Silver (25m)',
                'bronze' => 'Bronze (5m)',
            ];
            $rawMessage .= "- Sponsor: " . ($sponsorMap[$registration->sponsor_package] ?? $registration->sponsor_package) . "\n";
        }
        
        if ($registration->exhibitor_package) {
            $exhibitorMap = [
                'full_tent' => 'Full Tent (1,200,000 UGX)',
                'shared_tent_2' => 'Shared Tent (Max 2) (600,000 UGX)',
                'shared_tent_5' => 'Shared Tent (Max 5) (300,000 UGX)',
            ];
            $rawMessage .= "- Exhibitor: " . ($exhibitorMap[$registration->exhibitor_package] ?? $registration->exhibitor_package) . "\n";
        }
        
        if ($registration->dinner_package) {
            $dinnerMap = [
                'table_10' => 'Table for 10 (1,000,000 UGX)',
                'table_5' => 'Table for 5 (500,000 UGX)',
                'individual' => 'Individual Ticket (100,000 UGX)',
            ];
            $rawMessage .= "- Dinner: " . ($dinnerMap[$registration->dinner_package] ?? $registration->dinner_package) . "\n";
        }
        
        if (!empty($registration->magazine_options)) {
            $magazineMap = [
                'back_cover' => 'Back Cover (4,672,800 UGX)',
                'inside_cover' => 'Inside Cover (3,894,000 UGX)',
                'page3' => 'Page 3 (3,352,800 UGX)',
                'full_page' => 'Full Page (2,336,400 UGX)',
                'half_vertical' => 'Half Page Vertical (1,713,360 UGX)',
                'half_horizontal' => 'Half Page Horizontal (1,401,840 UGX)',
                'quarter' => 'Quarter Page (934,560 UGX)',
            ];
            
            $rawMessage .= "- Magazine Options:\n";
            foreach ($registration->magazine_options as $option) {
                $rawMessage .= "  - " . ($magazineMap[$option] ?? $option) . "\n";
            }
        }
        
        $rawMessage .= "\nMessage: " . ($registration->message ?? 'N/A') . "\n";
        $rawMessage .= "IP Address: {$registration->ip_address}\n";
        $rawMessage .= "User Agent: {$registration->user_agent}\n";
        $rawMessage .= "Registration ID: {$registration->id}\n";
        $rawMessage .= "Submitted At: " . now()->format('Y-m-d H:i:s') . "\n";

        // Send email
        Mail::raw($rawMessage, function ($message) use ($registration) {
            $message->to('coordinator@impactivebubuexpo.com')
                ->subject('New Business Registration')
                ->replyTo($registration->email, $registration->business_name);
        });

        return redirect()->route('register-with-us')->with([
            'success' => 'Thank you for registering your business! We will contact you shortly.',
            'registration_id' => $registration->id
        ]);
    } catch (\Exception $e) {
        Log::error('Business registration failed: ' . $e->getMessage(), [
            'error' => $e->getTraceAsString(),
            'data' => $request->except('_token')
        ]);

        return redirect()->back()
            ->with('error', 'Registration failed. Please try again later.')
            ->withInput();
    }
})->name('register-with-us.post');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::prefix('admin')->group(function () {
//     Route::resource('/news', NewsController::class);

//     Route::resource('/sponsors', SponsorsController::class);
// });

require __DIR__ . '/auth.php';
