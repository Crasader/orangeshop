<!DOCTYPE html>
<html>
<head>
    @include('admin.layouts._head')
    @section('head')
    @show
</head>
<body>
    <div id="wrapper">
        {{--左侧导航栏 开始--}}
        @include('admin.layouts._left_sidebar')
        {{--左侧导航栏 结束--}}
        <div id="page-wrapper" class="gray-bg dashbard-1">
            @include('admin.layouts._content_header')

            @section('content')
            @show

            @include('admin.layouts._footer')
        </div>
    </div>
    @include('admin.layouts._script')

    @section('script')
    @show
</body>
</html>