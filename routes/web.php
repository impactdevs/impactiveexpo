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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
