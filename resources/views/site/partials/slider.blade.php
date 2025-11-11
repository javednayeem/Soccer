<div class="full-slider">
    <div id="carousel-example-generic" class="carousel slide">

        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
        </ol>

        <div class="carousel-inner" role="listbox">

            <div class="item active deepskyblue" data-ride="carousel" data-interval="1000">
                <div class="carousel-caption">
                    {{--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>--}}
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="slider-contant" data-animation="animated fadeInRight">
                            {{--<h3>If you Don’t Practice<br>You <span class="color-yellow">Don’t Derserve</span><br>to win!</h3>--}}
                            {{--<p class="text-center">Please practice regularly to get chance to play in team in the tournament.</p>--}}
                            {{--<a href="{{ route('event') }}" class="btn btn-primary btn-lg">Read More</a>--}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="item skyblue" data-ride="carousel" data-interval="1000">
                <div class="carousel-caption">
                    {{--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>--}}
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="slider-contant" data-animation="animated fadeInRight">
                            {{--<h3>If you Don’t Practice<br>You <span class="color-yellow">Don’t Derserve</span><br>to win!</h3>--}}
                            {{--<p class="text-center">You can make a case for several potential winners of<br>the expanded European Championships.</p>--}}
                            {{--<a href="{{ route('event') }}" class="btn btn-primary btn-lg">Read More</a>--}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="item darkerskyblue" data-ride="carousel" data-interval="1000">
                <div class="carousel-caption">
                    {{--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>--}}
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="slider-contant" data-animation="animated fadeInRight">
                            {{--<h3>If you Don’t Practice<br>You <span class="color-yellow">Don’t Derserve</span><br>to win!</h3>--}}
                            {{--<p class="text-center">You can make a case for several potential winners of<br>the expanded European Championships.</p>--}}
                            {{--<a href="{{ route('event') }}" class="btn btn-primary btn-lg">Read More</a>--}}
                        </div>
                    </div>
                </div>
            </div>
            
             <div class="item darkdeepskyblue" data-ride="carousel" data-interval="1000">
                <div class="carousel-caption">
                    {{--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>--}}
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="slider-contant" data-animation="animated fadeInRight">
                            {{--<h3>If you Don’t Practice<br>You <span class="color-yellow">Don’t Derserve</span><br>to win!</h3>--}}
                            {{--<p class="text-center">You can make a case for several potential winners of<br>the expanded European Championships.</p>--}}
                            {{--<a href="{{ route('event') }}" class="btn btn-primary btn-lg">Read More</a>--}}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="news">
        <div class="container">
            <div class="heading-slider">
                <p class="headline"><i class="fa fa-star" aria-hidden="true"></i> Top Headlines :</p>

                <h1>
                    <a href="" class="typewrite" data-period="2000" data-type='[ "Our winter practice will start from 16 Oct 2024 at Myyrmaki Hall, Raappavuorentie 10, Vantaa", Practice will be every Wednesday from 20:00 to 21:30 "You all are welcome to the practice session."]'>
                        <span class="wrap"></span>
                    </a>
                </h1>
                <span class="wrap"></span>

            </div>
        </div>
    </div>

</div>


<script>
    $(document).ready(function(){
        $('.carousel').carousel();
    });
</script>