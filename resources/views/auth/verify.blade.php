@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-lg-8 col-md-12 col-sm-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-4">Forms</h5>

                        <form id="form">
                            <div>
                                <p id="message"></p>
                                <ol id="errors"></ol>
                            </div>
                            <div class="alert alert-info">
                                A code was sent to your email address, please enter it to proceed with verification of your email address.
                            </div>

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Enter Code</label>
                                        <input type="number" name="code" class="form-control"
                                            aria-describedby="">
                                        <div id="" class="form-text">We'll never share your email with anyone else.
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/verification.js') }}"></script>
@endsection
