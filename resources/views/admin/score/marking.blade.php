@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2>
                        Quản lý chấm điểm phần tự luận bài test
                    </h2>
                </div>
                <div class="col-sm-12">
                    @include('admin/_alert')
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <form method="post" action="{{ route('score.storingMarks') }}">
                            @csrf
                            <table class="table table-striped table-bordered table-hover table-condensed" id="marks">
                                <thead>
                                    <tr>
                                        <th>
                                            STT
                                        </th>
                                        <th>
                                            Câu hỏi
                                        </th>
                                        <th>
                                            Câu trả lời
                                        </th>
                                        <th>
                                            Điểm tối đa
                                        </th>
                                        <th>
                                            Chấm điểm
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userTestAnswers as $uta)
                                        <tr>
                                            <th>
                                                {{ $loop->iteration }}
                                            </th>
                                            <th>
                                                {{ $uta->content }}
                                            </th>
                                            <th>
                                                {{ $uta->answer }}
                                            </th>
                                            <th>
                                                {{ $uta->score }}
                                                <input type="hidden" value="{{ $uta->user_test_id }}" name="userTestId">
                                            </th>
                                            <th>
                                                <input type="number" min="0" required
                                                    name="marks[{{ $uta->id }}]" />
                                                @error('marks' . '[' . $uta->id . ']')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </th>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <button type="submit" class="btn btn-primary" title="Chấm điểm">
                                            Chấm điểm
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@stop
