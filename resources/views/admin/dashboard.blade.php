@extends('admin.layouts.admin')

@section('title', __('views.admin.dashboard.title'))

@section('content')
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-user-o"></i></div>
                <div class="count">{{ $total_users  }}</div>
                <h3>Total Users</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-tags"></i></div>
                <div class="count">{{ $total_posts  }}</div>
                <h3>Total Posts</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-comments"></i></div>
                <div class="count">{{ $total_comments  }}</div>
                <h3>Total Comments</h3>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-thumbs-o-up"></i></div>
                <div class="count">{{ $total_likes_dislikes  }}</div>
                <h3>Total Likes/Dislikes</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Posts Per Day</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-sm-12 col-xs-12">
                        <div class="demo-container" style="height:280px">
                            <div id="chart_plot_posts" class="demo-placeholder"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script type="text/javascript">
        var posts_chart_data = {!! json_encode($posts_chart_data) !!};
    </script>
    {{ Html::script(mix('/assets/admin/js/dashboard.js')) }}
@endsection