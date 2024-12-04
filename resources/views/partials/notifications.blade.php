<div id="notification_bell" class="btn-group dropstart">
    <button class="btn dropdown-toggle dropstart" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-bell"></i>
    </button>
    <aside id="notifications" class="dropdown-menu">
        <div id="notification_cards">
            @foreach($notifications as $notification)
                @include('partials.notification')
        @endforeach
        </div>
    </aside> 
</div>