@extends('website.app')

@section('content')
    <main class="main">
        <style>
            /* Main container styling */
            .contact.section {
                background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
                padding: 5rem 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
            }

            .container[data-aos="fade"] {
                animation: fadeIn 0.8s ease-out forwards;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Form card styling */
            .php-email-form {
                background: white;
                border-radius: 16px;
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
                padding: 2.5rem;
                border: 1px solid #eef2f7;
                transition: all 0.4s ease;
                position: relative;
                overflow: hidden;
            }

            .php-email-form:before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 6px;
                background: linear-gradient(90deg, #3b82f6, #2563eb, #1d4ed8);
                border-radius: 16px 16px 0 0;
            }

            .php-email-form:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            }

            /* Form header styling */
            .php-email-form h2 {
                color: #1e293b;
                font-weight: 700;
                font-size: 2.2rem;
                letter-spacing: -0.5px;
                margin-bottom: 1.2rem !important;
                position: relative;
                padding-bottom: 1rem;
            }

            .php-email-form h2:after {
                content: "";
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 80px;
                height: 4px;
                background: linear-gradient(90deg, #3b82f6, #2563eb);
                border-radius: 4px;
            }

            .php-email-form p {
                color: #64748b;
                font-size: 1.1rem;
                line-height: 1.6;
                margin-bottom: 2rem !important;
            }

            /* Form labels */
            .form-label {
                font-weight: 600;
                color: #334155;
                margin-bottom: 0.6rem;
                font-size: 0.95rem;
                display: flex;
                align-items: center;
            }

            .form-label:after {
                content: " *";
                color: #ef4444;
                margin-left: 3px;
            }

            /* Form controls */
            .form-control,
            .form-select {
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 14px 18px;
                font-size: 1rem;
                transition: all 0.3s ease;
                height: auto;
                box-shadow: none !important;
                background-color: #f8fafc;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
                background-color: white;
            }

            /* Placeholder styling */
            .form-control::placeholder {
                color: #94a3b8;
                opacity: 0.8;
            }

            /* Select dropdown arrow */
            .form-select {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
                background-position: right 18px center;
                background-size: 16px 12px;
                padding-right: 50px;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
            }

            /* Textarea styling */
            textarea.form-control {
                min-height: 140px;
                resize: vertical;
            }

            /* Submit button styling */
            .btn-primary {
                background: linear-gradient(135deg, #2563eb, #1d4ed8);
                border: none;
                border-radius: 10px;
                padding: 16px 32px;
                font-size: 1.1rem;
                font-weight: 600;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
                box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
                width: 100%;
                max-width: 300px;
                position: relative;
                overflow: hidden;
            }

            .btn-primary:before {
                content: "";
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
                transition: 0.5s;
            }

            .btn-primary:hover:before {
                left: 100%;
            }

            .btn-primary:hover,
            .btn-primary:focus {
                background: linear-gradient(135deg, #1d4ed8, #1e40af);
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
            }

            .btn-primary:active {
                transform: translateY(-1px);
            }

            /* Package options styling */
            .package-options {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 12px;
                margin-top: 0.5rem;
            }

            .package-option {
                border: 2px solid #e2e8f0;
                border-radius: 10px;
                padding: 12px 10px;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s ease;
                background-color: #f8fafc;
            }

            .package-option:hover {
                border-color: #93c5fd;
                background-color: #eff6ff;
            }

            .package-option.selected {
                border-color: #3b82f6;
                background-color: #dbeafe;
                box-shadow: 0 4px 10px rgba(59, 130, 246, 0.15);
            }

            .package-option input {
                display: none;
            }

            .package-option label {
                cursor: pointer;
                font-weight: 500;
                color: #334155;
                margin: 0;
            }

            /* Responsive adjustments */
            @media (max-width: 992px) {
                .php-email-form {
                    padding: 2rem;
                }
            }

            @media (max-width: 768px) {
                .php-email-form {
                    padding: 1.8rem 1.5rem;
                }

                .btn-primary {
                    max-width: 100%;
                    padding: 15px;
                }

                .col-md-6 {
                    margin-top: 1rem !important;
                }

                .package-options {
                    grid-template-columns: 1fr 1fr;
                }
            }

            @media (max-width: 576px) {
                .php-email-form h2 {
                    font-size: 1.8rem;
                }

                .php-email-form p {
                    font-size: 1rem;
                }

                .package-options {
                    grid-template-columns: 1fr;
                }
            }

            /* Form group spacing */
            .form-group {
                margin-bottom: 1.7rem;
                position: relative;
            }

            /* Input icons */
            .input-icon {
                position: absolute;
                right: 18px;
                top: 42px;
                color: #94a3b8;
                font-size: 1.1rem;
            }

            /* New styles for multi-section form */
            .form-section {
                background: white;
                border-radius: 12px;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
                padding: 2rem;
                margin-bottom: 2rem;
                border: 1px solid #eef2f7;
            }

            .form-section-header {
                color: #1e293b;
                font-weight: 700;
                font-size: 1.5rem;
                padding-bottom: 1rem;
                margin-bottom: 1.5rem;
                border-bottom: 2px solid #dbeafe;
                position: relative;
            }

            .form-section-header:after {
                content: "";
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 80px;
                height: 4px;
                background: linear-gradient(90deg, #3b82f6, #2563eb);
                border-radius: 4px;
            }

            .package-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 16px;
                margin-top: 0.5rem;
            }

            .package-grid-4 {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }

            .package-grid-7 {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            }

            .package-grid-3 {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .package-option-price {
                display: block;
                font-size: 0.9rem;
                font-weight: 600;
                color: #2563eb;
                margin-top: 6px;
            }
        </style>

        <div class="container" data-aos="fade">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form action="/register-your-business" method="post" class="register-form php-email-form"
                        style="opacity: 0;">
                        @csrf
                        <h2 class="mb-4 text-center">Register Your Business</h2>
                        <p class="mb-4 text-center">Please fill out the form below to register your business with us. We
                            will review your submission and get back to you shortly.</p>

                        {{-- display success message --}}
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- display error messages --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <!-- Business Name -->
                            <div class="col-md-12 form-group">
                                <label for="business_name" class="form-label">Business Name</label>
                                <input type="text" name="business_name" class="form-control" id="business_name" value="{{ old('business_name') }}"
                                    placeholder="Enter business name" required>
                                <span class="input-icon"><i class="fas fa-building"></i></span>
                            </div>

                            <!-- Contact Email -->
                            <div class="col-md-6 form-group mt-3">
                                <label for="email" class="form-label">Contact Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}"
                                    placeholder="your@email.com" required>
                                <span class="input-icon"><i class="fas fa-envelope"></i></span>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-6 form-group mt-3">
                                <label for="phone" class="form-label">Contact Phone</label>
                                <input type="tel" class="form-control" name="phone" id="phone" value="{{ old('phone') }}"
                                    placeholder="+123 456 7890" required>
                                <span class="input-icon"><i class="fas fa-phone"></i></span>
                            </div>

                            <!-- ====================== -->
                            <!-- Sponsor Packages Section -->
                            <!-- ====================== -->
                            <div class="col-md-12 form-section mt-4">
                                <h3 class="form-section-header">Sponsor Packages</h3>
                                <p>If you are interested in our sponsorship packages, select one below. Most people are
                                    taking Diamond.</p>
                                <div class="form-group mt-3">
                                    <div class="package-options package-grid">
                                        <div class="package-option">
                                            <input type="radio" name="sponsor_package" id="gold" value="gold">
                                            <label for="gold">Gold - 100m
                                                <span class="package-option-price">100,000,000 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="radio" name="sponsor_package" id="diamond" value="diamond">
                                            <label for="diamond">Diamond - 50m
                                                <span class="package-option-price">50,000,000 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="radio" name="sponsor_package" id="silver" value="silver">
                                            <label for="silver">Silver - 25m
                                                <span class="package-option-price">25,000,000 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="radio" name="sponsor_package" id="bronze" value="bronze">
                                            <label for="bronze">Bronze - 5m
                                                <span class="package-option-price">5,000,000 UGX</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ====================== -->
                            <!-- Exhibitor Packages Section -->
                            <!-- ====================== -->
                            <div class="col-md-12 form-section">
                                <h3 class="form-section-header">Exhibition Tent Packages (Size 5*5m)</h3>
                                <p>Select your preferred exhibition tent option below:</p>
                                <div class="form-group mt-3">
                                    <div class="package-options package-grid package-grid-4">
                                        <div class="package-option">
                                            <input type="radio" name="exhibitor_package" id="full_tent" value="full_tent">
                                            <label for="full_tent">Full Tent
                                                <span class="package-option-price">1,200,000 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="radio" name="exhibitor_package" id="shared_tent_2"
                                                value="shared_tent_2">
                                            <label for="shared_tent_2">Shared Tent (Max 2)
                                                <span class="package-option-price">600,000 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="radio" name="exhibitor_package" id="shared_tent_5"
                                                value="shared_tent_5">
                                            <label for="shared_tent_5">Shared Tent (Max 5)
                                                <span class="package-option-price">300,000 UGX</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ====================== -->
                            <!-- Awards Dinner Gala Section -->
                            <!-- ====================== -->
                            <div class="col-md-12 form-section">
                                <h3 class="form-section-header">BUBU AWARDS GALA DINNER</h3>
                                <p>Select your preferred dinner package options below:</p>
                                <div class="form-group mt-3">
                                    <div class="package-options package-grid package-grid-3">
                                        <div class="package-option">
                                            <input type="radio" name="dinner_package" id="dinner_table_10"
                                                value="table_10">
                                            <label for="dinner_table_10">Table for 10 people
                                                <span class="package-option-price">1,000,000 UGX per table</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="radio" name="dinner_package" id="dinner_table_5"
                                                value="table_5">
                                            <label for="dinner_table_5">Table for 5 people
                                                <span class="package-option-price">500,000 UGX per table</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="radio" name="dinner_package" id="dinner_individual"
                                                value="individual">
                                            <label for="dinner_individual">Individual ticket
                                                <span class="package-option-price">100,000 UGX per ticket</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ====================== -->
                            <!-- Magazine Space Section -->
                            <!-- ====================== -->
                            <div class="col-md-12 form-section">
                                <h3 class="form-section-header">Magazine Space</h3>
                                <p>Select your preferred magazine advertising options below:</p>
                                <div class="form-group mt-3">
                                    <div class="package-options package-grid package-grid-7">
                                        <div class="package-option">
                                            <input type="checkbox" name="magazine_back_cover" id="magazine_back_cover"
                                                value="1">
                                            <label for="magazine_back_cover">Back Cover
                                                <span class="package-option-price">4,672,800 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="checkbox" name="magazine_inside_cover"
                                                id="magazine_inside_cover" value="1">
                                            <label for="magazine_inside_cover">Inside Cover
                                                <span class="package-option-price">3,894,000 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="checkbox" name="magazine_page3" id="magazine_page3"
                                                value="1">
                                            <label for="magazine_page3">Page 3 (full)
                                                <span class="package-option-price">3,352,800 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="checkbox" name="magazine_full_page" id="magazine_full_page"
                                                value="1">
                                            <label for="magazine_full_page">Full Page
                                                <span class="package-option-price">2,336,400 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="checkbox" name="magazine_half_vertical"
                                                id="magazine_half_vertical" value="1">
                                            <label for="magazine_half_vertical">Half Page Vertical
                                                <span class="package-option-price">1,713,360 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="checkbox" name="magazine_half_horizontal"
                                                id="magazine_half_horizontal" value="1">
                                            <label for="magazine_half_horizontal">Half Page Horizontal
                                                <span class="package-option-price">1,401,840 UGX</span>
                                            </label>
                                        </div>
                                        <div class="package-option">
                                            <input type="checkbox" name="magazine_quarter" id="magazine_quarter"
                                                value="1">
                                            <label for="magazine_quarter">Quarter Page
                                                <span class="package-option-price">934,560 UGX</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="col-md-12 form-group mt-3">
                                <label for="message" class="form-label">Additional Information</label>
                                <textarea class="form-control" name="message" id="message" rows="5"
                                    placeholder="Tell us about your business needs"></textarea>
                                <span class="input-icon"><i class="fas fa-comment-dots"></i></span>
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Package selection
                const packageOptions = document.querySelectorAll('.package-option');
                packageOptions.forEach(option => {
                    option.addEventListener('click', function(e) {
                        // Only handle if not clicking on a button or input directly
                        if (!e.target.closest('.quantity-btn') && !e.target.closest(
                            '.quantity-input')) {
                            const radio = this.querySelector('input[type="radio"]');
                            const checkbox = this.querySelector('input[type="checkbox"]');

                            if (radio) {
                                // For radio buttons, deselect others in the same group
                                const groupName = radio.getAttribute('name');
                                document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                                    r.closest('.package-option').classList.remove('selected');
                                });
                                this.classList.add('selected');
                                radio.checked = true;
                            } else if (checkbox) {
                                // For checkboxes, just toggle the selection
                                this.classList.toggle('selected');
                                checkbox.checked = !checkbox.checked;
                            }
                        }
                    });
                });

                // Form animation
                const form = document.querySelector('.php-email-form');
                setTimeout(() => {
                    form.style.opacity = '1';
                }, 100);

                // Input focus effects
                const inputs = document.querySelectorAll('.form-control, .form-select');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('focused');
                    });

                    input.addEventListener('blur', function() {
                        this.parentElement.classList.remove('focused');
                    });
                });
            });
        </script>
    </main>
@endsection
