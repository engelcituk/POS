@extends('layouts.app')

@section('content')
<div class="full-page login-page" filter-color="black" data-image="{{asset('img/login.jpg')}}">
    <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 text-center">
                    <!-- <h2 class="title">Pick the best plan for you</h2> -->

                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-pricing card-plain">
                        <div class="card-content">
                            <h6 class="category">Freelancer</h6>
                            <div class="icon">
                                <i class="material-icons">weekend</i>
                            </div>
                            <!-- <h3 class="card-title">FREE</h3>
                            <p class="card-description">
                                This is good if your company size is between 2 and 10 Persons.
                            </p> -->
                            <!-- <a href="#pablo" class="btn btn-white btn-round">Choose Plan</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-pricing card-plain">
                        <div class="card-content">
                            <h6 class="category">Small Company</h6>
                            <div class="icon icon-rose">
                                <i class="material-icons">home</i>
                            </div>
                            <!-- <h3 class="card-title">$29</h3>
                            <p class="card-description">
                                This is good if your company size is between 2 and 10 Persons.
                            </p> -->
                            <!-- <a href="#pablo" class="btn btn-rose btn-round">Choose Plan</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-pricing card-plain">
                        <div class="card-content">
                            <h6 class="category">Medium Company</h6>
                            <div class="icon">
                                <i class="material-icons">business</i>
                            </div>
                            <!-- <h3 class="card-title">$69</h3>
                            <p class="card-description">
                                This is good if your company size is between 11 and 99 Persons.
                            </p> -->
                            <!-- <a href="#pablo" class="btn btn-white btn-round">Choose Plan</a> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-pricing card-plain">
                        <div class="card-content">
                            <h6 class="category">Enterprise</h6>
                            <div class="icon">
                                <i class="material-icons">account_balance</i>
                            </div>
                            <!-- <h3 class="card-title">$159</h3>
                            <p class="card-description">
                                This is good if your company size is 99+ persons.
                            </p> -->
                            <!-- <a href="#pablo" class="btn btn-white btn-round">Choose Plan</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <nav class="pull-left">
                <ul>
                    <li>
                        <a href="#">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Company
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Portfolio
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Blog
                        </a>
                    </li>
                </ul>
            </nav>
            <p class="copyright pull-right">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>
                <a href="#">Ecituk</a>, the best TPV from the web
            </p>
        </div>
    </footer>
</div>

@endsection 