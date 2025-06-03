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
        'package' => 'required|in:gold,diamond,silver,bronze',
        'message' => 'nullable|string|max:1000',
    ], [
        'business_name.required' => 'The business name field is required.',
        'email.required' => 'The email field is required.',
        'email.email' => 'Please enter a valid email address.',
        'phone.required' => 'The phone number field is required.',
        'package.required' => 'Please select a package.',
        'package.in' => 'Please select a valid package option.',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        // Create and save registration
        $registration = BusinessRegistration::create([
            'business_name' => $request->business_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'package' => $request->package,
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        // construct a raw email to coordinator@impactivebubuexpo.com
        $rawMessage = "Business Name: {$registration->business_name}\n";
        $rawMessage .= "Email: {$registration->email}\n";
        $rawMessage .= "Phone: {$registration->phone}\n";
        $rawMessage .= "Package: {$registration->package}\n";
        $rawMessage .= "Message: {$registration->message}\n";
        $rawMessage .= "IP Address: {$registration->ip_address}\n";
        $rawMessage .= "User Agent: {$registration->user_agent}\n";
        $rawMessage .= "Registration ID: {$registration->id}\n";
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
