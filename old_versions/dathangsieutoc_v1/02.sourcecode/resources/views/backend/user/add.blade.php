@extends('backend.layout')
@section('title', 'Thêm user')
@section('css')
    <link rel="stylesheet" href="{{ asset("backend/assets/css/bootstrap.min.css") }}"/>
    <link rel="stylesheet" href="{{ asset("backend/plugins/bootstrap-table/css/bootstrap-table.min.css") }}"/>
    <link rel="stylesheet" href="{{ asset("backend/plugins/jstree/style.css") }}"/>

    <link rel="stylesheet" href="{{ asset("backend/assets/css/icons.css") }}"/>
    <link rel="stylesheet" href="{{ asset("backend/assets/css/style.css") }}"/>
    <script src="{{ asset("backend/assets/js/modernizr.min.js") }}"></script>
@endsection

@section('content')

    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    {{--<a href="{{ action('Backend\NewsController@category') }}" class="btn btn-default">--}}
                    <i class="fa fa-plus"></i>
                </div>

                <h4 class="page-title">Thêm user</h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ action('Backend\UserController@index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Thêm user</li>
                </ol>

            </div>
        </div>
        <form method="post" class="form-add" action="{{ action('Backend\UserController@add') }}">
            @csrf
            <div class="row">

                <div class="col-lg-4 col-form">
                    <div class="card-box">
                        {{--<input type="hidden" id="id" name="id" value="{{ $term->id }}">--}}
                        <div class="form-group">
                            @include('backend.shared.flash-message')
                        </div>

                        <div class="form-group">
                            <label for="name">Username<span class="text-danger">*</span></label>
                            <input type="text" id="username" name="username" parsley-trigger="change" required
                                   placeholder="" class="form-control" value="{{ old('username') }}">
                        </div>

                        <div class="form-group">
                            <label for="slug">Email<span class="text-danger">*</span></label>
                            <input type="text" id="email" name="email" parsley-trigger="change" required
                                   placeholder="" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="form-group text-right m-b-0">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Thêm</button>
                        </div>

                        <input type="hidden" value="" name="list-roles" class="js-list-permission"/>

                    </div> <!-- end card-box -->


                </div>
                <!-- end col -->

                <div class="col-lg-8 col-grid">
                    <div class="card-box">
                        {{--role-list--}}
                        <h4 class="m-t-0 header-title">Danh sách roles</h4>
                        <hr>

                        <div id="checkTree"
                             class="jstree jstree-1 jstree-default jstree-checkbox-selection jstree-closed"
                             role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="j1_1"
                             aria-busy="false">
                            <ul class="jstree-container-ul jstree-children" role="group">
                                @foreach (\App\Role::getAllApi(Auth::user()) as $item)
                                    <li role="treeitem" aria-selected="false" aria-level="1"
                                        aria-labelledby="j1_1_anchor" aria-expanded="true" id="{{$item->id}}"
                                        class="jstree-node jstree-open">
                                        <i class="jstree-icon jstree-ocl" role="presentation"></i>
                                        <a class="jstree-anchor" href="#" tabindex="-1" id="j1_1_anchor-{{$item->id}}">
                                            <i class="jstree-icon jstree-checkbox jstree-undetermined"
                                               role="presentation"></i>
                                            <i class="jstree-icon jstree-themeicon fa fa-folder jstree-themeicon-custom"
                                               role="presentation"></i>
                                            {{ $item->name  }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </form>
        <!-- end row -->

    </div> <!-- container -->

@endsection

@section('javascript')
    <script>
        var resizefunc = [];
    </script>

    <script src="{{ asset("backend/assets/js/jquery.min.js") }}"></script>
    <script src="{{ asset("backend/assets/js/popper.min.js") }}"></script>
    <script src="{{ asset("backend/assets/js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("backend/assets/js/detect.js") }}"></script>
    <script src="{{ asset("backend/assets/js/fastclick.js") }}"></script>
    <script src="{{ asset("backend/assets/js/jquery.slimscroll.js") }}"></script>
    <script src="{{ asset("backend/assets/js/jquery.blockUI.js") }}"></script>
    <script src="{{ asset("backend/assets/js/waves.js") }}"></script>
    <script src="{{ asset("backend/assets/js/wow.min.js") }}"></script>
    <script src="{{ asset("backend/assets/js/jquery.nicescroll.js") }}"></script>
    <script src="{{ asset("backend/assets/js/jquery.scrollTo.min.js") }}"></script>

    <script src="{{ asset("backend/plugins/jstree/jstree.js") }}"></script>
    <script src="{{ asset("backend/plugins/bootstrap-table/js/bootstrap-table.js") }}"></script>

    <script src="{{ asset("backend/assets/pages/jquery.bs-table.js") }}"></script>
    <script src="{{ asset("backend/assets/pages/jquery.tree.js") }}"></script>

    <script src="{{ asset("backend/assets/js/jquery.core.js")}}"></script>
    <script src="{{ asset("backend/assets/js/jquery.app.js")}}"></script>

    @include('backend.shared.initjs')

    <script type="text/javascript">
        $(document).ready(function () {
            var role_list = [];
            $("#checkTree").bind("select_node.jstree", function (evt, data) {
                role_list = [];
                getPermissionList(evt, data);
            });

            $("#checkTree").on("deselect_node.jstree", function (evt, data) {
                role_list = [];
                getPermissionList(evt, data);
            });

            var getPermissionList = function (evt, data) {
                var selected = $('#checkTree').jstree("get_selected");
                var selected_arr = (selected + '').split(",");
                $.each(selected_arr, function (key, value) {
                    if (role_list.indexOf(value) < 0) {
                        role_list.push(value);
                    }
                });
                $('.js-list-permission').val(role_list.toString());
            };
            @if(Session::get('jsRoles') != null)
                <?php foreach(Session::get('jsRoles') as $node): ?>
                    $('.jstree').jstree(true).select_node('<?=$node?>');
                <?php endforeach;?>
            @endif

        });
    </script>
@endsection
