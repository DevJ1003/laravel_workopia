@extends('front.layouts.app')

@section('main')

<section class="section-4 bg-2">    
    <div class="container pt-5">
        @include('front.message')
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('jobs') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{ $job->title }}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p> <i class="fa fa-map-marker"></i> {{ $job->location }}</p>
                                        </div>
                                        <div class="location">
                                            <p> <i class="fa fa-clock-o"></i> {{ $job->jobNature->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jobs_right">
                                <div class="apply_now">
                                    <a class="heart_mark" href="#"> <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Job description</h4>
                            {!! nl2br($job->description) !!}
                        </div>
                        <div class="single_wrap">
                            <ul>
                                @if (!empty($job->responsibility))
                                <h4>Responsibility</h4>
                                    {!! nl2br($job->responsibility) !!}
                                @endif
                            </ul>
                        </div>
                        <div class="single_wrap">
                            <ul>
                                @if (!empty($job->qualifications))
                                <h4>Qualifications</h4>
                                    {!! nl2br($job->qualifications) !!}
                                @endif
                            </ul>
                        </div>
                        <div class="single_wrap">
                            @if (!empty($job->benefits))
                            <h4>Benefits</h4>
                                    {!! nl2br($job->benefits) !!}
                                @endif
                        </div>
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">
                            {{-- @if (Auth::check())
                                <form id="applyForm" action="{{ route('jobApply', ['id' => $job->id]) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" onclick="confirmApply(event)" class="btn btn-primary">Apply</a>
                            @else
                                <a href="javascript:void(0);" class="btn btn-primary disabled">Login to Apply</a>
                            @endif --}}
                            @if (Auth::check())
                            @php
                                $userId = Auth::id();
                                $hasApplied = \App\Models\JobApplication::where('user_id', $userId)->where('job_id', $job->id)->exists();
                                $hasSaved = \App\Models\SavedJob::where('user_id', $userId)->where('job_id', $job->id)->exists();
                            @endphp
                        
                            @if ($hasApplied && $hasSaved)
                                <a class="btn btn-primary" disabled>
                                    <i class="fa fa-check"></i> Saved
                                </a>
                                <a class="btn btn-primary" disabled>
                                    <i class="fa fa-check"></i> Applied
                                </a>
                            @else
                                <form id="saveForm" action="{{ route('jobSave', ['id' => $job->id]) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" onclick="confirmSave(event)" class="btn btn-primary">Save</a>
                        
                                <form id="applyForm" action="{{ route('jobApply', ['id' => $job->id]) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" onclick="confirmApply(event)" class="btn btn-primary">Apply</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Login to Save</a>
                            <a href="{{ route('login') }}" class="btn btn-primary">Login to Apply</a>
                        @endif                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Job Summary</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span>{{  \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</span></li>
                                <li>Vacancy: <span>{{ $job->vacancy }} Position</span></li>
                                @if (!empty($job->salary))
                                    <li>Salary: <span>{{ $job->salary }}</span></li>
                                @endif
                                <li>Location: <span>{{ $job->location }}</span></li>
                                <li>Job Nature: <span> {{ $job->jobNature->name }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Company Details</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Name: <span>{{ $job->company_name }}</span></li>
                                @if (!empty($job->company_location))
                                    <li>Location: <span>{{ $job->company_location }}</span></li>
                                @endif
                                @if (!empty($job->website))
                                    <li>Website: <span><a href="{{ $job->website }}">{{ $job->website }}</a></span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<script>
    function confirmApply(event) {
        event.preventDefault();
        if (confirm('Are you sure you want to apply for this job?')) {
            document.getElementById('applyForm').submit();
        }
    }

    function confirmSave(event) {
        event.preventDefault();
        if (confirm('Are you sure you want to save this job?')) {
            document.getElementById('saveForm').submit();
        }
    }
</script>
@endsection
