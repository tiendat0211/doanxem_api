@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <!-- Page -->
    <script src="/assets/js/Site.js"></script>
    <script src="/assets/global/js/Plugin/asscrollable.js"></script>
    <script src="/assets/global/js/Plugin/slidepanel.js"></script>
    <script src="/assets/global/js/Plugin/switchery.js"></script>
    <script src="/assets/global/js/Plugin/datatables.js"></script>
    <script src="/assets/examples/js/tables/datatable.js"></script>
@endsection
