@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div
            class="flex items-center p-3.5 rounded text-success bg-success-light dark:bg-success-dark-light text-align-center">
            {{ session('success') }}

        </div>
    @endif



    @if (session('error'))
        <div class="flex items-center p-3.5 rounded text-danger bg-danger-light dark:bg-danger-dark-light text-align-center">
            {{ session('error') }}

        </div>
    @endif


    <div class="container" style="width: 50%;">

        <!-- form controls -->
        <form class="space-y-5" method="POST" action="{{ route('title_web.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="ctnEmail">title_goals</label>
                <input type="text" name="title_goals" value="{{ $titleWeb->title_goals }}" placeholder="Some Text..."
                    class="form-input" required />
            </div>


            <div>
                <label for="ctnEmail">title_Sponsorships</label>
                <input type="text" name="title_Sponsorships" value="{{ $titleWeb->title_Sponsorships }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>

            <div>
                <label for="ctnEmail">title_Gallery</label>
                <input type="text" name="title_Gallery" value="{{ $titleWeb->title_Gallery }}" placeholder="Some Text..."
                    class="form-input" required />
            </div>

            <div>
                <label for="ctnEmail">title_FeaturedSpeakers</label>
                <input type="text" name="title_FeaturedSpeakers" value="{{ $titleWeb->title_FeaturedSpeakers }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>


            <div>
                <label for="ctnEmail">title_MediaPartner</label>
                <input type="text" name="title_MediaPartner" value="{{ $titleWeb->title_MediaPartner }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>


            <div>
                <label for="ctnEmail">title_TargetGroup</label>
                <input type="text" name="title_TargetGroup" value="{{ $titleWeb->title_TargetGroup }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>


            <div>
                <label for="ctnEmail">title_ForumManagement</label>
                <input type="text" name="title_ForumManagement" value="{{ $titleWeb->title_ForumManagement }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>

            <div>
                <label for="ctnEmail">title_Organizer</label>
                <input type="text" name="title_Organizer" value="{{ $titleWeb->title_Organizer }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>


            <div>
                <label for="ctnEmail">title_LATEST_NEWS</label>
                <input type="text" name="title_LATEST_NEWS" value="{{ $titleWeb->title_LATEST_NEWS }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>


            <button type="submit" class="btn btn-primary !mt-6">Submit</button>
        </form>
    </div>
@endsection
