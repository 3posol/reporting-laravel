@extends('layouts.app')
<?php //var_dump($_POST);//dd($_POST); ?>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Move Mountains Admin Page</h1>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{--START block upload csv--}}
                    <div class="block-upload-csv">
                        <div class="card-body">
                            <form action="{{ route('saveCsvFile') }}" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class='row'>
                                        <div class="col-10">
                                            <div class="custom-file">
                                                <input type="file" name="csv_file" class="custom-file-input"
                                                       id="csv-file" required>
                                                <label class="custom-file-label" for="csv-file">Choose CSV
                                                    file...</label>
                                            </div>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </div>
                                        <div class='col-2'>
                                            <button type="submit" class="btn btn-success">Parse CSV</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            {{--END block upload csv--}}

                            {{--START block mailing--}}
                            <div class="block-mailing row">
                                <div class="col-10">
                                @if(@isset($companies))
                                    <form action="" id="mailing-list" method="POST">
                                        <div class="form-row d-flex align-items-end">
                                            <div class="form-group col-4">
                                                <label for="id-company">Сhoose company</label>
                                                <select class="form-control" name="company_id" id="id-company">
                                                    @foreach($companies as $company)
                                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group ml-3">
                                                <button class="btn btn-primary">Send</button>
                                            </div>

                                            <div class="form-group ml-auto">
                                                <button class="btn btn-outline-danger">Remove company</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div>Companies list is empty!</div>
                                @endif
                                </div>
                            </div>
                            {{--END block mailing--}}

                            {{--START block participant list--}}
                            <div class="block-participant-list row">
                                <div class="list col-10">
                                    @if(@isset($participants))
                                        <table class="participant-list table table-striped">
                                            @foreach($participants as $key => $participant)
                                                <tr class="item-row-{{ $participant->id }}">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $participant->first_name }}</td>
                                                    <td>{{ $participant->last_name }}</td>
                                                    <td>{{ $participant->email }}</td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox"
                                                                   class="custom-control-input"
                                                                   id="self-refl-{{ $participant->id }}"
                                                                   name="self_reflection"
                                                                   value="{{ $participant->self_reflection }}"
                                                                   @if($participant->self_reflection == 1)
                                                                   checked="checked"
                                                                @endif
                                                            >
                                                            <label class="custom-control-label" for="self-refl-{{ $participant->id }}">Self Reflection</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                class="custom-control-input"
                                                                id="peer-refl-{{ $participant->id }}"
                                                                name="peer_reflection"
                                                                value="{{ $participant->peer_reflection }}"
                                                                @if($participant->peer_reflection == 1)
                                                                checked="checked"
                                                                @endif
                                                            >
                                                            <label class="custom-control-label" for="peer-refl-{{ $participant->id }}">Peer Reflection</label>
                                                        </div>
                                                    </td>
                                                    <td id="remove-participant" data-user-id="{{ $participant->id }}">
                                                        <button class="btn btn-outline-danger">Remove</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @else
                                        <div>Participant list is empty!</div>
                                    @endif
                                </div>
                            </div>
                            {{--END block participant list--}}

                            {{--START block add participant--}}
                            <div class="block-participant-add">
                                <div class="block-button btn btn-primary btn-lg">Add Participant</div>
                                <div class="participant-add">
                                    {{--START form for adding participant--}}
                                    @if(@isset($companies))
                                        <form action="{{ route('createParticipant') }}" id="participant-add"
                                              method="POST">
                                            <div class="form-row">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="form-group col-md-3">
                                                    <label for="company-id">Сhoose company</label>
                                                    <select class="form-control" name="company_id" id="company-id">
                                                        @foreach($companies as $company)
                                                            <option
                                                                value="{{ $company->id }}">{{ $company->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="user-first-name">Participant first name</label>
                                                    <input class="form-control" id="user-first-name" type="text"
                                                           name="first_name">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="user-last-name">Participant last name</label>
                                                    <input class="form-control" id="user-last-name" type="text"
                                                           name="last_name">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="user-name">Participant email</label>
                                                    <input class="form-control" id="user-email" type="text" name="email"
                                                           placeholder="name@example.com">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <input class="" type="checkbox" id="self-reflection"
                                                           name="self_reflection" value="1">
                                                    <label class="form-check-label" for="self-reflection">Self
                                                        Reflection</label>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="" type="checkbox" id="peer-reflection"
                                                           name="peer_reflection" value="1">
                                                    <label class="form-check-label" for="peer-reflection">Peer
                                                        Reflection</label>
                                                </div>
                                            </div>
                                            <button type="submit" onSubmit="document.orderform1.reset()"
                                                    class="btn btn-primary">Add new Participant
                                            </button>
                                        </form>
                                    @else
                                        <div>Companies list is empty!</div>
                                    @endif
                                    {{--END form for adding participant--}}
                                </div>
                            </div>
                        </div>
                        {{--END block add participant--}}


                        {{--<div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif


                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
@endsection