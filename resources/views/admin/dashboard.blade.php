@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                {{-- @foreach($categories as $category)
                    <div class="col-lg-3 col-6">
                        @if($category->name === 'Blog')
                        <div class="small-box bg-info">
                        @elseif($category->name === 'Product')
                        <div class="small-box bg-success">
                        @elseif($category->name === 'Services')
                        <div class="small-box bg-warning">
                        @endif

                            <div class="inner">
                                <h3>{{ $categoryCounts[$category->name] }}</h3>
                                <p>{{ $category->name }}</p>
                            </div>
                            <div class="icon">
                                <!-- Add icons here based on your preference -->
                                @if($category->name === 'Blog')
                                    <i class="ion ion-ios-paper"></i>
                                @elseif($category->name === 'Product')
                                    <i class="ion ion-bag"></i>
                                @elseif($category->name === 'Services')
                                    <i class="ion ion-ios-moon"></i>
                                    <!-- Add more conditions for other categories if needed -->
                                @endif
                            </div>
                            <a href="{{ route('search.posts', ['keyword' => $category->name]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endforeach --}}
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            {{-- <h3>{{$gallery->count()}}</h3> --}}

                            <p>Gallery</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-camera"></i>
                            @php

                                @endphp

                        </div>
                        {{-- <a href="{{route('gallery.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>
                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                <div class="small-box text-white " style="background-color: #FF5F1F">
                                        <div class="inner">
                                            {{-- <h3>{{$inquiries->count()}}</h3> --}}

                                            <p>Inquiries</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-ios-chatbubble"></i>
                                            @php

                                                @endphp

                                        </div>
                                        {{-- <a href="{{route('inquiries.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box text-white " style="background-color: #9873AC">
                                        <div class="inner">
                                            {{-- <h3>{{$reviews->count()}}</h3> --}}

                                            <p>Reviews</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-ios-star"></i>
                                            @php

                                                @endphp

                                        </div>
                                        {{-- <a href="{{route('posts.postRatings')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                                    </div>
                                </div>
            </div>
        </div>
    </section>
@endsection


