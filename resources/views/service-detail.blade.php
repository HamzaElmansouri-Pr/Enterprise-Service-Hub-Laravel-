@extends('layouts.app')

@section('title', $service->title . ' - Service Details')
@section('meta_title', $service->meta_title ?: $service->title . ' | Nova Agency')
@section('meta_description', $service->meta_description ?: Str::limit(strip_tags($service->description), 160))
@section('og_image', resolve_image_url($service->og_image ?: $service->image))

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">Services <span>Details</span> </h1>
            </div>
            <ul class="gt-breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                <li>
                    <a href="{{ url('/') }}">
                        Home
                    </a>
                </li>
                <li>
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li>
                 Services Details 
                </li>
            </ul>
        </div>
    </div>
</div>

<section class="service-details-section section-padding">
    <div class="container">
        <div class="service-details-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="details-image">
                        <img src="{{ resolve_image_url($service->image ?? 'assets/img/inner/service/service-details-1.jpg') }}" alt="{{ $service->title }}">
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-12 col-lg-4">
                    <div class="main-sidebar sticky-style">
                        <div class="single-sidebar-widget">
                            <div class="wid-title">
                                <h4>All Services</h4>
                            </div>
                            <div class="service-widget-categories">
                                <ul>
                                    @if($allServices && $allServices->count() > 0)
                                        @foreach($allServices as $serviceItem)
                                        <li class="{{ $serviceItem->id == $service->id ? 'active' : '' }}">
                                            <a href="{{ route('services.show', $serviceItem) }}">{{ $serviceItem->title }}</a>
                                            <span><i class="fa-regular fa-arrow-right-long"></i></span>
                                        </li>
                                        @endforeach
                                    @else
                                        <li><a href="{{ route('services') }}">Web Development</a> <span><i class="fa-regular fa-arrow-right-long"></i></span></li>
                                        <li><a href="{{ route('services') }}">Content Marketing</a> <span><i class="fa-regular fa-arrow-right-long"></i></span></li>
                                        <li class="active"><a href="javascript:void(0)">{{ $service->title }}</a><span><i class="fa-regular fa-arrow-right-long"></i></span></li>
                                        <li><a href="{{ route('services') }}">Affiliate Marketing</a> <span><i class="fa-regular fa-arrow-right-long"></i></span></li>
                                        <li><a href="{{ route('services') }}">Search Engine Marketing (SEM)</a> <span><i class="fa-regular fa-arrow-right-long"></i></span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="service-details-content">
                        <h3>
                            {{ $service->title }}
                        </h3>
                        <p class="mb-4">
                            @if($service->description)
                                {{ Str::limit($service->description, 300) }}
                            @else
                                At tempus aenean sapien torquent sed diam class efficitur mus morbi eros dictum quam augue ac laor eet ligula libero mi commodo nibh hac fermentum orci ad pharetra consequat justo duis turpis lorem elit dui consectetur magnis lacinia odio per placerat vestibulum volutpat mauris mollis primis imperdiet posu ere ex enim gravida cras congue
                            @endif
                        </p>
                        <p class="mb-4">
                            @if($service->subtitle)
                                {{ $service->subtitle }}
                            @else
                                pellentesque vulputate malesuada dictumst fames interdum cursus an te tellus porta ullamcorper accumsan non eu adipiscing integer venenatis sagittis arcu curae finibus ridi culus aliquam velit lobortis senectus vitae sollicitudin sit consectetuer ultricies rutrum parturient pede nisi nascetur habitant netus quisque elementum inceptos nam felis penatibus feugiat
                            @endif
                        </p>
                        <h3>
                            What We Provide
                        </h3>
                        <p class="mb-5">
                            @if($service->description && strlen($service->description) > 300)
                                {{ Str::substr($service->description, 300) }}
                            @else
                                At tempus aenean sapien torquent sed diam class efficitur mus morbi eros dictum quam augue ac laor eet ligula libero mi commodo nibh hac fermentum orci ad pharetra consequat justo duis turpis lorem elit dui consectetur magnis lacinia odio per placerat vestibulum volutpat mauris mollis primis imperdiet posu ere ex enim gravida cras congue
                            @endif
                        </p>
                        <div class="thumb">
                            <img src="{{ resolve_image_url($service->image ?? 'assets/img/inner/service/service-details-2.jpg') }}" alt="{{ $service->title }}">
                        </div>
                        <h3>
                            The Challange
                        </h3>
                        <p>
                            @if($service->description)
                                {{ Str::limit($service->description, 400) }}
                            @else
                                At tempus aenean sapien torquent sed diam class efficitur mus morbi eros dictum quam augue ac laor eet ligula libero mi commodo nibh hac fermentum orci ad pharetra consequat justo duis turpis lorem elit dui consectetur magnis lacinia odio per placerat vestibulum volutpat mauris mollis primis imperdiet posu ere ex enim gravida cras congue
                            @endif
                        </p>
                        <div class="details-list-items">
                            @if($service->features && count($service->features) > 0)
                            <ul class="details-list">
                                @foreach(array_slice($service->features, 0, 2) as $feature)
                                <li><i class="fa-solid fa-circle-check"></i>{{ $feature }}</li>
                                @endforeach
                            </ul>
                            <ul class="details-list">
                                @foreach(array_slice($service->features, 2, 2) as $feature)
                                <li><i class="fa-solid fa-circle-check"></i>{{ $feature }}</li>
                                @endforeach
                            </ul>
                            @else
                            <ul class="details-list">
                                <li><i class="fa-solid fa-circle-check"></i>Various analysis options.</li>
                                <li><i class="fa-solid fa-circle-check"></i>Advance Data analysis operation.</li>
                            </ul>
                            <ul class="details-list">
                                <li><i class="fa-solid fa-circle-check"></i>Page Load (time, size, number of requests).</li>
                                <li><i class="fa-solid fa-circle-check"></i>Advance Data analysis operation.</li>
                            </ul>
                            @endif
                        </div>
                    </div>
                    <div class="gt-faq-wrapper mt-5">
                    <div class="accordion style-inner" id="accordionExample2">
                        <div class="accordion-item wow fadeInUp" data-wow-delay=".3s">
                            <h2 class="accordion-header" id="headingOne1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                                    What is {{ $service->title }}?
                                </button>
                            </h2>
                            <div id="collapseOne1" class="accordion-collapse collapse" aria-labelledby="headingOne1" data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    <p>
                                        @if($service->description)
                                            {{ Str::limit($service->description, 200) }}
                                        @else
                                            There are many variations of passages of Lorem Ipsum available, but the majority have suffered. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia,
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item wow fadeInUp" data-wow-delay=".5s">
                            <h2 class="accordion-header" id="headingfour2">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefour2" aria-expanded="true" aria-controls="collapsefour2">
                                    Do we offer a free consultation?
                                </button>
                            </h2>
                            <div id="collapsefour2" class="accordion-collapse collapse show" aria-labelledby="headingfour2" data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                     <p>
                                        Yes, we offer free consultations to understand your requirements and provide the best solution for your {{ strtolower($service->title) }} needs. Contact us to schedule a discovery call and let's discuss how we can help your business grow.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item wow fadeInUp" data-wow-delay=".7s">
                            <h2 class="accordion-header" id="headingTwo3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo3" aria-expanded="false" aria-controls="collapseTwo3">
                                    Is the delivered solution original?
                                </button>
                            </h2>
                            <div id="collapseTwo3" class="accordion-collapse collapse" aria-labelledby="headingTwo3" data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                     <p>
                                        Absolutely! We create custom solutions tailored specifically to your business needs and requirements. Every solution is built from scratch to ensure originality, quality, and perfect alignment with your business objectives and brand identity.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item wow fadeInUp" data-wow-delay=".3s">
                            <h2 class="accordion-header" id="headingthree4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree4" aria-expanded="false" aria-controls="collapsethree4">
                                    Do you have ongoing support?
                                </button>
                            </h2>
                            <div id="collapsethree4" class="accordion-collapse collapse" aria-labelledby="headingthree4" data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                     <p>
                                        Yes, we provide comprehensive ongoing support and maintenance services to ensure your {{ strtolower($service->title) }} solution continues to perform optimally. Our support includes regular updates, troubleshooting, and technical assistance as needed.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item wow fadeInUp" data-wow-delay=".5s">
                            <h2 class="accordion-header" id="headingthree1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree1" aria-expanded="false" aria-controls="collapsethree1">
                                    How long would it take to complete the project?
                            </button>
                            </h2>
                            <div id="collapsethree1" class="accordion-collapse collapse" aria-labelledby="headingthree1" data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                     <p>
                                        Project timelines vary based on complexity and scope. Typically, our {{ strtolower($service->title) }} projects take anywhere from 2-12 weeks depending on requirements. We'll provide you with a detailed timeline during our initial consultation.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

