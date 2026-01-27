@extends('layouts.app')

@section('title', 'Contact Us - Nova Agency')

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">Contact <span>Us</span></h1>
            </div>
            <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                <li>
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                 Contact Us
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Contact Info Section Start (styled like contact.html) -->
<section class="contact-info-section fix section-padding">
	<div class="container">
		<div class="row g-4">
			<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".3s">
				<div class="contact-info-items text-center active">
					<div class="icon">
						<i class="fa-solid fa-location-dot"></i>
					</div>
					<div class="content">
						<h3>Our Address</h3>
						<p>{{ optional($page)->contact_address ?? '123 Business Street, City, State 12345' }}</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".5s">
				<div class="contact-info-items text-center">
					<div class="icon">
						<i class="fa-solid fa-envelopes"></i>
					</div>
					<div class="content">
						<h3>
							<a href="mailto:{{ optional($page)->contact_email ?? 'test@gmail.com' }}">{{ optional($page)->contact_email ?? 'test@gmail.com' }}</a>
						</h3>
						<p>Email us anytime for any kind of query.</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".7s">
				<div class="contact-info-items text-center">
					<div class="icon">
						<i class="fa-solid fa-phone-volume"></i>
					</div>
					<div class="content">
						<h3>Hot: <a href="tel:{{ preg_replace('/[^\d\+]/', '', optional($page)->contact_phone ?? '+1 (555) 123-4567') }}">{{ optional($page)->contact_phone ?? '+1 (555) 123-4567' }}</a></h3>
						<p>Call us for any kind of support.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Contact Section Start -->
<section class="contact-section-33 fix section-padding pt-0">
    <div class="container">
        <div class="gt-section-title style-3 text-center">
            <h6 class="wow fadeInUp tt-capitalize">get in touch</h6>
            <h2 class="char-animation">
                Ready to get started?
            </h2>
            <p class="mt-3 wow fadeInUp" data-wow-delay=".3s">
                Contact us today to learn more about how Nova Agency can help your business grow.
            </p>
        </div>
        
		<div class="row g-4 align-items-stretch">
			<div class="col-lg-6">
				<div class="map-items mb-4 mb-lg-0 h-100">
					<div class="googpemap h-100">
							<iframe src="https://www.google.com/maps?q={{ urlencode(optional($page)->contact_address ?? '123 Business Street, City, State 12345') }}&output=embed" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
					</div>
				</div>
			</div>
			<div class="col-lg-6 d-flex">
				<div class="gt-contact-form flex-grow-1">
                    <!-- Contact Form Tabs -->
                    <div class="contact-tabs mb-4">
                        <ul class="nav nav-tabs" id="contactTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                    General Inquiry
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab">
                                    Service Request
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="contactTabsContent">
                        <!-- General Contact Form -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <form action="{{ route('contact.submit') }}" method="POST" id="contact-form" class="contact-form-items">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6 wow fadeInUp" data-wow-delay=".3s">
                                        <div class="form-clt">
                                            <input type="text" id="name" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 wow fadeInUp" data-wow-delay=".5s">
                                        <div class="form-clt">
                                            <input type="email" id="email" name="email" placeholder="Your Email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 wow fadeInUp" data-wow-delay=".7s">
                                        <div class="form-group">
                                            <input type="tel" name="phone" placeholder="Your Phone" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 wow fadeInUp" data-wow-delay=".9s">
                                        <div class="form-group">
                                            <input type="text"  name="subject" placeholder="Subject" value="{{ old('subject') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 wow fadeInUp" data-wow-delay=".9s">
                                        <div class="form-group">
                                            <textarea name="message" id="message" placeholder="Your Message" rows="5" required>{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 wow fadeInUp" data-wow-delay=".9s">
                                        <button type="submit" class="gt-theme-btn">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Service Request Form -->
                        <div class="tab-pane fade" id="service" role="tabpanel">
                            <form action="{{ route('tc-request.submit') }}" method="POST" enctype="multipart/form-data" class="contact-form-items">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-12 wow fadeInUp" data-wow-delay=".3s">
                                        <div class="form-clt">
                                            <input type="email" name="email" placeholder="Your Email Address" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="service_id">
                                                <option value="">Select a Service (Optional)</option>
                                                @foreach($services as $service)
                                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea name="description" placeholder="Describe your project requirements in detail..." rows="5" required>{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="attached_file" class="form-label">Attach Files (Optional)</label>
                                            <input type="file" name="attached_file" accept=".pdf,.doc,.docx,.txt">
                                            <small class="form-text text-muted">Supported formats: PDF, DOC, DOCX, TXT (Max 10MB)</small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="gt-theme-btn">Submit Request</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Contact/TC unified form styling */
.contact-form-items .form-clt,
.contact-form-items .form-group {
    display: block;
}
.contact-form-items .form-clt input,
.contact-form-items .form-clt select,
.contact-form-items .form-clt textarea,
.contact-form-items .form-group input,
.contact-form-items .form-group select,
.contact-form-items .form-group textarea {
    width: 100%;
    border: 1px solid #e6e9f2;
    background-color: #ffffff;
    color: #0f172a;
    border-radius: 12px;
    padding: 12px 14px;
    transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
}
.contact-form-items .form-clt textarea,
.contact-form-items .form-group textarea {
    min-height: 140px;
    resize: vertical;
}
.contact-form-items .form-clt input::placeholder,
.contact-form-items .form-clt textarea::placeholder,
.contact-form-items .form-group input::placeholder,
.contact-form-items .form-group textarea::placeholder {
    color: #94a3b8;
}
.contact-form-items .form-clt input:focus,
.contact-form-items .form-clt select:focus,
.contact-form-items .form-clt textarea:focus,
.contact-form-items .form-group input:focus,
.contact-form-items .form-group select:focus,
.contact-form-items .form-group textarea:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.18rem rgba(102, 126, 234, 0.20);
    outline: none;
}
/* File input */
.contact-form-items input[type="file"] {
    border: 1px dashed #d7dbe7;
    background-color: #fafbff;
    padding: 10px 12px;
}
.contact-form-items .form-text { color: #6b7280; }

/* Tabs alignment with theme */
.contact-tabs .nav-tabs {
    background: #fff;
    border-radius: 12px;
    padding: 6px;
    border: 1px solid #eef0f4;
}
.contact-tabs .nav-link {
    border: none;
    border-radius: 10px !important;
    color: #0f172a;
    padding: 10px 16px;
}
.contact-tabs .nav-link.active {
    color: #fff !important;
    background: linear-gradient(135deg, #667eea 0%, #4f65ff 100%) !important;
}

/* Submit buttons */
.contact-form-items .gt-theme-btn {
    min-height: 48px;
    padding-left: 22px;
    padding-right: 22px;
}

/* Map and form panel sizing */
.map-items, .contact-panel, .gt-contact-form { height: 100%; }
.googpemap { height: 100%; }
.googpemap iframe { height: 100%; width: 100%; border-radius: 14px; }

@media (max-width: 991.98px) {
    .googpemap iframe { height: 320px; }
}
</style>
@endpush

