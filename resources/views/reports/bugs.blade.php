@extends('layouts.dashboard')

@section('title')
    Reports | BugTraq
@endsection


@section('content')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12">
                <div class="card" style="margin: 2rem;">
                    {!! $chart->container() !!}
                </div>
                <div class="card" style="margin: 2rem;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-9">

                                    <h4 class="card-title">Bugs Reports</h4>
                            </div>
                            <div class="col-md-3">
                                <a class="pull-right btn btn-primary btn-sm" href="{{url('pdfexport')}}">Export to PDF </a>
                            </div>
                        </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class=" text-primary">
                            <th>
                                Id
                            </th>
                            <th>
                                Priority
                            </th>
                            <th>
                                Bug Title
                            </th>

                            <th>
                                Created
                            </th>
                            <th>
                                Reporter
                            </th>
                            <th>
                                Dev Assigned
                            </th>
                            <th>
                                Due Date
                            </th>

                            <th>
                                Status
                            </th>
                            </thead>
                            <tbody>
                            @if(count($bugs) < 1)
                                <tr>
                                    <td colspan="3">No bugs found</td>
                                </tr>
                            @else
                            @foreach($bugs as $bug)
                                <tr>
                                    <td>{{$bug->id}}></td>
                                    <td>{{$bug->priority}}</td>
                                    <td>{{$bug->title}}</td>
                                    <td>{{$bug->created_at}}</td>
                                    <td>{{$bug->reporter}}</td>
                                    <td>{{$bug->assigned}}</td>
                                    <td>{{$bug->due_date}}</td>
                                    <td>{{$bug->status}}</td>
                                </tr>
                            @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

    {!! $chart->script() !!}
@endsection