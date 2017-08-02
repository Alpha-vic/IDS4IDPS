@extends('layouts.auth')

@section('content')
    <div class="sh-50vh">

    </div>
    <div class="container white margin-btm-2em">
        <div class="col-xs-12 col-md-8">
            <h3 class="text-center">
                Design and Implementation of a Web Based Fingerprint and Facial
                Identification System for Enhancing Security of Internally
                Displaced Persons (IDPs) in North-East Nigeria
            </h3>
            <!--
            <h4 class="text-center">BY UMAR MUSA IBRAHIM (PG/MSC/15/76718)</h4>
            <hr/>
            <p class="text-justify">
                There are provisions for accommodating Internally Displaced Persons (IDPs)
                in Northern Nigeria. However, there are some challenges in the camps where
                these IDPs are accommodated. They include issues such as killings, kidnappings,
                stealing, rapes, shortage of foods, and diversion of relief materials, among others.
                These challenges have made life difficult for the Donor Agencies and the government
                at large in managing the camps with respect to security provision and the circulation
                of relief supplies to the IDPs. This study notes that the existing manual method of
                keeping records of IDPs in the camps is tedious and allows insecurity and improper
                documentation. A new application which provides a means of ensuring adequate
                documentations of IDPs by capturing the necessary data that ensures the proper
                identification and accounting of the IDPs is developed. Also, the use of fingerprint
                identification system which is a form of biometric identification is embedded in
                this application. The application utilizes a portable fingerprint scanner as its
                input in acquiring fingerprint images. It verifies the fingerprint by displaying
                the associated image and other personal details of the internally displaced person.
                The system is also capable of querying the database for the IDPs. The intended system
                is a web base system developed using PHP, CSS, JAVA and MYSQL as database. Object
                Oriented Analysis and Design Methodology (OOADM) were used to analyze the system
                and Unified Modeling Language (UML) is used to model the software. The information
                generated from the enrollment and biometric capturing of IDPs in the developed
                system will effectively verifies and identifies the IDPs. This developed system
                will be used to enhance the security, distribution of relief materials and
                managing of IDPs in the camps. This study has shown that the new developed
                system is more accurate, efficient and effective than the manual system used in the camps.
            </p>
            -->
        </div>
        <div class="col-xs-12 col-md-4">
            <p class="text-center padding-top-2em">
                <a class="btn btn-primary" href="{{route('auth.login')}}">
                    NEMA STAFF LOGIN
                </a>
            </p>
        </div>
    </div>
@endsection

@section('extra_scripts')
    @parent
    <script type="text/javascript" src="{{asset('js/backstretch/jquery.backstretch.min.js')}}"></script>
    <script type="text/javascript">
      $('.carousel').carousel();
      var WIN = $(window);
      var carouselContainer = $('body');
      $(WIN).on('load', function () {
        carouselContainer.backstretch([
            "{{asset('images/slides/slide-1.jpg')}}",
            "{{asset('images/slides/slide-2.jpg')}}"
          ],
          {duration: 5000, fade: 500, scale: 'fit-smaller'}
        );
      });
    </script>
@endsection
