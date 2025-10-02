@extends('layouts.app')

@section('title', $project->title . ' - Case Study Details')

@section('content')
<!-- Gt Breadcrumb Section Start -->
<div class="gt-breadcrumb-wrapper bg-cover" style="background-image: url('{{ asset('assets/img/breadcrumb-bg.jpg') }}');">
    <div class="container">
        <div class="gt-page-heading">
            <div class="gt-breadcrumb-sub-title">
                <h1 class="wow fadeInUp" data-wow-delay=".3s">Case studies <span>Details</span></h1>
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
                    Case studies Details
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Project Details Section Start -->
<section class="project-details-section fix section-padding">
    <div class="container">
        <div class="project-details-wrapper">
            <div class="project-details-items">
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="details-top-items">
                            <div class="details-left">
                                <h2>{{ $project->title }}</h2>
                                <ul class="post-cat">
                                    @if($project->category)
                                    <li>
                                        <a href="javascript:void(0)">{{ $project->category }}</a>
                                    </li>
                                    @endif
                                    @if($project->technologies && count($project->technologies) > 0)
                                    @foreach(array_slice($project->technologies, 0, 3) as $tech)
                                    <li>
                                        <a href="javascript:void(0)">{{ $tech }}</a>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="details-right">
                                <ul class="client-details">
                                    @if($project->client)
                                    <li>
                                        Client: <span>{{ $project->client }}</span>
                                    </li>
                                    @endif
                                    @if($project->project_date)
                                    <li>
                                        Year: <span>{{ $project->project_date->format('Y') }}</span>
                                    </li>
                                    @endif
                                    @if($project->client)
                                    <li>
                                        Author: <span>{{ $project->client }}</span>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="project-details-content"> 
                <h3>Overview</h3>
                <div class="row g-4">
                    <div class="col-lg-7">
                        <p>
                            @if($project->description)
                                {{ Str::limit($project->description, 400) }}
                            @else
                                Nam posuere mauris enim, quis pretium elit placerat id Fusce egestas nisi vel ipsum vehicula facilisis In pulvinar imperdiet venenatis Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec eu pulvinar lorem. Etiam vestibulum ligula quis nisl feugiat, consectetur placerat augue vestibulum Nulla aliquam elit eu diam pharetra.
                            @endif
                        </p>
                    </div>
                    <div class="col-lg-5">
                        <p>
                            @if($project->challenge)
                                {{ Str::limit($project->challenge, 200) }}
                            @else
                                Fusce egestas nisi vel ipsum vehicula facilisis. In pulvinar imperdiet venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec eu pulvinar lorem. Etiam vestibulum ligula quis nisl feugiat, consectetur placerat augue vestibulum.
                            @endif
                        </p>
                    </div>
                </div>
                <h3 class="mt-5">Final Results Of the Project</h3>
                <div class="row g-5">
                    <div class="col-lg-7">
                        <div class="list-items">
                            <ul>
                                @if($project->solution)
                                    @foreach(explode('.', $project->solution) as $point)
                                        @if(trim($point))
                                            <li><span>{{ trim($point) }}</span></li>
                                        @endif
                                    @endforeach
                                @else
                                    <li><span>consectetur placerat augue vestibulum</span></li>
                                    <li><span>Mauris tincidunt a eget facilisis Quisque</span></li>
                                    <li><span>Lorem ipsum dolor sit amet, consectetur</span></li>
                                @endif
                            </ul>
                            <ul>
                                @if($project->result)
                                    @foreach(explode('.', $project->result) as $point)
                                        @if(trim($point))
                                            <li><span>{{ trim($point) }}</span></li>
                                        @endif
                                    @endforeach
                                @else
                                    <li><span>adipiscing elit Etiam aliquam, enim vitae</span></li>
                                    <li><span>Donec at augue ante Nam posuere mauris</span></li>
                                    <li><span>quis pretium elit placerat id Fusce egestas</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="progress-area">
                            <div class="progress-wrap">
                                @if($project->technologies && count($project->technologies) >= 2)
                                <div class="pro-items">
                                    <div class="pro-head">
                                        <h6 class="title">
                                            {{ $project->technologies[0] ?? 'Branding Design' }}
                                        </h6>
                                        <span class="point">
                                            86%
                                        </span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-value"></div>
                                    </div>
                                </div>
                                <div class="pro-items">
                                    <div class="pro-head">
                                        <h6 class="title">
                                            {{ $project->technologies[1] ?? 'Business' }}
                                        </h6>
                                        <span class="point">
                                            96%
                                        </span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-value style-two"></div>
                                    </div>
                                </div>
                                @else
                                <div class="pro-items">
                                    <div class="pro-head">
                                        <h6 class="title">
                                            Branding Design
                                        </h6>
                                        <span class="point">
                                            86%
                                        </span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-value"></div>
                                    </div>
                                </div>
                                <div class="pro-items">
                                    <div class="pro-head">
                                        <h6 class="title">
                                            Business
                                        </h6>
                                        <span class="point">
                                            96%
                                        </span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-value style-two"></div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-4 mt-4">
                    @if($project->gallery && count($project->gallery) >= 2)
                        <div class="col-md-6">
                            <div class="details-image">
                                <img src="{{ asset($project->gallery[0]) }}" alt="img">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="details-image">
                                <img src="{{ asset($project->gallery[1]) }}" alt="img">
                            </div>
                        </div>
                    @elseif($project->image)
                        <div class="col-md-6">
                            <div class="details-image">
                                <img src="{{ asset($project->image) }}" alt="img">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="details-image">
                                <img src="{{ asset($project->image) }}" alt="img">
                            </div>
                        </div>
                    @else
                        <div class="col-md-6">
                            <div class="details-image">
                                <img src="{{ asset('assets/img/case-studies/details-1.jpg') }}" alt="img">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="details-image">
                                <img src="{{ asset('assets/img/case-studies/details-2.jpg') }}" alt="img">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="slider-button d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-xxl-4 gap-3 gap-2">
                    @if($previousProject)
                    <a href="{{ route('project.detail', $previousProject->id) }}" class="cmn-prev cmn-border d-center">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="{{ route('project.detail', $previousProject->id) }}" class="fw-bold white-clr previus-text text-capitalize">
                        previous
                    </a>
                    @else
                    <button class="cmn-prev cmn-border d-center" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="fw-bold white-clr previus-text text-capitalize opacity-50">
                        previous
                    </span>
                    @endif
                </div>
                <div class="d-flex align-items-center gap-xxl-4 gap-3 gap-2">
                    @if($nextProject)
                    <a href="{{ route('project.detail', $nextProject->id) }}" class="fw-bold white-clr previus-text text-capitalize">
                        Next
                    </a>
                    <a href="{{ route('project.detail', $nextProject->id) }}" class="cmn-next cmn-border d-center">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    @else
                    <span class="fw-bold white-clr previus-text text-capitalize opacity-50">
                        Next
                    </span>
                    <button class="cmn-next cmn-border d-center" disabled>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
