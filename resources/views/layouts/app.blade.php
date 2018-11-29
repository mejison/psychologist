<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name=description content="Specialistuddannelse" />
        <meta name="keywords" content="Specialistuddannelse" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Specialistuddannelse</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/all.css')}}" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet" />
        @stack('app-styles')
    </head>
    <body class="application">
        <div class="arrow-section text-center">
            <img src="/image/feedback-tag-skriv.png" alt="arrow" />
        </div>
        <section class="message" id="support-message">
            <div class="overlay">
            </div>
            <div class="overlayMenu">
            </div>
            <a href="javascript:;" class="message-button open-popup" id="support-btn">
                <img src="/image/message.png" alt="message" />
            </a>
            <div class="message-content" id="message-content">
                <h3>SKRIV DIN KOMMENTAR</h3>
                
                <p>Hej {{Auth::user()->getFullName()}}</p>
                <p>Hjælp os med at gøre siden endnu bedre - giv os din feedback.</p>
                <p> Vi sætter stor pris på din feedback og det hjælper med at udvikle siden endnu mere, så skriv til os med ris, ros og gode forslag til, hvordan vi forbedrer brugervenlighed og funktionerne på siden.</p>

                

                <form>
                    <textarea name="message" id="messageComment" placeholder="skriv..."></textarea>
                    <button type="submit" id="sendComment" class="button light-green ">send</button>
                </form>
            </div>
        </section>
        <div id="app">
            @include("global.partials.headerApplication")
            <div class="container-fluid content-box">
                @if(Auth::user()->hasRole('supervisor') || Auth::user()->hasRole('courseOrganizer'))
                    <sidebarformanagers></sidebarformanagers>
                @else
                <aside class="sidebar">
                    @include('global.partials.sidebar')
                </aside>
                @endif
                <section class="content">
                    <router-view v-on:increment="incrementTotal"></router-view>
                </section>
            </div>
        </div>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
