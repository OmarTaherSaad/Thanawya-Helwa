@extends('layouts.app')

@section('title',"إضافة كلية جديدة")
@section('scripts')
<script>
    let unis = new Array();
    let keys = new Array();
    $("#yw0 > div").find('img').each(function(i) {
        keys.push($(this).attr('src'));
    });
    $("#yw0 > div").find('h5 > a').each(function(i) {
        unis.push($(this).html());
    });
    let result = {};
    for (let index = 0; index < unis.length; index++) {
        result[keys[index]] = unis[index];
    }
    console.log(JSON.stringify(result));
</script>
@endsection
@section('content')
<div class="unis clearfix">
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/page/%D8%AC%D8%A7%D9%85%D8%B9%D8%A9_%D8%A7%D9%84%D9%82%D8%A7%D9%87%D8%B1%D8%A9">

                <img alt="" src="https://www.dbse.co/uploads/58568dff9a7e3.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a
                        href="/universities/page/%D8%AC%D8%A7%D9%85%D8%B9%D8%A9_%D8%A7%D9%84%D9%82%D8%A7%D9%87%D8%B1%D8%A9">
                        جامعة القاهرة </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/101">

                <img alt="" src="https://www.dbse.co/uploads/592c03965c44a.png" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/101">
                        جامعة عين شمس </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/102">

                <img alt="" src="https://www.dbse.co/uploads/592c1faae6d1e.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/102">
                        جامعة حلوان </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/103">

                <img alt="" src="https://www.dbse.co/uploads/592d31fb1e1d3.png" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/103">
                        جامعة بنها </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/104">

                <img alt="" src="https://www.dbse.co/uploads/592d47c2cf7b5.png" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/104">
                        جامعة طنطا </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/105">

                <img alt="" src="https://www.dbse.co/uploads/592d53c485a85.png" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/105">
                        جامعة المنوفية </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/106">

                <img alt="" src="https://www.dbse.co/uploads/592d611326fbf.png" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/106">
                        جامعة مدينة السادات </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/107">

                <img alt="" src="https://www.dbse.co/uploads/592d6c96ea767.png" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/107">
                        جامعة دمنهور </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/108">

                <img alt="" src="https://www.dbse.co/uploads/592d7d2af2dfb.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/108">
                        جامعة الزقازيق </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/109">

                <img alt="" src="https://www.dbse.co/uploads/592e865c168fb.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/109">
                        جامعة الإسكندرية </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/110">

                <img alt="" src="https://www.dbse.co/uploads/592e9f812fd14.png" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/110">
                        جامعة كفر الشيخ </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/111">

                <img alt="" src="https://www.dbse.co/uploads/592ea8607a048.png" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/111">
                        جامعة دمياط </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/112">

                <img alt="" src="https://www.dbse.co/uploads/592eadcfcc276.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/112">
                        جامعة المنصورة </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/113">

                <img alt="" src="https://www.dbse.co/uploads/592eb84429298.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/113">
                        جامعة قناة السويس </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/114">

                <img alt="" src="https://www.dbse.co/uploads/592ec4c518e26.png" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/114">
                        جامعة السويس </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/115">

                <img alt="" src="https://www.dbse.co/uploads/58569f56d986f.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/115">
                        جامعة بورسعيد </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/116">

                <img alt="" src="https://www.dbse.co/uploads/58569fe4b7b58.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/116">
                        جامعة الفيوم </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/117">

                <img alt="" src="https://www.dbse.co/uploads/5856a06567dcb.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/117">
                        جامعة بني سويف </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/118">

                <img alt="" src="https://www.dbse.co/uploads/592fe09d4dd1e.png" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/118">
                        جامعة المنيا </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/119">

                <img alt="" src="https://www.dbse.co/uploads/5856a0e2c72a9.gif" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/119">
                        جامعة أسيوط </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/120">

                <img alt="" src="https://www.dbse.co/uploads/5b573876027ef.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/120">
                        جامعة سوهاج </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/121">

                <img alt="" src="https://www.dbse.co/uploads/5856a1dee702f.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/121">
                        جامعة جنوب الوادي </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/122">

                <img alt="" src="https://www.dbse.co/uploads/5911aaef4e590.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/122">
                        جامعة أسوان </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/169">

                <img alt="" src="https://www.dbse.co/uploads/58568e90de8a3.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/169">
                        جامعة الأزهر - كليات البنين </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/170">

                <img alt="" src="https://www.dbse.co/uploads/58568ed798086.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/170">
                        جامعة الأزهر - كليات البنات </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
    <style>
        .post-content .post-title a {
            padding: 15px 5px;
            display: block;
        }

        .blog-grid .items .item.col-md-4 .post-content {
            padding: 0;
        }
    </style>
    <!-- post begin -->
    <article class="item col-md-4 col-sm-6">
        <div class="post-media place-thumbnail">
            <a href="/universities/80575">

                <img alt="" src="https://www.dbse.co/uploads/5b62bc18aee83.jpg" class="img-responsive">
            </a>
        </div>
        <div class="post-content">
            <div class="post-title entity-thumb-title">
                <h5>
                    <a href="/universities/80575">
                        جامعة العريش </a>
                </h5>
            </div>
        </div>
    </article>
    <!-- post close -->
</div>

    <div class="row my-1">
        <div class="col-12 col-md-auto">
            <a href="{{ route('faculty.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-alt-circle-right"></i>&nbsp; كل الكليات
            </a>
        </div>
    </div>
    <div class="row">  
        <div class="col-12 col-md-auto">
            <h2>إضافة كلية جديدة</h2>
        </div>
    </div>
    <div class="row justify-content-center mt-2"> 
        <div class="col-12 col-md-6">
            <form action="{{ route('faculty.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">اسم الكلية</label>
                    <input type="text" name="name" class="form-control"  placeholder="اسم الكلية" value="{{ old('name') }}"  required >
                </div>
                <div class="form-group">
                    <label for="common_name">الاسم الدارج</label>
                    <input type="text" name="common_name" class="form-control"  placeholder="اسم الكلية الدارج بين الناس" value="{{ old('common_name') }}"  required >
                </div>
                
                <div class="form-group">
                    <label for="year">عنوان الكلية</label>
                    <input type="text" name="address" class="form-control"  placeholder="عنوان الكلية" value="{{ old('address') }}"  required >
                </div>

                <div class="form-group">
                    <label for="sections_allowed">الشُعب المتاحة لهذه الكلية</label>
                    <select id="sections_allowed" class="custom-select" name="sections_allowed" multiple>
                        <option value="A" selected>أدبي</option>
                        <option value="O" selected>علمي علوم</option>
                        <option value="R" selected>علمي رياضة</option>
                        <option value="E">أزهر</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="universities">اختر الجامعات الموجودة فيها</label>
                    <select id="universities" class="custom-select" name="universities" multiple>
                        @foreach ($unis as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="{{ __('Submit') }}" />
                </div>
            </form>
        </div>
        
    </div>
    <div id="result"></div>
         
@endsection