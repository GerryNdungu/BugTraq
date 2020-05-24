@extends('layouts.dashboard')
@section('title')
    Bugs | BugTraq
@endsection

@section('content')

    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-9 col-lg-9 col-sm-9 pull-left">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="margin-left: 3rem;margin-top: 2rem">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h4 class="card-title">{{$bug->title}}</h4>

                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-12">
                                    <form class="form-horizontal" method="post" action="{{route('bugs.update',[$bug->id])}}">
                                        {{csrf_field() }}
                                        <input type="hidden" name="_method" value="put">
                                        <div class="form-body">
                                            <p style="margin-left: 1rem"><strong>Bug Information</strong></p>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Assigned To:</label>
                                                            <div class="col-md-7">
                                                                <p class="form-control-static"> {{$bug->assigned}} </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Due On:</label>
                                                            <div class="col-md-7">
                                                                <p class="form-control-static">{{$bug->due_date}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                </div>
                                                <!--/row-->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Project:</label>
                                                            <div class="col-md-7">
                                                                <p class="form-control-static">{{$bug->projects->pj_name}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Status:</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control" name="status" value="{{$bug->status}}">
                                                                    <option value="">...</option>
                                                                    <option value="Assigned">Assigned</option>
                                                                    <option value="In Progress (By Dev)">In Progress (By Dev)</option>
                                                                    <option value="In Review(By QA)">In Review(By QA)</option>
                                                                    @if(Auth::user()->user_group=='Test Engineer' || Auth::user()->user_group=='Developer')
                                                                    <option value="Approved" disabled>Approved</option>
                                                                    <option value="Complete" disabled>Complete</option>
                                                                    <option value="Deferred" disabled>Deferred</option>

                                                                    @else
                                                                        <option value="Approved">Approved</option>
                                                                        <option value="Complete">Complete</option>
                                                                        <option value="Deferred">Deferred</option>
                                                                        <option value="Rejected">Rejected</option>

                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->

                                                </div>
                                                <!--/row-->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Priority:</label>
                                                            <div class="col-md-7">
                                                                <p class="form-control-static">{{$bug->priority}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Classification:</label>
                                                            <div class="col-md-7">
                                                                <p class="form-control-static">{{$bug->type}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                </div>
                                                <!--/row-->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Created:</label>
                                                            <div class="col-md-7">
                                                                <p class="form-control-static">{{$bug->created_at}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Updated:</label>
                                                            <div class="col-md-7">
                                                                <p class="form-control-static">{{$bug->updated_at}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Description:</label>
                                                            <div class="col-md-7">
                                                                <p class="form-control-static">{{$bug->description}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--/span-->
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="form-actions">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-offset-3 col-md-9">
                                                                    <button type="submit" class="btn btn-danger"> <i class="fa fa-pencil"></i>Save Change</button>
                                                                    <button type="button" class="btn btn-dark">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"> </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                &nbsp;
                <!--For Bug Comments-->
              @include('partials.comments')

                <!--To add comments-->
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="margin-left: 3rem;">
                            <div class="card-header">
                                <h3 class="card-title">Add Comment</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                        <i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">

                                        <div class="row">
                                            <div class="col-12">
                                                <form method ="post" action="{{route('comments.store')}}">
                                                      {{csrf_field()}}

                                                    <input type="hidden" name="commentable_type" value="App\Bug">
                                                    <input type="hidden" name="commentable_id" value="{{$bug->id}}">

                                                    <div class="form-group">
                                                        <label for="comment-content">Comment.</label>
                                                        <textarea placeholder="Enter comment"
                                                                  style="resize: vertical"
                                                                  id="comment-content"
                                                                  name="body"
                                                                  rows="2" spellcheck="false"
                                                                  class="form-control autosize-target text-left">
                                                        </textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="comment-content">Proof of work done(Url/Photos)</label>
                                                        <textarea placeholder="Enter url of screenshots"
                                                                  style="resize:vertical"
                                                                  id="comment-content"
                                                                  name="url"
                                                                  rows="2" spellcheck="false"
                                                                  class="form-control autosize-target text-left">

                                                         </textarea>
                                                    </div>
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-primary"
                                                           value="Post"/>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!--Start of Sidebar-->
            <div class="col-sm-3 col-md-3 col-lg-3 pr-4 pt-5 pull-right">
                <div class="sidebar-module sidebar-module-inset">
                    <div class="sidebar-module">

                        <h4>Actions</h4>
                        <ol class="list-unstyled">
                            <li><a href="/bugs/{{$bug->id}}/edit"><i class="fas fa-edit"></i>Edit</a></li>

                            <br/>
                        </ol>
                        <h4>Team Members</h4>
                        <ol class="list-unstyled">

                        </ol>
                    </div>


                </div><!--end of sidebar-->
            </div>
            </div>




        </div><!-- end of major row-->



    </div><!--end of content wrapper -->
    <!--TODO:Check this go to top page-->
    <!--   <footer class="text-muted">
            <div class="container">
                <p class="float-center">
                    <a href="#">Back to top</a>
                </p>
                <p>Album example is © Bootstrap, but please download and customize it for yourself!</p>
                <p>New to Bootstrap? <a href="https://getbootstrap.com/">Visit the homepage</a> or read our <a href="/docs/4.2/getting-started/introduction/">getting started guide</a>.</p>
            </div>
        </footer>
    -->

@endsection
@section('scripts')
    <!-- <script src="../../assets/demo/demo.js"></script> -->

    <script src="../../../public/plugins/jquery/jquery.min.js"></script>
@endsection