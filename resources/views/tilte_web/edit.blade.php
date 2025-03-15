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
                <label for="ctnEmail"> نبذه عنا</label>
                <input type="text" name="about" value="{{ $titleWeb->about }}" placeholder="Some Text..."
                    class="form-input" required />
            </div>

            <div>
                <label for="ctnEmail">اهداف الملتقي</label>
                <input type="text" name="title_goals" value="{{ $titleWeb->title_goals }}" placeholder="Some Text..."
                    class="form-input" required />
            </div>



            <div>
                <label for="ctnEmail">الفئة المستهدفة</label>
                <input type="text" name="title_TargetGroup" value="{{ $titleWeb->title_TargetGroup }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>



            <div>
                <label for="ctnEmail"> كلمة عن المشرف</label>
                <input type="text" name="supervisor_speech" value="{{ $titleWeb->supervisor_speech }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>



            <div>
                <label for="ctnEmail">الجهة المنظمة</label>
                <input type="text" name="title_Organizer" value="{{ $titleWeb->title_Organizer }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>



            <div>
                <label for="ctnEmail">إدارة المنتدى</label>
                <input type="text" name="title_ForumManagement" value="{{ $titleWeb->title_ForumManagement }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>



            <div>
                <label for="ctnEmail">الشريك الاعلامي</label>
                <input type="text" name="title_MediaPartner" value="{{ $titleWeb->title_MediaPartner }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>


            <div>
                <label for="ctnEmail">ابرز المتحدثين</label>
                <input type="text" name="title_FeaturedSpeakers" value="{{ $titleWeb->title_FeaturedSpeakers }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>

            <div>
                <label for="ctnEmail">الرعايات</label>
                <input type="text" name="title_Sponsorships" value="{{ $titleWeb->title_Sponsorships }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>




            <div>
                <label for="ctnEmail">اخر الاخبار</label>
                <input type="text" name="title_LATEST_NEWS" value="{{ $titleWeb->title_LATEST_NEWS }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>

            <div>
                <label for="ctnEmail">معرض الصور</label>
                <input type="text" name="title_Gallery" value="{{ $titleWeb->title_Gallery }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>




            <div>
                <label for="ctnEmail"> معرض الفيديو</label>
                <input type="text" name="gallery_video" value="{{ $titleWeb->gallery_video }}"
                    placeholder="Some Text..." class="form-input" required />
            </div>


            <div>
                <label for="ctnEmail"> الشركاء</label>
                <input type="text" name="partners" value="{{ $titleWeb->partners }}" placeholder="Some Text..."
                    class="form-input" required />
            </div>



            <div>
                <label for="ctnEmail"> التسجيل</label>
                <input type="text" name="register_in" value="{{ $titleWeb->register_in }}" placeholder="Some Text..."
                    class="form-input" required />
            </div>



            <button type="submit" class="btn btn-primary !mt-6">تعديل</button>
        </form>
    </div>
@endsection
