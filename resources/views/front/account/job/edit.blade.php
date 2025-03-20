@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Post a Job</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                <form method="POST" action="{{ route('account.updateJob', ['jobId' => $job->id]) }}" id="updateJobForm" name="updateJobForm">
                    @csrf
                    @method('PUT')

                    <div class="card border-0 shadow mb-4 ">
                        @include('front.message')
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Job Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                                    <input type="text" value="{{ $job->title }}" placeholder="Job Title" id="title" name="title" class="form-control">
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="">Select</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option {{ ($job->category_id == $category->id) ? 'selected' 
                                                : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                    <select name="job_nature_id" id="job_nature" class="form-control">
                                        <option value="">Select</option>
                                        @if ($job_natures->isNotEmpty())
                                            @foreach ($job_natures as $job_nature)
                                                <option {{ ($job->job_nature_id == $job_nature->id) ? 'selected' 
                                                : '' }} value="{{ $job_nature->id }}">{{ $job_nature->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6  mb-4">
                                    <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                    <input type="number" value="{{ $job->vacancy }}" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Salary</label>
                                    <input type="text" value="{{ $job->salary }}" placeholder="Salary" id="salary" name="salary" class="form-control">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location<span class="req">*</span></label>
                                    <input type="text" value="{{ $job->location }}" placeholder="location" id="location" name="location" class="form-control">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ $job->description }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Benefits</label>
                                <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Responsibility</label>
                                <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Qualifications</label>
                                <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ $job->qualifications }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Experience</label>
                                <select name="experience" id="experience" class="form-control">
                                    <option value="1" {{ ($job->experience == 1) ? 'selected' : '' }}>1 Year</option>
                                    <option value="2" {{ ($job->experience == 2) ? 'selected' : '' }}>2 Years</option>
                                    <option value="3" {{ ($job->experience == 3) ? 'selected' : '' }}>3 Years</option>
                                    <option value="4" {{ ($job->experience == 4) ? 'selected' : '' }}>4 Years</option>
                                    <option value="5" {{ ($job->experience == 5) ? 'selected' : '' }}>5 Years</option>
                                    <option value="6" {{ ($job->experience == 6) ? 'selected' : '' }}>6 Years</option>
                                    <option value="7" {{ ($job->experience == 7) ? 'selected' : '' }}>7 Years</option>
                                    <option value="8" {{ ($job->experience == 8) ? 'selected' : '' }}>8 Years</option>
                                    <option value="9" {{ ($job->experience == 9) ? 'selected' : '' }}>9 Years</option>
                                    <option value="10" {{ ($job->experience == 10) ? 'selected' : '' }}>10 Years</option>
                                    <option value="10_plus" {{ ($job->experience == '10_plus') ? 'selected' : '' }}>10+ Years</option>
                                </select>
                            </div>
                            
                            

                            <div class="mb-4">
                                <label for="" class="mb-2">Keywords</label>
                                <input type="text" value="{{ $job->keywords }}" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                            </div>

                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Name<span class="req">*</span></label>
                                    <input type="text" value="{{ $job->company_name }}" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location</label>
                                    <input type="text" value="{{ $job->company_location }}" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="" class="mb-2">Website</label>
                                <input type="text" value="{{ $job->website }}" placeholder="Website" id="website" name="website" class="form-control">
                            </div>
                        </div> 
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update Job</button>
                        </div>               
                    </div>
            </form>
        </div>
        </div>
    </div>
</section>

@endsection